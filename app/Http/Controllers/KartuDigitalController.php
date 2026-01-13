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

    public function previewPdf($id)
    {
        $santri = Santri::findOrFail($id);
        
        // Generate QR Code as Base64 (Safe for PDF)
        $qrData = $santri->nis . ' - ' . $santri->nama_santri;
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrData) . "&size=300&margin=1&ecLevel=H";
        
        $qrBase64 = null;
        try {
            $context = stream_context_create(['http' => ['timeout' => 5]]);
            $qrContent = @file_get_contents($qrUrl, false, $context);
            if ($qrContent) {
                 $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
            }
        } catch (\Exception $e) {
            // Silently fail for QR to avoid breaking the PDF
        }

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('sekretaris.kartu-digital.pdf', compact('santri', 'qrBase64'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Kartu-Syahriah-' . $santri->nis . '.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }

    public function downloadPdf($id)
    {
        $santri = Santri::findOrFail($id);

        // Generate QR Code as Base64 (Safe for PDF)
        $qrData = $santri->nis . ' - ' . $santri->nama_santri;
        // Same logic as preview - ideally refactor to private method but keeping inline for "No Theory" rule compliance
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrData) . "&size=300&margin=1&ecLevel=H";
        
        $qrBase64 = null;
        try {
            $context = stream_context_create(['http' => ['timeout' => 5]]);
            $qrContent = @file_get_contents($qrUrl, false, $context);
             if ($qrContent) {
                 $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
            }
        } catch (\Exception $e) {
             // Silently fail
        }

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->loadView('sekretaris.kartu-digital.pdf', compact('santri', 'qrBase64'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Kartu-Syahriah-' . $santri->nis . '.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
