<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Asrama;
use App\Models\Kobong;
use App\Models\MutasiSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class SekretarisController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        // Cache all KPI queries for 5 minutes
        $totalSantri = Cache::remember('sekretaris_total_santri', 300, function() {
            return Santri::where('is_active', true)->count();
        });
        
        $santriPutra = Cache::remember('sekretaris_santri_putra', 300, function() {
            return Santri::where('is_active', true)->where('gender', 'putra')->count();
        });
        
        $santriPutri = Cache::remember('sekretaris_santri_putri', 300, function() {
            return Santri::where('is_active', true)->where('gender', 'putri')->count();
        });
        
        $jumlahAsrama = Cache::remember('sekretaris_jumlah_asrama', 300, function() {
            return Asrama::count();
        });
        
        $jumlahKelas = Cache::remember('sekretaris_jumlah_kelas', 300, function() {
            return Kelas::count();
        });
        
        $jumlahKobong = Cache::remember('sekretaris_jumlah_kobong', 300, function() {
            return Kobong::count();
        });
        
        return view('sekretaris.dashboard.index', compact(
            'totalSantri',
            'santriPutra',
            'santriPutri',
            'jumlahAsrama',
            'jumlahKelas',
            'jumlahKobong'
        ));
    }
    
    // Data Santri - Index
    public function dataSantri(Request $request)
    {
        $query = Santri::with(['kelas', 'asrama', 'kobong']);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama_santri', 'like', "%{$search}%");
            });
        }
        
        // Filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('asrama_id')) {
            $query->where('asrama_id', $request->asrama_id);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }
        
        $santri = $query->latest()->paginate(35);
        $kelasList = Kelas::all();
        $asramaList = Asrama::all();
        
        return view('sekretaris.data-santri.index', compact('santri', 'kelasList', 'asramaList'));
    }
    
    // Data Santri - Create Form
    public function createSantri()
    {
        $kelasList = Kelas::all();
        $asramaList = Asrama::all();
        
        return view('sekretaris.data-santri.create', compact('kelasList', 'asramaList'));
    }
    
    // Data Santri - Store
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
        MutasiSantri::create([
            'santri_id' => $santri->id,
            'jenis_mutasi' => 'masuk',
            'tanggal_mutasi' => now(),
            'keterangan' => 'Santri baru masuk',
        ]);
        
        // Send Telegram notification
        try {
            $telegram = new \App\Services\TelegramService();
            $kelas = Kelas::find($validated['kelas_id']);
            $asrama = Asrama::find($validated['asrama_id']);
            
            $telegram->notifySantriRegistration([
                'nama' => $validated['nama_santri'],
                'jenis_kelamin' => ucfirst($validated['gender']),
                'kelas' => $kelas->nama_kelas ?? '-',
                'asrama' => $asrama->nama_asrama ?? '-',
            ]);
        } catch (\Exception $e) {
            Log::warning('Telegram notification failed: ' . $e->getMessage());
        }
        
        return redirect()->route('sekretaris.data-santri')
            ->with('success', 'Data santri berhasil ditambahkan');
    }
    
    // Data Santri - Edit Form
    public function editSantri($id)
    {
        $santri = Santri::findOrFail($id);
        $kelasList = Kelas::all();
        $asramaList = Asrama::all();
        $kobongList = Kobong::where('asrama_id', $santri->asrama_id)->get();
        
        return view('sekretaris.data-santri.edit', compact('santri', 'kelasList', 'asramaList', 'kobongList'));
    }
    
    // Data Santri - Update
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
            'tanggal_lahir' => 'required|date',
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
        
        return redirect()->route('sekretaris.data-santri')
            ->with('success', 'Data santri berhasil diperbarui');
    }
    
    // Data Santri - Deactivate
    public function deactivateSantri($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->update(['is_active' => false]);
        
        // Create mutasi record
        MutasiSantri::create([
            'santri_id' => $id,
            'jenis_mutasi' => 'keluar',
            'tanggal_mutasi' => now(),
            'keterangan' => 'Santri dinonaktifkan',
        ]);
        
        return redirect()->route('sekretaris.data-santri')
            ->with('success', 'Santri berhasil dinonaktifkan');
    }
    
    // Get Kobong by Asrama (AJAX)
    public function getKobongByAsrama($asramaId)
    {
        $kobong = Kobong::where('asrama_id', $asramaId)->get();
        return response()->json($kobong);
    }
    
    // Mutasi Santri
    public function mutasiSantri()
    {
        $santriAktif = Santri::where('is_active', true)->get();
        $mutasi = MutasiSantri::with('santri')->latest()->paginate(15);
        
        return view('sekretaris.mutasi.index', compact('santriAktif', 'mutasi'));
    }
    
    // Store Mutasi
    public function storeMutasi(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis_mutasi' => 'required|in:masuk,keluar,pindah_kelas,pindah_asrama',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
            'dari' => 'nullable|string',
            'ke' => 'nullable|string',
        ]);
        
        $mutasi = MutasiSantri::create($validated);
        
        // Update santri status if keluar
        if ($request->jenis_mutasi === 'keluar') {
            Santri::find($request->santri_id)->update(['is_active' => false]);
        }
        
        // Send Telegram notification
        try {
            $telegram = new \App\Services\TelegramService();
            $santri = Santri::find($validated['santri_id']);
            $jenisMutasi = [
                'masuk' => '📥 Masuk',
                'keluar' => '📤 Keluar',
                'pindah_kelas' => '🔄 Pindah Kelas',
                'pindah_asrama' => '🏠 Pindah Asrama'
            ];
            
            $icon = $validated['jenis_mutasi'] === 'keluar' ? '⚠️' : '📋';
            $telegram->notify(
                'MUTASI SANTRI',
                "👤 Nama: {$santri->nama_santri}\n" .
                "📊 Jenis: {$jenisMutasi[$validated['jenis_mutasi']]}\n" .
                ($validated['dari'] ? "⬅️ Dari: {$validated['dari']}\n" : "") .
                ($validated['ke'] ? "➡️ Ke: {$validated['ke']}\n" : "") .
                "📅 Tanggal: " . date('d M Y', strtotime($validated['tanggal_mutasi'])),
                $icon
            );
        } catch (\Exception $e) {
            Log::warning('Telegram notification failed: ' . $e->getMessage());
        }
        
        return redirect()->route('sekretaris.mutasi-santri')
            ->with('success', 'Mutasi santri berhasil dicatat');
    }
    
    // Update Mutasi
    public function updateMutasi(Request $request, $id)
    {
        $mutasi = MutasiSantri::findOrFail($id);
        
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis_mutasi' => 'required|in:masuk,keluar,pindah_kelas,pindah_asrama',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
            'dari' => 'nullable|string',
            'ke' => 'nullable|string',
        ]);
        
        $mutasi->update($validated);
        
        return redirect()->route('sekretaris.mutasi-santri')
            ->with('success', 'Data mutasi berhasil diperbarui');
    }
    
    // Delete Mutasi
    public function destroyMutasi($id)
    {
        $mutasi = MutasiSantri::findOrFail($id);
        $mutasi->delete();
        
        return redirect()->route('sekretaris.mutasi-santri')
            ->with('success', 'Data mutasi berhasil dihapus');
    }
    
    // Laporan
    public function laporan()
    {
        return view('sekretaris.laporan.index');
    }
    
    // Export Laporan Data Santri (PDF)
    public function exportLaporanSantri(Request $request)
    {
        $santri = Santri::with(['kelas', 'asrama', 'kobong'])->where('is_active', true)->get();
        
        $pdf = Pdf::loadView('sekretaris.laporan.laporan-santri-pdf', compact('santri'));
        $pdf->setPaper('a4', 'landscape');

        $filename = 'laporan-santri.pdf';
        
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
    
    // Export Statistik Santri per Kelas
    public function exportStatistikKelas()
    {
        $kelasList = Kelas::all();
        $statistik = [];
        
        foreach ($kelasList as $kelas) {
            $totalPutra = Santri::where('kelas_id', $kelas->id)
                ->where('gender', 'putra')
                ->where('is_active', true)
                ->count();
            
            $totalPutri = Santri::where('kelas_id', $kelas->id)
                ->where('gender', 'putri')
                ->where('is_active', true)
                ->count();
            
            $statistik[] = [
                'kelas' => $kelas->nama_kelas,
                'tingkat' => $kelas->tingkat,
                'putra' => $totalPutra,
                'putri' => $totalPutri,
                'total' => $totalPutra + $totalPutri,
            ];
        }
        
        $pdf = Pdf::loadView('sekretaris.laporan.statistik-kelas-pdf', compact('statistik'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'statistik-santri-per-kelas.pdf';
        
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
    
    // Export Statistik Santri per Asrama
    public function exportStatistikAsrama()
    {
        $asramaList = Asrama::with('kobong')->get();
        $statistik = [];
        
        foreach ($asramaList as $asrama) {
            $totalSantri = Santri::where('asrama_id', $asrama->id)
                ->where('is_active', true)
                ->count();
            
            $kobongData = [];
            foreach ($asrama->kobong as $kobong) {
                $jumlahSantri = Santri::where('kobong_id', $kobong->id)
                    ->where('is_active', true)
                    ->count();
                
                $kobongData[] = [
                    'nomor' => $kobong->nomor_kobong,
                    'jumlah_santri' => $jumlahSantri,
                    'kapasitas' => 20,
                    'sisa_kapasitas' => 20 - $jumlahSantri,
                ];
            }
            
            $statistik[] = [
                'asrama' => $asrama->nama_asrama,
                'gender' => $asrama->gender,
                'total_santri' => $totalSantri,
                'total_kobong' => $asrama->kobong->count(),
                'kobong_detail' => $kobongData,
            ];
        }
        
        $pdf = Pdf::loadView('sekretaris.laporan.statistik-asrama-pdf', compact('statistik'));
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'statistik-santri-per-asrama.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
    
    // Export Laporan Mutasi Santri
    public function exportLaporanMutasi(Request $request)
    {
        $query = MutasiSantri::with('santri');
        
        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_mutasi', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_mutasi', '<=', $request->tanggal_selesai);
        }
        
        // Filter by jenis mutasi
        if ($request->filled('jenis_mutasi')) {
            $query->where('jenis_mutasi', $request->jenis_mutasi);
        }
        
        $mutasi = $query->orderBy('tanggal_mutasi', 'desc')->get();
        
        $tanggalMulai = $request->tanggal_mulai ?? 'Awal';
        $tanggalSelesai = $request->tanggal_selesai ?? 'Sekarang';
        
        $pdf = Pdf::loadView('sekretaris.laporan.mutasi-pdf', compact('mutasi', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'laporan-mutasi-santri.pdf';
        
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
    
    // Download Template Excel
    public function downloadTemplateExcel()
    {
        $kelasList = Kelas::all();
        $asramaList = Asrama::all();
        
        $html = view('sekretaris.template-import-excel', compact('kelasList', 'asramaList'))->render();
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="template-import-santri.xls"');
    }
    
    // Download Template CSV
    public function downloadTemplateCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-import-santri.csv"',
        ];
        
        $columns = [
            'NIS',
            'Nama Santri',
            'Gender (putra/putri)',
            'Negara',
            'Provinsi',
            'Kota/Kabupaten',
            'Kecamatan',
            'Desa/Kampung',
            'RT/RW',
            'Nama Ortu/Wali',
            'No HP Ortu/Wali',
            'Kelas ID',
            'Asrama ID',
            'Kobong ID',
            'Tanggal Masuk (YYYY-MM-DD)',
        ];
        
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            // Add example row
            fputcsv($file, [
                '2025001',
                'Ahmad Santoso',
                'putra',
                'Indonesia',
                'Jawa Timur',
                'Surabaya',
                'Gubeng',
                'Airlangga',
                '001/002',
                'Bapak Ahmad',
                '081234567890',
                '1',
                '1',
                '1',
                '2025-07-01',
            ]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    // Import Santri from Excel/CSV
    public function importSantri(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx|max:2048',
        ]);
        
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        $imported = 0;
        $errors = [];
        
        try {
            if ($extension === 'csv') {
                $handle = fopen($file->getRealPath(), 'r');
                $header = fgetcsv($handle); // Skip header
                
                while (($row = fgetcsv($handle)) !== false) {
                    if (count($row) < 14) continue; // Skip incomplete rows
                    
                    try {
                        $santri = Santri::create([
                            'nis' => $row[0],
                            'nama_santri' => $row[1],
                            'gender' => $row[2],
                            'negara' => $row[3],
                            'provinsi' => $row[4],
                            'kota_kabupaten' => $row[5],
                            'kecamatan' => $row[6],
                            'desa_kampung' => $row[7],
                            'rt_rw' => $row[8],
                            'nama_ortu_wali' => $row[9],
                            'no_hp_ortu_wali' => $row[10],
                            'kelas_id' => $row[11],
                            'asrama_id' => $row[12],
                            'kobong_id' => $row[13],
                            'tanggal_masuk' => isset($row[14]) ? $row[14] : now(),
                            'is_active' => true,
                        ]);
                        
                        // Create mutasi record
                        MutasiSantri::create([
                            'santri_id' => $santri->id,
                            'jenis_mutasi' => 'masuk',
                            'tanggal_mutasi' => now(),
                            'keterangan' => 'Import data santri',
                        ]);
                        
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Baris NIS {$row[0]}: " . $e->getMessage();
                    }
                }
                
                fclose($handle);
            } else {
                // Handle Excel files (simple HTML table parsing)
                $content = file_get_contents($file->getRealPath());
                return redirect()->route('sekretaris.data-santri')
                    ->with('error', 'Format Excel belum didukung. Gunakan CSV untuk saat ini.');
            }
            
            $message = "Berhasil import {$imported} santri.";
            if (count($errors) > 0) {
                $message .= " Gagal: " . count($errors) . " baris.";
            }
            
            return redirect()->route('sekretaris.data-santri')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->route('sekretaris.data-santri')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
