<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Riyadlul Huda</title>
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: white;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: white;
            bottom: -50px;
            right: -50px;
            animation-delay: 5s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            background: white;
            top: 50%;
            right: 10%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        .login-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 90%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 1;
        }

        /* Left Side - Role Cards */
        .roles-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 20px;
        }

        .roles-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            text-align: center;
        }

        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .role-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: default;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .role-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: white;
        }

        .role-admin .role-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .role-pendidikan .role-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .role-sekretaris .role-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .role-bendahara .role-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

        .role-name {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .role-desc {
            font-size: 11px;
            color: #718096;
        }

        /* Right Side - Login Form */
        .login-section {
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #718096;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-danger {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #fc8181;
        }

        /* Watermark - Developer Credit */
        .watermark {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 14px 28px;
            border-radius: 50px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            font-size: 13px;
            color: #4a5568;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        .watermark-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .watermark-text {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .watermark-label {
            font-size: 10px;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .watermark-name {
            font-size: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 400px;
            }

            .roles-section {
                padding: 30px 20px;
            }

            .roles-title {
                font-size: 20px;
            }

            .role-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .role-card {
                padding: 16px 12px;
            }

            .role-icon {
                width: 40px;
                height: 40px;
            }

            .role-name {
                font-size: 12px;
            }

            .role-desc {
                font-size: 10px;
            }

            .login-section {
                padding: 30px 20px;
            }

            .watermark {
                bottom: 10px;
                padding: 10px 20px;
            }
            
            .watermark-icon {
                width: 28px;
                height: 28px;
            }
            
            .watermark-label {
                font-size: 9px;
            }
            
            .watermark-name {
                font-size: 12px;
            }
        }
        
        /* Hide watermark on very small screens to prevent overlap */
        @media (max-height: 700px) {
            .watermark {
                display: none;
            }
        }
        
        /* For landscape mobile, make watermark smaller and less intrusive */
        @media (max-width: 768px) and (orientation: landscape) {
            .watermark {
                padding: 8px 16px;
                bottom: 5px;
                font-size: 11px;
            }
            
            .watermark-icon {
                width: 24px;
                height: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="login-container">
        <!-- Left Side - Role Cards -->
        <div class="roles-section">
            <h2 class="roles-title">Sistem Multi-Role</h2>
            <div class="role-grid">
                <div class="role-card role-admin">
                    <div class="role-icon">
                        <i data-feather="shield" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="role-name">Admin</div>
                    <div class="role-desc">Kelola Sistem</div>
                </div>
                <div class="role-card role-pendidikan">
                    <div class="role-icon">
                        <i data-feather="book-open" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="role-name">Pendidikan</div>
                    <div class="role-desc">Nilai & Rapor</div>
                </div>
                <div class="role-card role-sekretaris">
                    <div class="role-icon">
                        <i data-feather="users" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="role-name">Sekretaris</div>
                    <div class="role-desc">Data Santri</div>
                </div>
                <div class="role-card role-bendahara">
                    <div class="role-icon">
                        <i data-feather="dollar-sign" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="role-name">Bendahara</div>
                    <div class="role-desc">Keuangan</div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-section">
            <div class="login-header">
                <div class="logo">
                    <i data-feather="home" style="width: 32px; height: 32px;"></i>
                </div>
                <h1 class="login-title">Selamat Datang</h1>
                <p class="login-subtitle">Dashboard Riyadlul Huda</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <strong>Login Gagal!</strong> Email atau password salah.
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="nama@riyadlulhuda.com"
                        value="<?php echo e(old('email')); ?>"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="btn-login">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
    </div>

    <!-- Developer Watermark -->
    <div class="watermark">
        <div class="watermark-icon">
            <i data-feather="code" style="width: 16px; height: 16px;"></i>
        </div>
        <div class="watermark-text">
            <span class="watermark-label">Dikembangkan oleh</span>
            <span class="watermark-name">Mahin Utsman Nawawi, S.H</span>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views/auth/login.blade.php ENDPATH**/ ?>