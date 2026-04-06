@extends('layouts.admin')

@section('page_title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
    <!-- Stat Card 1 -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 flex items-center space-x-6 hover:shadow-xl transition-all border-l-8 border-orange-500 group">
        <div class="p-4 bg-orange-50 rounded-2xl group-hover:scale-110 transition-transform">
            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-black uppercase text-gray-400 tracking-widest mb-1">Total Personnel</p>
            <h3 class="text-4xl font-extrabold text-gray-800">1,284</h3>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 flex items-center space-x-6 hover:shadow-xl transition-all border-l-8 border-orange-400 group">
        <div class="p-4 bg-orange-50 rounded-2xl group-hover:scale-110 transition-transform">
            <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-black uppercase text-gray-400 tracking-widest mb-1">Pending Endorsement</p>
            <h3 class="text-4xl font-extrabold text-gray-800">45</h3>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 flex items-center space-x-6 hover:shadow-xl transition-all border-l-8 border-orange-300 group">
        <div class="p-4 bg-orange-50 rounded-2xl group-hover:scale-110 transition-transform">
            <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <div>
            <p class="text-xs font-black uppercase text-gray-400 tracking-widest mb-1">Active Departments</p>
            <h3 class="text-4xl font-extrabold text-gray-800">12</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="mb-8 flex justify-between items-end relative z-10">
            <div>
                <h3 class="text-2xl font-extrabold text-gray-800">Recent Onboarding</h3>
                <p class="text-sm text-gray-400 font-medium">Last 5 personnel added to the system</p>
            </div>
            <a href="{{ route('admin.onboard') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">View All &rarr;</a>
        </div>

        <div class="space-y-6 relative z-10">
            @forelse([] as $p)
                <!-- Personnel Item -->
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="p-6 bg-gray-50 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-600">No recent activity</h4>
                    <p class="text-sm text-gray-400 max-w-[200px]">Start by onboarding new National Service personnel.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-orange-gradient p-10 rounded-[2.5rem] shadow-2xl relative flex flex-col justify-between text-white">
        <div class="relative z-10">
            <h3 class="text-3xl font-black mb-4 leading-tight">Welcome back, Administrator.</h3>
            <p class="text-orange-100 font-medium opacity-90 max-w-md leading-relaxed text-lg mb-8">
                The Akwaaba360 portal is ready. You have **45 personnel** awaiting endorsement and **3 new** department requests this morning.
            </p>
            
            <button class="bg-white text-orange-600 font-extrabold px-8 py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95">
                Generate Monthly Reports
            </button>
        </div>
        
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mb-32 blur-3xl"></div>
    </div>
</div>
@endsection
