@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f1f5f9] p-8 lg:p-12">
    <!-- Navbar / Header -->
    <div class="max-w-7xl mx-auto mb-12 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-gray-800 tracking-tight uppercase">Personnel Dashboard</h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Academic Year {{ $user->personnelProfile->academic_year ?? 'N/A' }}</p>
        </div>
        <div class="flex items-center space-x-6">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-black text-gray-800 leading-none">{{ $user->name }}</p>
                <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-1">Verified Personnel</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-12 h-12 bg-white rounded-2xl shadow-xl border border-gray-50 flex items-center justify-center text-gray-400 hover:text-red-500 transition-all hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-white p-10 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full -translate-y-16 translate-x-16 -z-10 group-hover:scale-110 transition-transform duration-700"></div>
                
                <div class="w-20 h-20 bg-orange-600 rounded-3xl flex items-center justify-center text-white text-3xl font-black shadow-lg mb-8">
                    {{ substr($user->personnelProfile->first_name ?? $user->name, 0, 1) }}
                </div>

                <h3 class="text-2xl font-black text-gray-800 tracking-tight mb-1 uppercase">{{ $user->personnelProfile->first_name }} {{ $user->personnelProfile->surname }}</h3>
                <p class="text-xs text-orange-500 font-black uppercase tracking-widest mb-8">{{ $user->nss_number }}</p>

                <div class="space-y-4 pt-6 border-t border-gray-50">
                    <div class="flex items-center space-x-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center space-x-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ $user->phone_number }}</span>
                    </div>
                </div>

                <div class="mt-10 bg-gray-50 rounded-2xl p-6">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-2">Residential Address</p>
                    <p class="text-xs text-gray-600 font-bold leading-relaxed">{{ $user->personnelProfile->residence }}</p>
                </div>
            </div>
            
            <!-- Quick Link / Documents -->
            <div class="bg-gray-800 rounded-[2.5rem] p-10 text-white shadow-2xl">
                <h4 class="text-lg font-black uppercase tracking-tight mb-6">Your Documents</h4>
                <a href="{{ Storage::url($user->personnelProfile->posting_letter_path) }}" target="_blank" class="flex items-center justify-between group p-2">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-orange-400 group-hover:bg-orange-500 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider">NSS Posting Letter</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Official Verification</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        </div>

        <!-- Main Stats / Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Academic Information -->
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-50 overflow-hidden">
                <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                    <h3 class="text-xl font-extrabold text-gray-800 tracking-tight uppercase">Academic Information</h3>
                    <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
                </div>
                <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] mb-3">University / Institution</p>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500 italic font-black">U</div>
                            <p class="text-sm font-black text-gray-800 uppercase tracking-tight">{{ $user->personnelProfile->university }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] mb-3">Programme of Study</p>
                        <p class="text-sm font-black text-gray-800 uppercase leading-relaxed">{{ $user->personnelProfile->program }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] mb-3">Region of Institution</p>
                        <div class="inline-block bg-gray-100 rounded-lg px-3 py-1.5 text-[10px] font-black text-gray-600 uppercase tracking-widest">
                            {{ $user->personnelProfile->region }}
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] mb-3">NSS Service Region</p>
                        <p class="text-sm font-black text-orange-600 uppercase">National Service Secretariat</p>
                    </div>
                </div>
            </div>

            <!-- Enrollment Status Card -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl shadow-orange-200">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20 blur-3xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between space-y-8 md:space-y-0">
                    <div class="max-w-md">
                        <h4 class="text-3xl font-black uppercase tracking-tight mb-4">Enrollment Verified</h4>
                        <p class="text-white/80 text-sm font-bold leading-relaxed uppercase tracking-wider">
                            Your official documentation has been submitted and registered within the Akwaaba360 portal. Your placement is currently being finalized by the HR Department.
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-white/20 rounded-full border-8 border-white/10 flex items-center justify-center text-4xl mb-3">
                            ✅
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.3em]">Status: Active</span>
                    </div>
                </div>
            </div>
            
            <!-- Information Help Box -->
            <div class="bg-white rounded-[2.5rem] p-10 border border-orange-100/50 shadow-sm flex items-start space-x-6">
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h5 class="text-sm font-black text-gray-800 uppercase tracking-tight mb-2">Need to update your profile?</h5>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose">
                        Please contact the HR Department at <span class="text-orange-500">hr@akwaaba360.com</span> if you discover discrepancies in your verified information. 
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
