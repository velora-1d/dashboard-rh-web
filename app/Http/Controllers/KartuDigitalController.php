<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Kelas;
use PDF;

class KartuDigitalController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $santris = $query->where('is_active', true)
                        ->orderBy('nama_santri', 'asc')
                        ->paginate(20);

        // Get lists for filters (borrowed logic from SekretarisController if needed, or simple query)
        $kelasList = Kelas::all();
        
        return view('sekretaris.kartu-digital.index', compact('santris', 'kelasList'));
    }

    public function downloadPdf($id)
    {
        $santri = Santri::findOrFail($id);

        // Generate QR Code as Base64 to ensure it renders in PDF
        $qrData = $santri->nis . ' - ' . $santri->nama_santri;
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrData) . "&size=300&margin=1&ecLevel=H";
        
        try {
            // Fetch image with 5 second timeout
            $context = stream_context_create(['http' => ['timeout' => 5]]);
            $qrContent = file_get_contents($qrUrl, false, $context);
            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
        } catch (\Exception $e) {
            // Fallback if API fails (transparent pixel or simple error placeholder)
            $qrBase64 = null; 
        }

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('sekretaris.kartu-digital.pdf', compact('santri', 'qrBase64'));
        
        // Horizontal Card (CR-80 size equivalent scaling)
        $pdf->setPaper('A4', 'portrait'); 

        return $pdf->download('Kartu-Syahriah-' . $santri->nis . '.pdf');
    }

    public function previewPdf($id)
    {
        $santri = Santri::findOrFail($id);
        
        // Generate QR Code as Base64 to ensure it renders in PDF
        $qrData = $santri->nis . ' - ' . $santri->nama_santri;
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrData) . "&size=300&margin=1&ecLevel=H";
        
        try {
            $context = stream_context_create(['http' => ['timeout' => 5]]);
            $qrContent = file_get_contents($qrUrl, false, $context);
            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
        } catch (\Exception $e) {
            $qrBase64 = null;
        }

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('sekretaris.kartu-digital.pdf', compact('santri', 'qrBase64'));
        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Kartu-Syahriah-' . $santri->nis . '.pdf');
    }
}
