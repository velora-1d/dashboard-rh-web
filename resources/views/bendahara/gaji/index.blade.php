@extends('layouts.app')

@section('title', 'Gaji Pegawai')
@section('page-title', 'Gaji Pegawai')

@section('sidebar-menu')
    @include('bendahara.partials.sidebar-menu')
@endsection

@section('content')
    <!-- Header Banner -->
    <div style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); border-radius: 20px; padding: 40px; margin-bottom: 32px; box-shadow: 0 20px 40px rgba(99, 102, 241, 0.25); position: relative; overflow: hidden; color: white;">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(40px);"></div>
        <div style="position: absolute; bottom: -30px; left: 15%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 24px;">
            <div style="background: rgba(255,255,255,0.2); width: 72px; height: 72px; border-radius: 18px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);">
                <i data-feather="briefcase" style="width: 36px; height: 36px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.025em;">Penggajian Pegawai</h2>
                <p style="font-size: 1.1rem; opacity: 0.95; font-weight: 400;">Kelola pembayaran gaji dan honorarium asatidz serta staf pesantren secara transparan.</p>
            </div>
        </div>
        <div style="position: absolute; right: 40px; bottom: -20px; opacity: 0.15;">
            <i data-feather="briefcase" style="width: 180px; height: 180px; transform: rotate(-15deg);"></i>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #eef2ff; border-left: 4px solid #6366f1; color: #3730a3; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <i data-feather="check-circle" style="width: 20px; height: 20px;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden;">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #eef2ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-feather="plus-circle" style="width: 20px; height: 20px; color: #6366f1;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e2937;">Tambah Data Gaji</h3>
                </div>
            </div>
            <div style="padding: 24px;">
                <form method="POST" action="{{ route('bendahara.gaji.store') }}">
                    @csrf
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Pilih Pegawai <span style="color: #ef4444;">*</span></label>
                            <select name="pegawai_id" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach($pegawaiList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pegawai }} - {{ $p->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Bulan <span style="color: #ef4444;">*</span></label>
                            <select name="bulan" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tahun <span style="color: #ef4444;">*</span></label>
                            <input type="number" name="tahun" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 32px;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nominal Gaji (Rp) <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="nominal" class="format-rupiah" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" placeholder="0" required>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Status <span style="color: #ef4444;">*</span></label>
                            <select name="is_dibayar" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" required>
                                <option value="1">Sudah Dibayar</option>
                                <option value="0">Belum Dibayar</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 800; border: none; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 25px rgba(99, 102, 241, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(99, 102, 241, 0.25)';">
                            <i data-feather="save" style="width: 20px; height: 20px;"></i>
                            Simpan Data Gaji
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Card -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #f1f5f9;">
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Pegawai</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Jabatan</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Periode</th>
                            <th style="text-align: right; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Nominal</th>
                            <th style="text-align: center; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Status</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Tanggal Bayar</th>
                            <th style="text-align: center; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9375rem;">
                        @forelse($gaji as $g)
                            <tr id="row-{{ $g->id }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                                <td style="padding: 16px 24px;">
                                    <div style="font-weight: 700; color: #1e2937;">{{ $g->pegawai->nama_pegawai ?? '-' }}</div>
                                </td>
                                <td style="padding: 16px 24px; color: #475569;">
                                    {{ $g->pegawai->jabatan ?? '-' }}
                                </td>
                                <td style="padding: 16px 24px; color: #64748b; font-weight: 500;">
                                    {{ date('F', mktime(0, 0, 0, $g->bulan, 1)) }} {{ $g->tahun }}
                                </td>
                                <td style="padding: 16px 24px; text-align: right; color: #1e2937; font-weight: 700;">
                                    Rp {{ number_format($g->nominal, 0, ',', '.') }}
                                </td>
                                <td style="padding: 16px 24px; text-align: center;">
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; {{ $g->is_dibayar ? 'background: #ecfdf5; color: #059669;' : 'background: #fff1f2; color: #e11d48;' }}">
                                        {{ $g->is_dibayar ? 'Dibayar' : 'Menunggu' }}
                                    </span>
                                </td>
                                <td style="padding: 16px 24px; color: #64748b;">
                                    {{ $g->tanggal_bayar ? $g->tanggal_bayar->format('d/m/Y') : '-' }}
                                </td>
                                <td style="padding: 16px 24px; text-align: center;">
                                    <div style="display: flex; justify-content: center; gap: 8px;">
                                        <button onclick="toggleEdit({{ $g->id }})" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px; color: #475569; cursor: pointer; transition: all 0.2s;">
                                            <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                        <form method="POST" action="{{ route('bendahara.gaji.destroy', $g->id) }}" style="display: inline;" onsubmit="return confirmDelete(event, 'Data gaji ini akan dihapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: white; border: 1px solid #fee2e2; border-radius: 8px; padding: 6px; color: #ef4444; cursor: pointer; transition: all 0.2s;">
                                                <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Row -->
                            <tr id="edit-{{ $g->id }}" style="display: none; background: #f8fafc;">
                                <td colspan="7" style="padding: 24px; border-bottom: 1px solid #e2e8f0;">
                                    <form method="POST" action="{{ route('bendahara.gaji.update', $g->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px;">
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Status Pembayaran</label>
                                                <select name="is_dibayar" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" required>
                                                    <option value="1" {{ $g->is_dibayar ? 'selected' : '' }}>Dibayar</option>
                                                    <option value="0" {{ !$g->is_dibayar ? 'selected' : '' }}>Menunggu</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Tanggal Bayar</label>
                                                <input type="date" name="tanggal_bayar" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="{{ $g->tanggal_bayar ? $g->tanggal_bayar->format('Y-m-d') : '' }}">
                                            </div>
                                            <div style="grid-column: span 2;">
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Keterangan</label>
                                                <input type="text" name="keterangan" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="{{ $g->keterangan }}">
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                            <button type="button" onclick="toggleEdit({{ $g->id }})" style="background: white; border: 1px solid #e2e8f0; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
                                            <button type="submit" style="background: #6366f1; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                                <i data-feather="check" style="width: 16px; height: 16px;"></i>
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 48px; text-align: center; color: #94a3b8;">
                                    <i data-feather="dollar-sign" style="width: 48px; height: 48px; display: block; margin: 0 auto 16px; opacity: 0.5;"></i>
                                    <div style="font-size: 1rem; font-weight: 500;">Tidak ada data gaji ditemukan</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($gaji->hasPages())
                <div style="padding: 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                    {{ $gaji->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
function toggleEdit(id) {
    const row = document.getElementById('row-' + id);
    const editRow = document.getElementById('edit-' + id);
    
    if (editRow.style.display === 'none') {
        editRow.style.display = 'table-row';
        row.style.backgroundColor = '#f5f5f5';
    } else {
        editRow.style.display = 'none';
        row.style.backgroundColor = '';
    }
    feather.replace();
}
</script>
@endpush
