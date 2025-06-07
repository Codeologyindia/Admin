<!DOCTYPE html>
<html>
<head>
    <title>Softwhere Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Nunito Sans (hospital/healthcare style) -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito Sans', Arial, Helvetica, sans-serif;
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        .animated-bg {
            position: fixed;
            top: -50px;
            left: -50px;
            width: 200vw;
            height: 200vh;
            background: radial-gradient(circle at 20% 20%, #a1c4fd 0%, transparent 70%),
                        radial-gradient(circle at 80% 80%, #c2e9fb 0%, transparent 70%);
            opacity: 0.3;
            z-index: 0;
            animation: moveBg 10s linear infinite alternate;
        }
        @keyframes moveBg {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-100px, -100px) scale(1.1); }
        }
        .container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    <div class="container py-5">
        @yield('content')
    </div>
    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
