@extends('layouts.app')

@section('title', 'Input Ujian Mingguan')
@section('page-title', 'Nilai Ujian Mingguan')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
    <!-- Filter Section -->
    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-bottom: 24px;">
        <form id="filterForm" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="filter-input" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                    <option value="2025/2026" {{ $tahunAjaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    <option value="2024/2025" {{ $tahunAjaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Semester</label>
                <select name="semester" id="semester" class="filter-input" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                    <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Ganjil</option>
                    <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="filter-input" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Mata Pelajaran (Ujian Mingguan)</label>
                <select name="mapel_id" id="mapel_id" class="filter-input" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ $mapelId == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Data Container -->
    <div id="data-container">
        @include('pendidikan.nilai-mingguan.table')
    </div>

    <script>
        // --- 1. Filter Logic (Fetch HTML Partial) ---
        const filterInputs = document.querySelectorAll('.filter-input');
        const dataContainer = document.getElementById('data-container');

        filterInputs.forEach(input => {
            input.addEventListener('change', loadData);
        });

        function loadData() {
            const tahun = document.getElementById('tahun_ajaran').value;
            const semester = document.getElementById('semester').value;
            const kelas = document.getElementById('kelas_id').value;
            const mapel = document.getElementById('mapel_id').value;

            // Show Loading State
            dataContainer.style.opacity = '0.5';
            dataContainer.style.pointerEvents = 'none';

            const url = `{{ route('pendidikan.nilai-mingguan.index') }}?tahun_ajaran=${tahun}&semester=${semester}&kelas_id=${kelas}&mapel_id=${mapel}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                dataContainer.innerHTML = html;
                dataContainer.style.opacity = '1';
                dataContainer.style.pointerEvents = 'auto';
                
                // Re-initialize scripts for the new DOM elements (avg calc, form submit)
                initScripts();
                if(typeof feather !== 'undefined') feather.replace();
            })
            .catch(error => {
                console.error('Error loading data:', error);
                dataContainer.style.opacity = '1';
                dataContainer.style.pointerEvents = 'auto';
            });
        }

        // --- 2. Calculate & Save Logic (Re-initializable) ---
        function initScripts() {
            // Re-attach Input Listeners
            document.querySelectorAll('.mingguan-input').forEach(input => {
                input.addEventListener('input', function() {
                    const santriId = this.dataset.santri;
                    calculateRowAverage(santriId);
                });
            });

            // Re-attach Form Submit Listener
            const form = document.querySelector('form[action="{{ route('pendidikan.nilai-mingguan.store') }}"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Menyimpan...`; 

                    const formData = new FormData(this);

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Berhasil disimpan!', 'success');
                        } else {
                            showToast('Gagal menyimpan.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan koneksi.', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                        if(typeof feather !== 'undefined') feather.replace();
                    });
                });
            }
        }

        function calculateRowAverage(santriId) {
            const inputs = document.querySelectorAll(`input[data-santri="${santriId}"]`);
            let sum = 0;
            let count = 0;

            inputs.forEach(inp => {
                const val = parseFloat(inp.value);
                if (!isNaN(val) && val > 0) {
                    sum += val;
                    count++;
                }
            });

            const avg = count > 0 ? (sum / count).toFixed(1) : '-';
            document.getElementById(`avg-${santriId}`).textContent = avg;
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.backgroundColor = type === 'success' ? '#10b981' : '#ef4444';
            toast.style.color = 'white';
            toast.style.padding = '12px 24px';
            toast.style.borderRadius = '8px';
            toast.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
            toast.style.zIndex = '9999';
            toast.style.fontSize = '14px';
            toast.style.fontWeight = '600';
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            toast.textContent = message;

            document.body.appendChild(toast);
            void toast.offsetWidth; 
            toast.style.opacity = '1';

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Initialize on first load
        initScripts();
    </script>
@endsection
