<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Welcome to Vehicle Tracker</title>
    <link rel="icon" href="{{ asset('img/logo-vehicle-tracker.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('img/logo-vehicle-tracker.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f8fafc;
        }
        .welcome-hero {
            background: linear-gradient(rgba(30, 41, 59, 0.7), rgba(30, 41, 59, 0.7)), url('{{ asset('img/unsplash/login-bg.jpg') }}') center/cover no-repeat;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            position: relative;
        }
        .welcome-card {
            background: rgba(255,255,255,0.97);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            padding: 2.5rem 2rem;
            max-width: 600px;
            margin: 2rem auto;
            color: #222;
        }
        .welcome-illustration {
            max-width: 350px;
            width: 100%;
            margin-left: 2rem;
        }
        .feature-icon {
            font-size: 2.5rem;
            /* color: #2563eb; */
            color: #6777ef;
            margin-bottom: 1rem;
        }
        @media (max-width: 991px) {
            .welcome-illustration { display: none; }
        }
    </style> 

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>
<body> 
    <div class="welcome-hero">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-7">
                    <div class="welcome-card text-center text-lg-left">
                        <img src="{{ asset('img/logo-vehicle-tracker.svg') }}" alt="Vehicle Tracker Logo" style="width:80px; height:80px; margin-bottom:1.5rem;">
                        <h1 class="display-4 font-weight-bold mb-3 text-primary">Welcome to Vehicle Tracker</h1>
                        <p class="lead mb-4">A modern platform for managing your company's vehicles, bookings, and logistics. Streamline your fleet operations with ease and efficiency.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary px-5 py-3 shadow"><i class="fas fa-car"></i> Get Started</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <img src="{{ asset('img/drawkit/drawkit-full-stack-man-colour.svg') }}" alt="Vehicle Tracker Illustration" class="welcome-illustration">
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row text-center justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-2"><i class="fas fa-truck-monster"></i></div>
                        <h5 class="card-title font-weight-bold">Fleet Management</h5>
                        <p class="card-text">Easily manage all your vehicles, drivers, and maintenance schedules in one place.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-2"><i class="fas fa-calendar-check"></i></div>
                        <h5 class="card-title font-weight-bold">Smart Booking</h5>
                        <p class="card-text">Book vehicles, assign drivers, and track approvals with a seamless workflow.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-2"><i class="fas fa-chart-line"></i></div>
                        <h5 class="card-title font-weight-bold">Insightful Reports</h5>
                        <p class="card-text">Monitor usage, costs, and performance with real-time analytics and reports.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-2"><i class="fas fa-shield-alt"></i></div>
                        <h5 class="card-title font-weight-bold">Secure & Reliable</h5>
                        <p class="card-text">Your data is protected with enterprise-grade security and reliable cloud infrastructure.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html> 