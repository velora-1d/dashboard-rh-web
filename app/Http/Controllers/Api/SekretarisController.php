<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Perizinan;

class SekretarisController extends Controller
{
    public function dashboard()
    {
        $totalSantri = Santri::where('is_active', true)->count();
        $putra = Santri::where('is_active', true)->where('gender', 'putra')->count();
        $putri = Santri::where('is_active', true)->where('gender', 'putri')->count();
        $kelas = \App\Models\Kelas::count();
        $asrama = \App\Models\Asrama::count();
        $kobong = \App\Models\Kobong::count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_santri' => $totalSantri,
                'putra' => $putra,
                'putri' => $putri,
                'total_kelas' => $kelas,
                'total_asrama' => $asrama,
                'total_kamar' => $kobong,
            ]
        ]);
    }

    public function getFilters()
    {
        $kelas = \App\Models\Kelas::select('id', 'nama_kelas')->get();
        $asrama = \App\Models\Asrama::select('id', 'nama_asrama')->get();
        $kobong = \App\Models\Kobong::select('id', 'asrama_id', 'nomor_kobong')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'kelas' => $kelas,
                'asrama' => $asrama,
                'kobong' => $kobong,
                'gender' => [
                    ['id' => 'putra', 'label' => 'Putra'],
                    ['id' => 'putri', 'label' => 'Putri'],
                ]
            ]
        ]);
    }

    public function index(Request $request)
    {
        $query = Santri::where('is_active', true); // Default only active, unless specified

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('asrama_id')) {
            $query->where('asrama_id', $request->asrama_id);
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        // Return FULL details for Mobile Edit & ID Card
        $santri = $query->with(['kelas:id,nama_kelas', 'kobong:id,nomor_kobong', 'asrama:id,nama_asrama'])
            ->orderBy('nama_santri', 'asc')
            ->take(50)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $santri->map(function($s) {
                return [
                    'id' => $s->id,
                    'nama' => $s->nama_santri,
                    'nis' => $s->nis,
                    'kelas' => $s->kelas->nama_kelas ?? '-',
                    'kamar' => $s->kobong->nomor_kobong ?? '-',
                    'asrama' => $s->asrama->nama_asrama ?? '-',
                    'foto_path' => $s->foto_path ?? '',
                    'is_active' => $s->is_active,
                    'virtual_account_number' => $s->virtual_account_number,
                    
                    // Detail fields for Edit Form
                    'negara' => $s->negara,
                    'provinsi' => $s->provinsi,
                    'kota_kabupaten' => $s->kota_kabupaten,
                    'kecamatan' => $s->kecamatan,
                    'desa_kampung' => $s->desa_kampung,
                    'rt_rw' => $s->rt_rw,
                    'nama_ortu_wali' => $s->nama_ortu_wali,
                    'no_hp_ortu_wali' => $s->no_hp_ortu_wali,
                    'asrama_id' => $s->asrama_id,
                    'kobong_id' => $s->kobong_id,
                    'kelas_id' => $s->kelas_id,
                    'gender' => $s->gender,

                    'tanggal_masuk' => $s->tanggal_masuk ? \Carbon\Carbon::parse($s->tanggal_masuk)->format('Y-m-d') : null,
                    'foto_url' => $s->foto_url,
                ];
            })
        ]);
    }


    public function perizinan()
    {
        $perizinan = Perizinan::with(['santri'])
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $perizinan->map(function($p) {
                return [
                    'id' => $p->id,
                    'nama_santri' => $p->santri->nama_santri ?? 'N/A',
                    'alasan' => $p->alasan,
                    'tgl_pulang' => $p->tgl_pulang,
                    'tgl_kembali' => $p->tgl_kembali,
                    'status' => $p->status,
                ];
            })
        ]);
    }

    public function storePerizinan(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'alasan' => 'required|string',
            'tgl_pulang' => 'required|date',
            'tgl_kembali' => 'required|date',
        ]);

        $perizinan = Perizinan::create([
            'santri_id' => $request->santri_id,
            'alasan' => $request->alasan,
            'tgl_pulang' => $request->tgl_pulang,
            'tgl_kembali' => $request->tgl_kembali,
            'status' => 'aktif',
        ]);

        // Create In-App Notification
        $santri = Santri::find($request->santri_id);
        \App\Models\Notification::create([
            'type' => 'perizinan',
            'title' => 'Perizinan Baru',
            'message' => "Izin baru diajukan untuk {$santri->nama_santri}: {$request->alasan}",
            'icon' => 'clock',
            'color' => '#f59e0b',
            'role' => 'sekretaris',
            'data' => [
                'perizinan_id' => $perizinan->id,
                'santri_id' => $santri->id,
            ],
        ]);

        // Notify Admins & Sekretaris (FCM)
        $users = \App\Models\User::whereIn('role', ['admin', 'sekretaris'])
            ->whereNotNull('fcm_token')
            ->where('id', '!=', \Illuminate\Support\Facades\Auth::id())
            ->get();
            
        $fcm = new \App\Services\FcmService();
        foreach ($users as $user) {
            $fcm->sendNotification(
                $user->fcm_token,
                '📝 Perizinan Baru',
                "Izin baru diajukan a.n {$santri->nama_santri}: {$request->alasan}",
                ['type' => 'perizinan', 'id' => $perizinan->id]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data perizinan berhasil disimpan',
            'data' => $perizinan
        ]);
    }
    public function storeSantri(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:santri,nis',
            'nama_santri' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa_kampung' => 'required|string|max:255',
            'rt_rw' => 'required|string|max:50',
            'nama_ortu_wali' => 'required|string|max:255',
            'no_hp_ortu_wali' => 'required|string|max:20',
            'asrama_id' => 'required|exists:asrama,id',
            'kobong_id' => 'required|exists:kobong,id',
            'kelas_id' => 'required|exists:kelas,id',
            'gender' => 'required|in:putra,putri',
            'tanggal_masuk' => 'required|date',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/santri-photos', $filename);
            $validated['foto'] = $filename;
        }

        $santri = Santri::create($validated);

        // Create mutasi record
        \App\Models\MutasiSantri::create([
            'santri_id' => $santri->id,
            'jenis_mutasi' => 'masuk',
            'tanggal_mutasi' => now(),
            'keterangan' => 'Pendaftaran via Mobile',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data santri berhasil ditambahkan',
            'data' => $santri
        ]);
    }

    public function updateSantri(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|unique:santri,nis,' . $id,
            'nama_santri' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa_kampung' => 'required|string|max:255',
            'rt_rw' => 'required|string|max:50',
            'nama_ortu_wali' => 'required|string|max:255',
            'no_hp_ortu_wali' => 'required|string|max:20',
            'asrama_id' => 'required|exists:asrama,id',
            'kobong_id' => 'required|exists:kobong,id',
            'kelas_id' => 'required|exists:kelas,id',
            'gender' => 'required|in:putra,putri',
            'tanggal_masuk' => 'required|date',
            'tanggal_lahir' => 'required|date', // Added validation
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($santri->foto && \Illuminate\Support\Facades\Storage::exists('public/santri-photos/' . $santri->foto)) {
                \Illuminate\Support\Facades\Storage::delete('public/santri-photos/' . $santri->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/santri-photos', $filename);
            $validated['foto'] = $filename;
        }

        $santri->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data santri berhasil diperbarui',
            'data' => $santri
        ]);
    }

    public function deactivateSantri($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->update(['is_active' => false]);

        // Create mutasi record
        \App\Models\MutasiSantri::create([
            'santri_id' => $id,
            'jenis_mutasi' => 'keluar',
            'tanggal_mutasi' => now(),
            'keterangan' => 'Dinonaktifkan via Mobile',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Santri berhasil dinonaktifkan'
        ]);
    }

    public function updatePerizinan(Request $request, $id)
    {
        $perizinan = Perizinan::findOrFail($id);
        
        $request->validate([
            'alasan' => 'required|string',
            'tgl_pulang' => 'required|date',
            'tgl_kembali' => 'required|date',
        ]);

        $perizinan->update([
            'alasan' => $request->alasan,
            'tgl_pulang' => $request->tgl_pulang,
            'tgl_kembali' => $request->tgl_kembali,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data perizinan berhasil diperbarui',
            'data' => $perizinan
        ]);
    }

    public function destroyPerizinan($id)
    {
        $perizinan = Perizinan::findOrFail($id);
        $perizinan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data perizinan berhasil dihapus'
        ]);
    }

    public function approvePerizinan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update([
            'status' => $request->status,
            'approved_by' => \Illuminate\Support\Facades\Auth::id()
        ]);

        // Notify Admins & Sekretaris (FCM)
        $users = \App\Models\User::whereIn('role', ['admin', 'sekretaris'])
            ->whereNotNull('fcm_token')
            ->where('id', '!=', \Illuminate\Support\Facades\Auth::id())
            ->get();
            
        $fcm = new \App\Services\FcmService();
        $statusLabel = $request->status == 'Disetujui' ? 'disetujui' : 'ditolak';
        $emoji = $request->status == 'Disetujui' ? '✅' : '❌';
        
        foreach ($users as $user) {
            $fcm->sendNotification(
                $user->fcm_token,
                $emoji . ' Update Perizinan',
                "Izin a.n {$perizinan->santri->nama_santri} telah {$statusLabel}.",
                ['type' => 'perizinan', 'id' => $perizinan->id, 'status' => $statusLabel]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => "Perizinan berhasil " . strtolower($request->status)
        ]);
    }

    public function getResumeLaporan() 
    {
        $totalSantri = Santri::where('is_active', true)->count();
        $izinAktif = Perizinan::where('status', 'Disetujui')
            ->whereDate('tgl_kembali', '>=', now())
            ->count();
            
        // Santri Libur logic (e.g. status 'Nonaktif' or specific permit?)
        // Assuming 'izin_aktif' covers those away. 
        // Or if 'Libur' means mass vacation? 
        // Let's assume 'Santri Libur' is same as 'Izin Aktif' for now, or just 0 if no holiday mode.
        // Actually, let's count santri who are currently AWAY (Izin approved and today is within range).
        $santriLibur = $izinAktif; 

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_santri' => $totalSantri,
                'izin_aktif' => $izinAktif,
                'santri_libur' => $santriLibur
            ]
        ]);
    }

    public function getLaporanUrl(Request $request)
    {
        // Generate Signed URL for downloading PDF
        // This avoids auth issues when downloading file in external browser
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'api.sekretaris.download-laporan', 
            now()->addMinutes(30),
            ['type' => $request->type ?? 'semua']
        );

        return response()->json([
            'status' => 'success',
            'data' => ['url' => $url]
        ]);
    }

    public function downloadLaporan(Request $request)
    {
        // This would reuse the Web Controller logic or duplicate it
        // Ideally reuse logic. For now, simple PDF generation.
        // Assuming logic similar to Web's SekretarisController::exportPdf
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('sekretaris.laporan.laporan-santri-pdf', [
            'santri' => Santri::all(),
            'title' => 'Laporan Data Santri'
        ]);
        
        return $pdf->download('laporan_santri.pdf');
    }
}

