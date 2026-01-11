@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')

@section('sidebar-menu')
    @include('admin.partials.sidebar-menu')
@endsection

@include('components.bottom-nav', ['active' => 'settings', 'context' => 'admin'])

@section('drawer-menu')
    <li class="drawer-menu-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="drawer-menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                <i data-feather="log-out"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
@endsection

@section('content')
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 16px 24px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); display: flex; align-items: center; gap: 12px;">
            <i data-feather="check-circle" style="width: 24px; height: 24px;"></i>
            <span style="font-weight: 600;">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 16px 24px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); display: flex; align-items: center; gap: 12px;">
            <i data-feather="alert-circle" style="width: 24px; height: 24px;"></i>
            <span style="font-weight: 600;">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 32px; margin-bottom: 32px; box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 20px; position: relative; z-index: 1; color: white;">
            <div style="background: rgba(255,255,255,0.2); width: 64px; height: 64px; border-radius: 16px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="settings" style="width: 32px; height: 32px; color: white;"></i>
            </div>
            <div>
                <h1 style="font-size: 2rem; font-weight: 900; margin: 0 0 4px 0;">Pengaturan Sistem</h1>
                <p style="opacity: 0.9; font-size: 1rem; margin: 0;">Kelola konfigurasi aplikasi dan user</p>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div style="background: white; border-radius: 16px; padding: 8px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; gap: 8px;">
        <button onclick="showTab('app')" id="tab-app" class="tab-button active" style="flex: 1; padding: 12px 24px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
            <i data-feather="sliders" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Aplikasi
        </button>
        <button onclick="showTab('users')" id="tab-users" class="tab-button" style="flex: 1; padding: 12px 24px; border: none; background: #f3f4f6; color: #6b7280; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
            <i data-feather="users" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Manajemen User
        </button>
        <button onclick="showTab('backup')" id="tab-backup" class="tab-button" style="flex: 1; padding: 12px 24px; border: none; background: #f3f4f6; color: #6b7280; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
            <i data-feather="database" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Backup
        </button>
        <button onclick="showTab('system')" id="tab-system" class="tab-button" style="flex: 1; padding: 12px 24px; border: none; background: #f3f4f6; color: #6b7280; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
            <i data-feather="info" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Info Sistem
        </button>
    </div>

    <!-- Tab Content: Aplikasi -->
    <div id="content-app" class="tab-content">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0 0 24px 0;">Pengaturan Aplikasi</h3>
            
            <form method="POST" action="{{ route('admin.pengaturan.app') }}">
                @csrf
                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Aplikasi</label>
                        <input type="text" name="app_name" value="{{ session('app_name', 'Dashboard Riyadlul Huda') }}" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; transition: all 0.3s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                        <input type="text" name="app_contact" value="{{ session('app_contact', '+62 xxx xxxx xxxx') }}" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; transition: all 0.3s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                        <input type="email" name="app_email" value="{{ session('app_email', 'info@riyadlulhuda.com') }}" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; transition: all 0.3s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                    
                    <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 14px 32px; border: none; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                        <i data-feather="save" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab Content: Users -->
    <div id="content-users" class="tab-content" style="display: none;">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0;">Tambah User Baru</h3>
            </div>
            
            <form method="POST" action="{{ route('admin.pengaturan.user.create') }}">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama</label>
                        <input type="text" name="name" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                        <input type="email" name="email" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Password</label>
                        <input type="password" name="password" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Role</label>
                        <select name="role" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                            <option value="admin_pusat">Admin Pusat</option>
                            <option value="sekretaris">Sekretaris</option>
                            <option value="bendahara">Bendahara</option>
                            <option value="pendidikan">Pendidikan</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px 28px; border: none; border-radius: 10px; font-weight: 700; margin-top: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    <i data-feather="user-plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Tambah User
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0 0 24px 0;">Daftar User</h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 16px; text-align: left; font-weight: 700; color: #1e293b;">Nama</th>
                            <th style="padding: 16px; text-align: left; font-weight: 700; color: #1e293b;">Email</th>
                            <th style="padding: 16px; text-align: left; font-weight: 700; color: #1e293b;">Role</th>
                            <th style="padding: 16px; text-align: left; font-weight: 700; color: #1e293b;">Dibuat</th>
                            <th style="padding: 16px; text-align: center; font-weight: 700; color: #1e293b;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding: 16px; font-weight: 600; color: #1f2937;">{{ $user->name }}</td>
                            <td style="padding: 16px; color: #6b7280;">{{ $user->email }}</td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 6px; font-size: 0.875rem; font-weight: 600; 
                                    @if($user->role === 'admin_pusat') background: #fef3c7; color: #92400e;
                                    @elseif($user->role === 'sekretaris') background: #dbeafe; color: #1e40af;
                                    @elseif($user->role === 'bendahara') background: #d1fae5; color: #065f46;
                                    @else background: #fce7f3; color: #9f1239;
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">{{ $user->created_at->format('d M Y') }}</td>
                            <td style="padding: 16px; text-align: center;">
                                <button onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 8px 16px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; margin-right: 8px;">
                                    <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                </button>
                                
                                @if($user->id !== auth()->user()->id)
                                <form method="POST" action="{{ route('admin.pengaturan.user.delete', $user->id) }}" style="display: inline;" onsubmit="return confirmDelete(event, 'Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 8px 16px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                        <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Content: Backup -->
    <div id="content-backup" class="tab-content" style="display: none;">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0 0 16px 0;">Backup Database</h3>
            <p style="color: #6b7280; margin-bottom: 24px;">Download backup database dalam format SQL untuk keamanan data.</p>
            
            <a href="{{ route('backup.download') }}" style="display: inline-flex; align-items: center; gap: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i data-feather="download" style="width: 24px; height: 24px;"></i>
                Download Backup Database
            </a>
        </div>
    </div>

    <!-- Tab Content: System -->
    <div id="content-system" class="tab-content" style="display: none;">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0 0 24px 0;">Informasi Sistem</h3>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 24px; border-radius: 12px; border: 2px solid #bae6fd;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i data-feather="code" style="width: 24px; height: 24px; color: #0284c7;"></i>
                        <span style="font-weight: 700; color: #0c4a6e;">Framework</span>
                    </div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #0369a1; margin: 0;">Laravel {{ app()->version() }}</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 24px; border-radius: 12px; border: 2px solid #fcd34d;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i data-feather="server" style="width: 24px; height: 24px; color: #ca8a04;"></i>
                        <span style="font-weight: 700; color: #713f12;">PHP Version</span>
                    </div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #a16207; margin: 0;">{{ phpversion() }}</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 24px; border-radius: 12px; border: 2px solid #bbf7d0;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i data-feather="database" style="width: 24px; height: 24px; color: #16a34a;"></i>
                        <span style="font-weight: 700; color: #14532d;">Database</span>
                    </div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #15803d; margin: 0;">MySQL</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); padding: 24px; border-radius: 12px; border: 2px solid #f9a8d4;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i data-feather="zap" style="width: 24px; height: 24px; color: #db2777;"></i>
                        <span style="font-weight: 700; color: #831843;">App Version</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal (Hidden by default) -->
    <div id="editUserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 20px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0 0 24px 0;">Edit User</h3>
            
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div style="display: grid; gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama</label>
                        <input type="text" id="edit_name" name="name" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                        <input type="email" id="edit_email" name="email" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" id="edit_password" name="password" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Role</label>
                        <select id="edit_role" name="role" required style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;">
                            <option value="admin_pusat">Admin Pusat</option>
                            <option value="sekretaris">Sekretaris</option>
                            <option value="bendahara">Bendahara</option>
                            <option value="pendidikan">Pendidikan</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" style="flex: 1; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Simpan
                    </button>
                    <button type="button" onclick="closeEditModal()" style="flex: 1; background: #e5e7eb; color: #374151; padding: 12px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        function showTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.style.background = '#f3f4f6';
                button.style.color = '#6b7280';
            });
            
            // Show selected content
            document.getElementById('content-' + tabName).style.display = 'block';
            
            // Add active class to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            activeButton.style.color = 'white';
            
            // Re-initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
        
        // Edit user modal
        function editUser(id, name, email, role) {
            document.getElementById('editUserForm').action = '/admin/pengaturan/user/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_password').value = '';
            document.getElementById('editUserModal').style.display = 'flex';
        }
        
        function closeEditModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        
        // Close modal on outside click
        document.getElementById('editUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
@endsection
