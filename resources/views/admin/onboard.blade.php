@extends('layouts.admin')

@section('page_title', 'Onboard Personnel')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
    <!-- Form Section -->
    <div class="lg:col-span-1">
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-50 sticky top-32">
            <h3 class="text-2xl font-black text-gray-800 mb-2 uppercase tracking-tight">New Enrollment</h3>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose mb-10">Enter details to generate temporary credentials.</p>

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.onboard.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">NSS Number</label>
                    <input type="text" name="nss_number" required placeholder="NSS-GHA-123456"
                        class="w-full px-5 py-3.5 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-medium text-gray-800"
                        value="{{ old('nss_number') }}">
                    @error('nss_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">Email Address</label>
                    <input type="email" name="email" required placeholder="personnel@example.com"
                        class="w-full px-5 py-3.5 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-medium text-gray-800"
                        value="{{ old('email') }}">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">Phone Number</label>
                    <input type="tel" name="phone_number" required placeholder="+233 XX XXX XXXX"
                        class="w-full px-5 py-3.5 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-medium text-gray-800"
                        value="{{ old('phone_number') }}">
                    @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-orange-gradient text-orange-500 font-extrabold py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        <span>Onboard Personnel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- List Section -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
            <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-xl font-extrabold text-gray-800">Enrolled Personnel</h3>
                <div class="relative">
                    <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-200 outline-none">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-xs font-black uppercase tracking-widest bg-gray-50/50">
                            <th class="px-10 py-5">Personnel</th>
                            <th class="px-10 py-5">NSS Number</th>
                            <th class="px-10 py-5">Status</th>
                            <th class="px-10 py-5">Date Enrolled</th>
                            <th class="px-10 py-5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($personnel as $p)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-10 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center font-bold text-orange-600">
                                            {{ strtoupper(substr($p->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $p->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $p->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-5 font-semibold text-gray-600">{{ $p->nss_number }}</td>
                                <td class="px-10 py-5">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-green-200">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-10 py-5 text-sm text-gray-400 font-medium">{{ $p->created_at->format('j M Y') }}</td>
                                <td class="px-10 py-5 text-right">
                                    <button class="p-2 text-gray-400 hover:text-orange-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-10 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-6 bg-orange-50 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-700">No personnel found</h4>
                                        <p class="text-gray-400 font-medium max-w-xs">Use the form on the left to start adding National Service personnel.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
