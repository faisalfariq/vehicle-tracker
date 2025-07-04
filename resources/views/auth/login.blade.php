<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vehicle Tracker</title>
    <link rel="icon" href="{{ asset('img/logo-vehicle-tracker.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('img/logo-vehicle-tracker.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            min-height: 100vh;
            font-family: 'Nunito', Arial, sans-serif;
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }
        /* Dynamic gradient background with SVG shapes */
        .bg-svg {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: 0;
            pointer-events: none;
        }
        .login-center {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .login-wrapper {
            display: flex;
            background: rgba(255,255,255,0.75);
            border-radius: 22px;
            box-shadow: 0 8px 40px 0 rgba(37,99,235,0.13), 0 1.5px 8px 0 rgba(0,0,0,0.04);
            overflow: hidden;
            max-width: 950px;
            width: 100%;
            min-height: 540px;
            backdrop-filter: blur(12px);
            animation: fadeInUp 1.1s cubic-bezier(.23,1.01,.32,1) 0.1s both;
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: none; }
        }
        .login-illustration {
            background: rgba(244,246,249,0.85);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 50%;
        }
        .login-illustration img {
            max-width: 340px;
            width: 100%;
            margin-bottom: 2.2rem;
            filter: drop-shadow(0 8px 32px rgba(37,99,235,0.10));
        }
        .login-illustration h2 {
            font-size: 2.2rem;
            font-weight: 900;
            color: #6777ef;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }
        .login-illustration p {
            color: #64748b;
            font-size: 1.13rem;
            text-align: center;
        }
        .login-form-section {
            width: 50%;
            padding: 3.5rem 2.5rem 2.5rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-title {
            font-size: 2.1rem;
            font-weight: 800;
            color: #6777ef;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }
        .login-subtitle {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 1.08rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .login-subtitle i {
            color: #6777ef;
            font-size: 1.2rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        .form-label { font-weight: 700; margin-bottom: 0.5rem; display: block; color: #1e293b; }
        .form-control { width: 100%; padding: 0.75rem; border-radius: 7px; border: 1.5px solid #d1d5db; font-size: 1.05rem; background: rgba(255,255,255,0.95); }
        .form-control:focus { border-color: #6777ef; outline: none; }
        .input-group { position: relative; }
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.1rem;
            cursor: pointer;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(90deg, #6777ef 0%, #aeb5ed 100%);
            color: #fff;
            border: none;
            border-radius: 7px;
            font-weight: 800;
            font-size: 1.13rem;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 12px rgba(37,99,235,0.10);
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #6777ef 100%);
            box-shadow: 0 4px 18px rgba(37,99,235,0.13);
        }
        .forgot-link {
            display: block;
            text-align: right;
            margin-top: 0.5rem;
            color: #6777ef;
            font-size: 0.98rem;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #1d4ed8; text-decoration: underline; }
        .error-msg { color: #dc2626; font-size: 0.97rem; margin-bottom: 1rem; text-align: center; }
        @media (max-width: 900px) {
            .login-wrapper { flex-direction: column; min-height: unset; }
            .login-illustration, .login-form-section { width: 100%; padding: 2rem 1.2rem; }
            .login-illustration img { max-width: 200px; }
        }
        @media (max-width: 600px) {
            .login-form-section, .login-illustration { padding: 1.2rem 0.5rem; }
            .login-title { font-size: 1.4rem; }
            .login-illustration h2 { font-size: 1.3rem; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</head>
<body>
    <!-- SVG Decorative Background -->
    <svg class="bg-svg" viewBox="0 0 1440 900" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="bg-grad1" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#6777ef" stop-opacity="0.18"/>
                <stop offset="100%" stop-color="#aeb5ed" stop-opacity="0.13"/>
            </linearGradient>
        </defs>
        <ellipse cx="1200" cy="200" rx="340" ry="120" fill="url(#bg-grad1)"/>
        <ellipse cx="300" cy="800" rx="400" ry="120" fill="url(#bg-grad1)"/>
        <circle cx="200" cy="200" r="120" fill="#6777ef" fill-opacity="0.08"/>
        <circle cx="1300" cy="700" r="90" fill="#aeb5ed" fill-opacity="0.10"/>
    </svg>
    <div class="login-center">
        <!-- Login Form Section -->
        <div class="login-wrapper">
            <div class="login-illustration">
                <img src="{{ asset('img/drawkit/drawkit-full-stack-man-colour.svg') }}" alt="Login Illustration">
                <h2>Welcome Back!</h2>
                <p>Access your vehicle tracking dashboard.<br>Manage bookings, monitor vehicles, and more.</p>
            </div>
            <div class="login-form-section">
                <div style="display:flex;justify-content:center;align-items:center;margin-bottom:1.2rem;">
                    <img src="{{ asset('img/logo-vehicle-tracker.svg') }}" alt="Logo" style="width:60px;height:60px;">
                </div>
                <div class="login-title">Sign In</div>
                <div class="login-subtitle"><i class="fa fa-lock"></i> Enter your credentials to continue</div>
                @if(session('error'))
                    <div class="error-msg">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="error-msg">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <button type="button" class="toggle-password" tabindex="-1" onclick="togglePassword()"><i class="fa fa-eye" id="eyeIcon"></i></button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">Remember me</label>
                        </div>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
        
        <!-- Test Users Section - Below the login form as separate card -->
        <div class="test-users-section" style="margin-top: 2rem; background: rgba(255,255,255,0.9); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); backdrop-filter: blur(8px); width: 100%; max-width: 950px;">
            <h6 style="color: #64748b; font-weight: 600; margin-bottom: 1rem; text-align: center; font-size: 1.1rem;">
                <i class="fas fa-users"></i> Test Users
            </h6>
            <div class="test-users-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem; font-size: 0.9rem;">
                <div class="user-card" style="background: rgba(103, 119, 239, 0.1); padding: 0.75rem; border-radius: 6px; border-left: 3px solid #6777ef; transition: all 0.2s ease;">
                    <div style="font-weight: 600; color: #6777ef; margin-bottom: 0.25rem;">👑 Admin</div>
                    <div style="color: #64748b;">admin@company.com</div>
                    <div style="color: #64748b;">Password: Admin123</div>
                </div>
                
                <div class="user-card" style="background: rgba(34, 197, 94, 0.1); padding: 0.75rem; border-radius: 6px; border-left: 3px solid #22c55e; transition: all 0.2s ease;">
                    <div style="font-weight: 600; color: #22c55e; margin-bottom: 0.25rem;">✅ Approver 1</div>
                    <div style="color: #64748b;">approver1@company.com</div>
                    <div style="color: #64748b;">Password: Approver123</div>
                </div>
                
                <div class="user-card" style="background: rgba(34, 197, 94, 0.1); padding: 0.75rem; border-radius: 6px; border-left: 3px solid #22c55e; transition: all 0.2s ease;">
                    <div style="font-weight: 600; color: #22c55e; margin-bottom: 0.25rem;">✅ Approver 2</div>
                    <div style="color: #64748b;">approver2@company.com</div>
                    <div style="color: #64748b;">Password: Approver123</div>
                </div>
                
                <div class="user-card" style="background: rgba(59, 130, 246, 0.1); padding: 0.75rem; border-radius: 6px; border-left: 3px solid #3b82f6; transition: all 0.2s ease;">
                    <div style="font-weight: 600; color: #3b82f6; margin-bottom: 0.25rem;">👤 User 1</div>
                    <div style="color: #64748b;">user1@company.com</div>
                    <div style="color: #64748b;">Password: password</div>
                </div>
                
                <div class="user-card" style="background: rgba(59, 130, 246, 0.1); padding: 0.75rem; border-radius: 6px; border-left: 3px solid #3b82f6; transition: all 0.2s ease;">
                    <div style="font-weight: 600; color: #3b82f6; margin-bottom: 0.25rem;">👤 User 2</div>
                    <div style="color: #64748b;">user2@company.com</div>
                    <div style="color: #64748b;">Password: password</div>
                </div>
            </div>
            
            <div style="margin-top: 1rem; text-align: center; font-size: 0.8rem; color: #94a3b8;">
                <i class="fas fa-info-circle"></i> Click on any user card to auto-fill the form above
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-fill login form when clicking on user cards
        document.addEventListener('DOMContentLoaded', function() {
            const userCards = document.querySelectorAll('.user-card');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            userCards.forEach(card => {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function() {
                    const email = this.querySelector('div:nth-child(2)').textContent;
                    const password = this.querySelector('div:nth-child(3)').textContent.replace('Password: ', '');
                    
                    emailInput.value = email;
                    passwordInput.value = password;
                    
                    // Add visual feedback
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        card.style.transform = 'scale(1)';
                    }, 150);
                    
                    // Focus on password field
                    passwordInput.focus();
                });

                // Add hover effect
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
</body>
</html> 