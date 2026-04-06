@extends('layouts.admin')

@section('page_title', 'Manage Personnel')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
        <div>
            <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">Institutional Personnel</h3>
            <p class="text-sm text-gray-400 font-medium tracking-tight">Overview of all recognized and onboarded staff within Akwaaba360.</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-xs font-black uppercase text-orange-500 bg-orange-50 px-4 py-2 rounded-xl">
                Total Personnel: {{ $personnel->count() }}
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
                    <th class="px-10 py-6">Identity</th>
                    <th class="px-10 py-6">NSS ID</th>
                    <th class="px-10 py-6">Current Flow</th>
                    <th class="px-10 py-6">Department</th>
                    <th class="px-10 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($personnel as $p)
                <tr class="hover:bg-gray-50/50 transition-all group">
                    <td class="px-10 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-11 h-11 bg-orange-gradient rounded-2xl flex items-center justify-center font-black text-white text-sm shadow-md transition-transform group-hover:scale-105">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-extrabold text-gray-800 text-sm tracking-tight">{{ $p->name }}</p>
                                <p class="text-xs text-gray-400 font-medium">{{ $p->phone_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-6 font-bold text-gray-600 text-sm tracking-widest uppercase">
                        {{ $p->nss_number }}
                    </td>
                    <td class="px-10 py-6">
                        @php
                            $status = $p->onboardingRecord->status ?? 'onboarded';
                            $colorClass = match($status) {
                                'endorsed' => 'bg-green-100 text-green-600',
                                'shortlisted' => 'bg-blue-100 text-blue-600',
                                default => 'bg-gray-100 text-gray-500',
                            };
                        @endphp
                        <span class="px-3 py-1 {{ $colorClass }} rounded-lg text-[10px] font-black uppercase tracking-widest">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="px-10 py-6">
                        <form action="{{ route('admin.manage-personnel.assign', $p->id) }}" method="POST">
                            @csrf
                            <select name="department_id" onchange="this.form.submit()" class="bg-gray-50 border-none text-xs font-bold text-gray-600 rounded-xl px-4 py-2 hover:bg-gray-100 transition-colors focus:ring-0">
                                <option value="">Select Dept</option>
                                @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ $p->department_id == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-10 py-6 text-right">
                        <div class="flex justify-end space-x-2">
                             <form action="{{ route('admin.manage-personnel.toggle', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-orange-50 hover:text-orange-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-10 py-32 text-center text-gray-400 font-medium">
                        No personnel available to manage.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
