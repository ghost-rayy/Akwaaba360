@extends('layouts.admin')

@section('page_title', 'Shortlist Personnel')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">Personnel Selection</h3>
            <p class="text-sm text-gray-400 font-medium">Select personnel to advance them to the endorsement stage.</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-xs font-black uppercase text-orange-500 bg-orange-50 px-4 py-2 rounded-xl">
                Ready for Shortlist: {{ $personnel->count() }}
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
                    <th class="px-10 py-6 uppercase">NSS Identifier</th>
                    <th class="px-10 py-6 uppercase">Current Step</th>
                    <th class="px-10 py-6 text-right uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($personnel as $p)
                <tr class="hover:bg-orange-50/20 transition-all group">
                    <td class="px-10 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-11 h-11 bg-orange-gradient rounded-2xl flex items-center justify-center font-black text-white shadow-lg transform transition-transform group-hover:scale-110">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm tracking-tight">{{ $p->name }}</p>
                                <p class="text-xs text-gray-400 font-medium">{{ $p->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-6 font-bold text-gray-600 text-sm tracking-widest">
                        {{ $p->nss_number }}
                    </td>
                    <td class="px-10 py-6">
                        <span class="px-4 py-1.5 bg-gray-100 text-gray-500 rounded-xl text-[10px] font-black uppercase tracking-widest border border-gray-200">
                            {{ $p->onboardingRecord->status ?? 'onboarded' }}
                        </span>
                    </td>
                    <td class="px-10 py-6 text-right">
                        <form action="{{ route('admin.shortlist.store', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-white border-2 border-orange-500 text-orange-500 hover:bg-orange-600 hover:text-white font-black text-xs uppercase px-6 py-2.5 rounded-2xl transition-all shadow-sm hover:shadow-orange-200 active:scale-95">
                                Shortlist
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-32 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h4 class="text-xl font-extrabold text-gray-700">No personnel available</h4>
                            <p class="text-gray-400 font-medium max-w-xs mt-2">Add new personnel in the onboarding module to start shortlisting.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
