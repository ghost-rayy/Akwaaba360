<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Akwaaba360') }} - HR Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-orange: #FF8D4D;
            --secondary-orange: #FF6B35;
        }
        body { font-family: 'Outfit', sans-serif; background-color: #fcfcfc; }
        .sidebar { background: linear-gradient(180deg, #FF8D4D 0%, #FF6B35 100%); }
        .nav-item { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 12px; }
        .nav-item:hover { background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
        .nav-item.active { background: #fff; color: #FF6b35; font-weight: 800; box-shadow: 0 8px 30px rgba(255, 107, 53, 0.3); }
        .content-area { border-radius: 24px 0 0 24px; box-shadow: -10px 0 30px rgba(0, 0, 0, 0.02); }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="sidebar w-72 flex-shrink-0 flex flex-col text-white px-6 py-8">
        <div class="flex items-center space-x-3 mb-10 pl-2">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl font-black text-orange-500">A</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight">Akwaaba360</h1>
        </div>

        <nav class="flex-grow space-y-2 overflow-y-auto pr-2">
            <p class="text-xs font-bold text-orange-200 uppercase tracking-widest pl-4 mb-4 mt-6">Primary Navigation</p>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.dashboard')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5 @if(!Route::is('admin.dashboard')) text-orange-100 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.onboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.onboard')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <span>Onboard Personnel</span>
            </a>

            <a href="{{ route('admin.shortlist') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.shortlist')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Shortlist Personnel</span>
            </a>

            <a href="{{ route('admin.endorse') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.endorse')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Endorse Personnel</span>
            </a>

            <p class="text-xs font-bold text-orange-200 uppercase tracking-widest pl-4 mb-4 mt-10">Administration</p>

            <a href="{{ route('admin.appointment') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.appointment')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Appointment Letter</span>
            </a>

            <a href="{{ route('admin.manage-personnel') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.manage-personnel')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Manage Personnel</span>
            </a>

            <a href="{{ route('admin.manage-departments') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.manage-departments')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span>Manage Departments</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.settings')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5 @if(!Route::is('admin.settings')) text-orange-100 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Settings</span>
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-orange-400">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3.5 nav-item font-semibold hover:bg-red-500 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow bg-white content-area overflow-y-auto">
        <!-- Top Header -->
        <header class="flex justify-between items-center px-10 py-8 border-b border-gray-50 bg-white/80 backdrop-blur-md sticky top-0 z-20">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                <p class="text-sm text-gray-400 font-medium tracking-wide">{{ now()->format('l, jS F Y') }}</p>
            </div>

            <div class="flex items-center space-x-6">
                <button class="p-2.5 bg-gray-50 text-gray-400 hover:text-orange-500 rounded-xl transition-colors border border-gray-100 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                
                <div class="flex items-center space-x-4 border-l pl-6 border-gray-100">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name ?? 'HR Admin' }}</p>
                        <p class="text-[10px] font-black uppercase text-orange-500 tracking-tighter">System Administrator</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 border-2 border-white shadow-xl rounded-2xl overflow-hidden ring-4 ring-orange-100">
                        <img src="https://ui-avatars.com/api/?name=HR+Admin&background=FF8D4D&color=fff" alt="Profile">
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="p-10 max-w-[1600px] mx-auto w-full">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
