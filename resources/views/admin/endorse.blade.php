@extends('layouts.admin')

@section('page_title', 'Endorse Personnel')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-orange-50/10">
        <div>
            <h3 class="text-xl font-extrabold text-orange-600 tracking-tight flex items-center">
                Final Endorsement
                <span class="ml-4 px-3 py-1 bg-orange-100 text-orange-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Phase 2</span>
            </h3>
            <p class="text-sm text-gray-500 font-medium">Verify and officially endorse shortlisted personnel for placement.</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="flex -space-x-4">
                @foreach($personnel->take(5) as $p)
                <div class="w-10 h-10 bg-orange-gradient border-2 border-white rounded-xl flex items-center justify-center font-bold text-white text-xs shadow-lg">
                    {{ strtoupper(substr($p->name, 0, 1)) }}
                </div>
                @endforeach
            </div>
            <span class="text-xs font-black uppercase text-gray-400 tracking-widest pl-2">
                Awaiting Review: {{ $personnel->count() }}
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="mx-10 mt-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl">
        <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-xs font-black uppercase tracking-widest bg-gray-50/50">
                    <th class="px-10 py-6 uppercase">Personnel</th>
                    <th class="px-10 py-6 uppercase">NSS Number</th>
                    <th class="px-10 py-6 uppercase">Status</th>
                    <th class="px-10 py-6 text-right uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($personnel as $p)
                <tr class="hover:bg-orange-50/30 transition-all group">
                    <td class="px-10 py-6 text-sm">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white border border-orange-100 rounded-2xl flex items-center justify-center shadow-sm transform transition-transform group-hover:scale-105 group-hover:shadow-lg">
                                <span class="text-xl font-black text-orange-500">{{ strtoupper(substr($p->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-extrabold text-gray-800 tracking-tight">{{ $p->name }}</p>
                                <p class="text-xs text-gray-400 font-medium">{{ $p->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-6 font-bold text-gray-600 text-sm tracking-widest uppercase">
                        {{ $p->nss_number }}
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-orange-400 rounded-full animate-pulse"></div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-orange-500">Shortlisted</span>
                        </div>
                    </td>
                    <td class="px-10 py-6 text-right">
                        <form action="{{ route('admin.endorse.store', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-black text-[10px] uppercase px-8 py-3.5 rounded-2xl transition-all shadow-xl hover:shadow-orange-200 active:scale-95 transform hover:-translate-y-1">
                                Endorse Now
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-32 text-center text-gray-400 font-medium">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-600 tracking-tight">No personnel to endorse</h4>
                            <p class="text-sm max-w-xs mt-2 leading-relaxed">Personnel must be shortlisted before they can be officially endorsed.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
