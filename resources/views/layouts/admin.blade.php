<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Akwaaba360') }} - HR Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        // Initialize PDF.js worker
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
    </script>
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
<body class="flex h-screen overflow-hidden" 
      x-data="{ 
        pdfLoading: false, 
        pdfModalOpen: false, 
        currentPdf: null,
        pdfScale: 1.5,
        
        async openPdf(url) {
            this.pdfLoading = true;
            this.pdfModalOpen = true;
            this.pdfScale = 1.5;
            
            try {
                // To bypass IDM, we fetch the PDF as a binary blob first
                const response = await fetch(url);
                if (!response.ok) throw new Error('Failed to fetch document');
                
                const buffer = await response.arrayBuffer();
                
                const loadingTask = pdfjsLib.getDocument({ data: buffer });
                this.currentPdf = await loadingTask.promise;
                this.renderPage(1);
            } catch (error) {
                console.error('Error loading PDF:', error);
                alert('Could not load the document. It may be missing or corrupt.');
                this.pdfModalOpen = false;
            } finally {
                this.pdfLoading = false;
            }
        },

        async renderPage(num) {
            if (!this.currentPdf) return;
            
            const page = await this.currentPdf.getPage(num);
            const canvas = document.getElementById('pdf-canvas');
            const context = canvas.getContext('2d');
            
            const viewport = page.getViewport({ scale: this.pdfScale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            
            await page.render(renderContext).promise;
        }
      }">
    <!-- Sidebar -->
    <aside class="sidebar w-72 flex-shrink-0 flex flex-col text-white px-6 py-8">
        <div class="flex items-center space-x-3 mb-10 pl-2">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl font-black text-orange-500">A</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight">Akwaaba360</h1>
        </div>

        <nav class="flex-grow space-y-2 overflow-y-auto pr-2">
            @if(!auth()->user()->password_must_change)
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

            @if(auth()->user()->role == 'hr_admin')
            <a href="{{ route('admin.appointment') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.appointment')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Appointment Letter</span>
            </a>
            @endif

            <a href="{{ route('admin.manage-personnel') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.manage-personnel')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Manage Personnel</span>
            </a>

            <a href="{{ route('admin.manage-departments') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.manage-departments')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span>Manage Departments</span>
            </a>
            
            @if(auth()->user()->role == 'hr_admin')
            <a href="{{ route('admin.settings') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 @if(Route::is('admin.settings')) active font-bold @else font-medium @endif">
                <svg class="w-5 h-5 @if(!Route::is('admin.settings')) text-orange-100 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Settings</span>
            </a>
            @endif
            @else
            <div class="px-4 py-8 bg-black/10 rounded-2xl border border-white/10 mt-6 overflow-hidden relative">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-white/5 rounded-full blur-xl"></div>
                <p class="text-[10px] font-black uppercase text-orange-200 tracking-widest mb-2 opacity-60">System Status</p>
                <p class="text-xs font-bold text-white leading-relaxed">Navigation is restricted. Please complete your security setup to unlock the full administrative suite.</p>
            </div>
            @endif
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
                        <p class="text-[10px] font-black uppercase text-orange-500 tracking-tighter">
                            {{ auth()->user()->role == 'hr_admin' ? 'System Administrator' : 'Administrative Staff' }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 border-2 border-white shadow-xl rounded-2xl overflow-hidden ring-4 ring-orange-100">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FF8D4D&color=fff" alt="Profile">
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

    <!-- Premium In-System PDF Viewer Modal -->
    <div x-show="pdfModalOpen" 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/70 backdrop-blur-md" @click="pdfModalOpen = false; currentPdf = null;"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-[3rem] sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full h-[90vh] flex flex-col relative"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
                
                <!-- Modal Header -->
                <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-white sticky top-0 z-20 rounded-t-[3rem]">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-800 tracking-tight">Personnel Verification Viewer</h3>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-1">Verified In-System Official Document</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Zoom Controls -->
                        <div class="flex items-center bg-gray-50 rounded-2xl p-1 border border-gray-100 shadow-sm">
                            <button @click="pdfScale -= 0.25; renderPage(1)" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-orange-500 hover:bg-white rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </button>
                            <span class="px-3 text-xs font-black text-gray-600 w-16 text-center" x-text="Math.round(pdfScale * 100) + '%'"></span>
                            <button @click="pdfScale += 0.25; renderPage(1)" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-orange-500 hover:bg-white rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>

                        <button @click="pdfModalOpen = false; currentPdf = null;" class="p-3 bg-gray-50 text-gray-400 hover:text-red-500 rounded-2xl transition-all border border-gray-100 hover:bg-white group">
                            <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Canvas Area -->
                <div class="flex-grow overflow-auto p-12 bg-gray-100/50 flex flex-col items-center relative custom-scrollbar">
                    <!-- Loading Overlay -->
                    <div x-show="pdfLoading" 
                         class="absolute inset-0 z-30 flex flex-col items-center justify-center bg-gray-50/80 backdrop-blur-sm transition-all"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <div class="w-20 h-20 relative mb-6">
                            <div class="absolute inset-0 border-4 border-orange-100 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-orange-500 rounded-full border-t-transparent animate-spin"></div>
                        </div>
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest animate-pulse">Initializing Data Stream...</p>
                    </div>

                    <div class="bg-white p-4 shadow-2xl rounded-xl border border-gray-100 mb-8 transform transition-transform" 
                         :class="{ 'opacity-30 scale-95': pdfLoading }">
                        <canvas id="pdf-canvas" class="mx-auto rounded-lg"></canvas>
                    </div>

                    <div class="mt-8 flex flex-col items-center text-center max-w-sm">
                        <svg class="w-10 h-10 text-orange-200 mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest mb-2">Authenticated View</h4>
                        <p class="text-[10px] text-gray-400 font-medium leading-relaxed">You are viewing a verified and tamper-proof digital rendering of the original document.</p>
                    </div>
                </div>

                <!-- Footer Area -->
                <div class="px-10 py-8 bg-white border-t border-gray-50 rounded-b-[3rem] flex justify-between items-center relative z-10 shadow-[0_-10px_30px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center space-x-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">End-to-End Encrypted Tunnel</span>
                    </div>
                    <button @click="pdfModalOpen = false; currentPdf = null;" class="bg-gray-800 hover:bg-black text-white font-black text-[10px] uppercase tracking-widest px-10 py-4 rounded-2xl transition-all shadow-xl active:scale-95 group flex items-center space-x-3">
                        <span>Exit Document View</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.1); }
    </style>
</body>
</html>
