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
    <div class="lg:col-span-3" x-data="{ 
        editModal: false, 
        currentUser: {},
        openEdit(user) {
            this.currentUser = user;
            this.editModal = true;
        }
    }">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden min-h-[600px]">
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
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center font-black text-orange-600 shadow-sm border-2 border-white uppercase">
                                            {{ substr($p->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-gray-800 leading-none mb-1">{{ $p->name }}</p>
                                            <p class="text-xs text-gray-400 font-medium">{{ $p->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-5 font-bold text-gray-600 tracking-tight">{{ $p->nss_number }}</td>
                                <td class="px-10 py-5">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[10px] font-black uppercase tracking-widest border border-green-200">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-10 py-5 text-sm text-gray-400 font-bold italic opacity-60">{{ $p->created_at->format('j M Y') }}</td>
                                <td class="px-10 py-5 text-right relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="p-2.5 text-gray-400 hover:text-orange-500 hover:bg-orange-50 rounded-xl transition-all active:scale-90">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                    </button>

                                    <!-- Action Menu -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         class="absolute right-10 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden py-2"
                                         style="display: none;">
                                        
                                        <button @click="openEdit({{ json_encode($p) }}); open = false" class="w-full flex items-center space-x-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-orange-500 transition-colors text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            <span>Edit Details</span>
                                        </button>

                                        <form action="{{ route('admin.onboard.resend', $p->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-orange-500 transition-colors text-left">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                <span>Resend Credentials</span>
                                            </button>
                                        </form>

                                        <div class="border-t border-gray-50 my-1"></div>

                                        <form action="{{ route('admin.onboard.destroy', $p->id) }}" method="POST" onsubmit="return confirm('CRITICAL ACTION: Are you sure you want to permanently remove this personnel record? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors text-left">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>Delete Permanently</span>
                                            </button>
                                        </form>
                                    </div>
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

        <!-- Edit Modal -->
        <div x-show="editModal" 
             style="display: none;"
             class="fixed inset-0 z-[60] flex items-center justify-center p-6 bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            
            <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl p-10 relative overflow-hidden" 
                 @click.away="editModal = false"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="scale-95 opacity-0"
                 x-transition:enter-end="scale-100 opacity-100">
                
                <h3 class="text-3xl font-black text-gray-800 mb-2 uppercase tracking-tight">Edit Personnel</h3>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose mb-10">Updates take effect immediately.</p>

                <form :action="'{{ url('admin/onboard') }}/' + currentUser.id" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">Full Name</label>
                        <input type="text" name="name" required x-model="currentUser.name"
                            class="w-full px-5 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-bold text-gray-800 shadow-inner">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">Email Address</label>
                        <input type="email" name="email" required x-model="currentUser.email"
                            class="w-full px-5 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-bold text-gray-800 shadow-inner">
                        <p class="text-[10px] text-orange-500 font-black uppercase mt-2 tracking-widest bg-orange-50 px-3 py-1 rounded-lg inline-block">Security Alert: Changing email will reset access credentials</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">Phone Number</label>
                        <input type="tel" name="phone_number" required x-model="currentUser.phone_number"
                            class="w-full px-5 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100 outline-none transition-all font-bold text-gray-800 shadow-inner">
                    </div>

                    <div class="pt-4 flex space-x-4">
                        <button type="button" @click="editModal = false" class="flex-1 bg-gray-100 text-gray-500 font-extrabold py-4 rounded-2xl hover:bg-gray-200 transition-all active:scale-95">Cancel</button>
                        <button type="submit" class="flex-1 bg-orange-gradient text-orange-500 font-extrabold py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
