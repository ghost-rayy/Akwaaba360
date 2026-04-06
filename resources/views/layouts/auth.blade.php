<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Akwaaba360') }} - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-orange: #FF8D4D;
            --secondary-orange: #FF6B35;
            --accent-orange: #E8481D;
        }
        body { font-family: 'Outfit', sans-serif; background: #fff; }
        .bg-orange-gradient { background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange)); }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 141, 77, 0.1); }
        .input-focus:focus { border-color: var(--primary-orange); ring-color: var(--primary-orange); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-50 overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-orange-100 rounded-full blur-3xl opacity-50 -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-1/4 h-1/4 bg-orange-50 rounded-full blur-3xl opacity-50 -ml-20 -mb-20"></div>
    
    <main class="w-full max-w-md p-6 relative z-10">
        @yield('content')
    </main>
</body>
</html>
