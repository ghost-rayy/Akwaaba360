@extends('layouts.admin')

@section('page_title', 'Appointment Letters')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-green-50/10">
        <div>
            <h3 class="text-xl font-extrabold text-green-700 tracking-tight">Finalized Personnel</h3>
            <p class="text-sm text-gray-500 font-medium tracking-tight">Endorsed candidates. Ready for official appointment issuance.</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-xs font-black uppercase text-green-600 bg-green-100 px-4 py-2 rounded-xl">
                Ready: {{ $personnel->count() }}
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
                    <th class="px-10 py-6 uppercase">Full Name</th>
                    <th class="px-10 py-6 uppercase">NSS Identification</th>
                    <th class="px-10 py-6 uppercase">Endorsement Date</th>
                    <th class="px-10 py-6 text-right uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($personnel as $p)
                <tr class="hover:bg-green-50/20 transition-all group">
                    <td class="px-10 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-gradient rounded-2xl flex items-center justify-center font-black text-white shadow-lg transition-transform group-hover:rotate-12">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-extrabold text-gray-800 text-sm tracking-tight">{{ $p->name }}</p>
                                <p class="text-xs text-gray-400 font-medium">{{ $p->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-6 font-bold text-gray-600 text-sm tracking-widest">
                        {{ $p->nss_number }}
                    </td>
                    <td class="px-10 py-6">
                        <span class="text-xs font-bold text-gray-400">
                            {{ $p->onboardingRecord->endorsed_at->format('M d, Y') }}
                        </span>
                    </td>
                    <td class="px-10 py-6 text-right flex justify-end items-center space-x-3">
                        <form action="{{ route('admin.appointment.send', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-gray-800 hover:bg-black text-white font-black text-[10px] uppercase px-6 py-3.5 rounded-2xl transition-all shadow-xl active:scale-95 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>Send to Email</span>
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.appointment.show', $p->id) }}" target="_blank" class="bg-orange-600 hover:bg-orange-700 text-white font-black text-[10px] uppercase px-8 py-3.5 rounded-2xl transition-all shadow-xl hover:shadow-orange-200 active:scale-95 inline-block">
                            Issue Letter
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-32 text-center text-gray-400 font-medium">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-700 tracking-tight">No letters to issue</h4>
                            <p class="text-sm max-w-sm mt-3 opacity-60">Wait for candidates to be endorsed by the HR team to start issuing official appointment letters.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
