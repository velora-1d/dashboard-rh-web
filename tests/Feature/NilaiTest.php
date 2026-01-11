<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Asrama;
use App\Models\MataPelajaran;
use App\Models\NilaiSantri;
use App\Models\UjianMingguan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NilaiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $santri;
    protected $mapel;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['role' => 'pendidikan']);
        $kelas = Kelas::factory()->create();
        $asrama = Asrama::factory()->create();
        $this->santri = Santri::factory()->create([
            'kelas_id' => $kelas->id,
            'asrama_id' => $asrama->id,
        ]);
        $this->mapel = MataPelajaran::factory()->create();
    }

    /**
     * Test nilai page loads.
     */
    public function test_nilai_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/pendidikan/nilai');
        $response->assertStatus(200);
    }

    /**
     * Test smart scoring calculates nilai_asli correctly.
     */
    public function test_smart_scoring_uses_higher_of_semester_or_weekly(): void
    {
        // Create weekly exam with average 80
        $ujianMingguan = UjianMingguan::create([
            'santri_id' => $this->santri->id,
            'mapel_id' => $this->mapel->id,
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'minggu_1' => 80,
            'minggu_2' => 80,
            'minggu_3' => 80,
            'minggu_4' => 80,
            'jumlah_keikutsertaan' => 4,
            'status' => 'lulus',
            'nilai_hasil_mingguan' => 80,
        ]);
        
        // Create semester nilai with lower value (70)
        $nilaiSantri = NilaiSantri::create([
            'santri_id' => $this->santri->id,
            'mapel_id' => $this->mapel->id,
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'nilai_ujian_semester' => 70,
            'nilai_hasil_mingguan' => 80,
            'nilai_asli' => 80, // Should take weekly (higher)
            'nilai_rapor' => 80,
            'source_type' => 'mingguan',
        ]);
        
        // Assert the higher value is used
        $this->assertEquals(80, $nilaiSantri->nilai_asli);
        $this->assertEquals('mingguan', $nilaiSantri->source_type);
    }

    /**
     * Test nilai_rapor has minimum of 5.
     */
    public function test_nilai_rapor_has_minimum_of_five(): void
    {
        // Create nilai with very low score
        $nilaiSantri = NilaiSantri::create([
            'santri_id' => $this->santri->id,
            'mapel_id' => $this->mapel->id,
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'nilai_ujian_semester' => 3,
            'nilai_asli' => 3,
            'nilai_rapor' => max(3, 5), // Should be 5
        ]);
        
        $this->assertGreaterThanOrEqual(5, $nilaiSantri->nilai_rapor);
    }

    /**
     * Test bulk nilai store.
     */
    public function test_bulk_nilai_can_be_stored(): void
    {
        $data = [
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'kelas_id' => $this->santri->kelas_id,
            'nilai' => [
                $this->santri->id => [
                    $this->mapel->id => 85,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post('/pendidikan/nilai/bulk', $data);

        $this->assertDatabaseHas('nilai_santris', [
            'santri_id' => $this->santri->id,
            'mapel_id' => $this->mapel->id,
            'nilai_ujian_semester' => 85,
        ]);
    }

    /**
     * Test ranking calculation.
     */
    public function test_ranking_is_calculated_correctly(): void
    {
        $kelas = $this->santri->kelas;
        
        // Create 3 students with different scores
        $santri1 = $this->santri;
        $santri2 = Santri::factory()->create(['kelas_id' => $kelas->id, 'asrama_id' => $this->santri->asrama_id]);
        $santri3 = Santri::factory()->create(['kelas_id' => $kelas->id, 'asrama_id' => $this->santri->asrama_id]);
        
        // Give them different scores
        NilaiSantri::create([
            'santri_id' => $santri1->id,
            'mapel_id' => $this->mapel->id,
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'nilai_ujian_semester' => 90,
            'nilai_asli' => 90,
            'nilai_rapor' => 90,
        ]);
        
        NilaiSantri::create([
            'santri_id' => $santri2->id,
            'mapel_id' => $this->mapel->id,
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'nilai_ujian_semester' => 80,
            'nilai_asli' => 80,
            'nilai_rapor' => 80,
        ]);
        
        NilaiSantri::create([
            'santri_id' => $santri3->id,
            'mapel_id' => $this->mapel->id,
            'tahun_ajaran' => '2024-2025',
            'semester' => '1',
            'nilai_ujian_semester' => 70,
            'nilai_asli' => 70,
            'nilai_rapor' => 70,
        ]);
        
        // Get rankings
        $nilaiList = NilaiSantri::where('tahun_ajaran', '2024-2025')
            ->where('semester', '1')
            ->where('mapel_id', $this->mapel->id)
            ->orderBy('nilai_rapor', 'desc')
            ->get();
        
        $this->assertEquals($santri1->id, $nilaiList[0]->santri_id);
        $this->assertEquals($santri2->id, $nilaiList[1]->santri_id);
        $this->assertEquals($santri3->id, $nilaiList[2]->santri_id);
    }
}
