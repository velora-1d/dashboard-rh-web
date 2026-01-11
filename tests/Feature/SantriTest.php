<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Asrama;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SantriTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $kelas;
    protected $asrama;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['role' => 'sekretaris']);
        $this->kelas = Kelas::factory()->create(['nama_kelas' => '1 Ibtida']);
        $this->asrama = Asrama::factory()->create(['nama_asrama' => 'Asrama A']);
    }

    /**
     * Test santri index page loads.
     */
    public function test_santri_index_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/sekretaris/data-santri');
        $response->assertStatus(200);
    }

    /**
     * Test santri can be created.
     */
    public function test_santri_can_be_created(): void
    {
        $santriData = [
            'nama_santri' => 'Ahmad Maulana',
            'nis' => '20250001',
            'gender' => 'putra',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2010-05-15',
            'alamat' => 'Jl. Raya No. 1',
            'no_hp_wali' => '081234567890',
            'kelas_id' => $this->kelas->id,
            'asrama_id' => $this->asrama->id,
            'status' => 'aktif',
        ];

        $response = $this->actingAs($this->user)->post('/sekretaris/data-santri', $santriData);

        $this->assertDatabaseHas('santris', [
            'nama_santri' => 'Ahmad Maulana',
            'nis' => '20250001',
        ]);
    }

    /**
     * Test santri can be updated.
     */
    public function test_santri_can_be_updated(): void
    {
        $santri = Santri::factory()->create([
            'kelas_id' => $this->kelas->id,
            'asrama_id' => $this->asrama->id,
        ]);

        $response = $this->actingAs($this->user)->put("/sekretaris/data-santri/{$santri->id}", [
            'nama_santri' => 'Updated Name',
            'nis' => $santri->nis,
            'gender' => $santri->gender,
            'kelas_id' => $this->kelas->id,
            'asrama_id' => $this->asrama->id,
            'status' => 'aktif',
        ]);

        $this->assertDatabaseHas('santris', [
            'id' => $santri->id,
            'nama_santri' => 'Updated Name',
        ]);
    }

    /**
     * Test santri can be deactivated.
     */
    public function test_santri_can_be_deactivated(): void
    {
        $santri = Santri::factory()->create([
            'kelas_id' => $this->kelas->id,
            'asrama_id' => $this->asrama->id,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($this->user)->delete("/sekretaris/data-santri/{$santri->id}");

        $this->assertDatabaseHas('santris', [
            'id' => $santri->id,
            'status' => 'tidak_aktif',
        ]);
    }

    /**
     * Test santri NIS must be unique.
     */
    public function test_santri_nis_must_be_unique(): void
    {
        Santri::factory()->create([
            'nis' => '20250001',
            'kelas_id' => $this->kelas->id,
            'asrama_id' => $this->asrama->id,
        ]);

        $response = $this->actingAs($this->user)->post('/sekretaris/data-santri', [
            'nama_santri' => 'Another Student',
            'nis' => '20250001', // Duplicate
            'gender' => 'putra',
            'kelas_id' => $this->kelas->id,
            'asrama_id' => $this->asrama->id,
            'status' => 'aktif',
        ]);

        $response->assertSessionHasErrors('nis');
    }
}
