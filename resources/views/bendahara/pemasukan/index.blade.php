@extends('layouts.app')

@section('title', 'Pemasukan')
@section('page-title', 'Pemasukan')

@section('sidebar-menu')
    @include('bendahara.partials.sidebar-menu')
@endsection

@section('content')
    <!-- Header Banner -->
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 20px; padding: 40px; margin-bottom: 32px; box-shadow: 0 20px 40px rgba(59, 130, 246, 0.25); position: relative; overflow: hidden; color: white;">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(40px);"></div>
        <div style="position: absolute; bottom: -30px; left: 15%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 24px;">
            <div style="background: rgba(255,255,255,0.2); width: 72px; height: 72px; border-radius: 18px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);">
                <i data-feather="trending-up" style="width: 36px; height: 36px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.025em;">Manajemen Pemasukan</h2>
                <p style="font-size: 1.1rem; opacity: 0.95; font-weight: 400;">Catat dan pantau seluruh sumber dana masuk pesantren secara akurat.</p>
            </div>
        </div>
        <div style="position: absolute; right: 40px; bottom: -20px; opacity: 0.15;">
            <i data-feather="trending-up" style="width: 180px; height: 180px; transform: rotate(-15deg);"></i>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <i data-feather="check-circle" style="width: 20px; height: 20px;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">
        @if(auth()->user()->role !== 'rois')
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden;">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-feather="plus-circle" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e2937;">Tambah Data Pemasukan</h3>
                </div>
            </div>
            <div style="padding: 24px;">
                <form method="POST" action="{{ route('bendahara.pemasukan.store') }}">
                    @csrf
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Sumber Pemasukan <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="sumber_pemasukan" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" placeholder="Contoh: Donasi Hamba Allah, Hasil Kantin, dll." required>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tanggal <span style="color: #ef4444;">*</span></label>
                            <input type="date" name="tanggal" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nominal (Rp) <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="nominal" class="format-rupiah" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" placeholder="0" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 32px;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kategori <span style="color: #ef4444;">*</span></label>
                            <select name="kategori" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" required>
                                <option value="donasi">Donasi</option>
                                <option value="syahriah">Syahriah</option>
                                <option value="kantin">Kantin / Usaha</option>
                                <option value="program">Program Khusus</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Keterangan Tambahan</label>
                            <input type="text" name="keterangan" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;" placeholder="Opsional">
                        </div>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 800; border: none; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 25px rgba(59, 130, 246, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(59, 130, 246, 0.25)';">
                            <i data-feather="save" style="width: 20px; height: 20px;"></i>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Data Table Card -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #f1f5f9;">
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Tanggal</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Sumber Pemasukan</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Kategori</th>
                            <th style="text-align: right; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Nominal</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Keterangan</th>
                            <th style="text-align: center; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9375rem;">
                        @forelse($pemasukan as $p)
                            <tr id="row-{{ $p->id }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                                <td style="padding: 16px 24px; color: #64748b; font-weight: 500;">
                                    {{ $p->tanggal->format('d M Y') }}
                                </td>
                                <td style="padding: 16px 24px; color: #1e2937; font-weight: 700;">
                                    {{ $p->sumber_pemasukan }}
                                </td>
                                <td style="padding: 16px 24px;">
                                    <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: #eff6ff; color: #1d4ed8; text-transform: uppercase;">
                                        {{ $p->kategori }}
                                    </span>
                                </td>
                                <td style="padding: 16px 24px; text-align: right; color: #059669; font-weight: 700;">
                                    Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                </td>
                                <td style="padding: 16px 24px; color: #64748b;">
                                    {{ $p->keterangan ?? '-' }}
                                </td>
                                <td style="padding: 16px 24px; text-align: center;">
                                    @if(auth()->user()->role !== 'rois')
                                    <div style="display: flex; justify-content: center; gap: 8px;">
                                        <button onclick="toggleEdit({{ $p->id }})" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px; color: #475569; cursor: pointer; transition: all 0.2s;">
                                            <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                        <form method="POST" action="{{ route('bendahara.pemasukan.destroy', $p->id) }}" style="display: inline;" onsubmit="return confirmDelete(event, 'Data pemasukan ini akan dihapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: white; border: 1px solid #fee2e2; border-radius: 8px; padding: 6px; color: #ef4444; cursor: pointer; transition: all 0.2s;">
                                                <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <span style="font-size: 11px; color: #64748b; font-style: italic;">Read-Only</span>
                                    @endif
                                </td>
                            </tr>
                            <!-- Edit Row -->
                            <tr id="edit-{{ $p->id }}" style="display: none; background: #f8fafc;">
                                <td colspan="6" style="padding: 24px; border-bottom: 1px solid #e2e8f0;">
                                    <form method="POST" action="{{ route('bendahara.pemasukan.update', $p->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px;">
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Sumber Pemasukan</label>
                                                <input type="text" name="sumber_pemasukan" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="{{ $p->sumber_pemasukan }}" required>
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Tanggal</label>
                                                <input type="date" name="tanggal" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="{{ $p->tanggal->format('Y-m-d') }}" required>
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Nominal</label>
                                                <input type="number" name="nominal" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="{{ $p->nominal }}" required>
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Kategori</label>
                                                <select name="kategori" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" required>
                                                    <option value="donasi" {{ $p->kategori == 'donasi' ? 'selected' : '' }}>Donasi</option>
                                                    <option value="syahriah" {{ $p->kategori == 'syahriah' ? 'selected' : '' }}>Syahriah</option>
                                                    <option value="kantin" {{ $p->kategori == 'kantin' ? 'selected' : '' }}>Kantin / Usaha</option>
                                                    <option value="program" {{ $p->kategori == 'program' ? 'selected' : '' }}>Program Khusus</option>
                                                    <option value="lainnya" {{ $p->kategori == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                            </div>
                                            <div style="grid-column: span 2;">
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Keterangan</label>
                                                <input type="text" name="keterangan" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="{{ $p->keterangan }}">
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                            <button type="button" onclick="toggleEdit({{ $p->id }})" style="background: white; border: 1px solid #e2e8f0; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
                                            <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                                <i data-feather="check" style="width: 16px; height: 16px;"></i>
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 48px; text-align: center; color: #94a3b8;">
                                    <i data-feather="inbox" style="width: 48px; height: 48px; display: block; margin: 0 auto 16px; opacity: 0.5;"></i>
                                    <div style="font-size: 1rem; font-weight: 500;">Tidak ada data pemasukan</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($pemasukan->hasPages())
                <div style="padding: 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                    {{ $pemasukan->links() }}
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
