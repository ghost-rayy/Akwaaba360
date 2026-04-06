@extends('layouts.admin')

@section('page_title', 'Security Settings')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-50 overflow-hidden">
        <div class="px-10 py-10 border-b border-gray-50 bg-orange-50/10">
            <h3 class="text-2xl font-black text-gray-800 tracking-tight">Security & Privacy</h3>
            <p class="text-sm text-gray-400 font-medium tracking-tight mt-1">Change your account password to maintain system integrity.</p>
        </div>

        <form action="{{ route('password.change.post') }}" method="POST" class="p-10 space-y-8">
            @csrf

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl">
                <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl">
                <ul class="list-disc list-inside text-sm font-bold text-red-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="space-y-4">
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Current Password</label>
                <div class="relative">
                    <input type="password" id="current_password" name="current_password" required class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl outline-none transition-all font-medium text-gray-800 placeholder-gray-400" placeholder="••••••••">
                    <button type="button" onclick="togglePassword('current_password')" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-4">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest pl-1">New Password</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" required class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl outline-none transition-all font-medium text-gray-800 placeholder-gray-400" placeholder="••••••••">
                        <button type="button" onclick="togglePassword('new_password')" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="space-y-4">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl outline-none transition-all font-medium text-gray-800 placeholder-gray-400" placeholder="••••••••">
                        <button type="button" onclick="togglePassword('new_password_confirmation')" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Criteria -->
            <div class="bg-gray-50/50 rounded-2xl p-6 border border-gray-100">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Password Requirements</p>
                <div class="grid grid-cols-2 gap-4">
                    <div id="req-length" class="flex items-center space-x-3 text-xs font-bold text-gray-400 transition-colors duration-300">
                        <div class="w-5 h-5 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 transition-all duration-300 shadow-sm icon-container">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Minimum 8 characters</span>
                    </div>
                    <div id="req-caps" class="flex items-center space-x-3 text-xs font-bold text-gray-400 transition-colors duration-300">
                        <div class="w-5 h-5 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 transition-all duration-300 shadow-sm icon-container">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>At least one capital letter</span>
                    </div>
                    <div id="req-number" class="flex items-center space-x-3 text-xs font-bold text-gray-400 transition-colors duration-300">
                        <div class="w-5 h-5 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 transition-all duration-300 shadow-sm icon-container">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>At least one number</span>
                    </div>
                    <div id="req-special" class="flex items-center space-x-3 text-xs font-bold text-gray-400 transition-colors duration-300">
                        <div class="w-5 h-5 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 transition-all duration-300 shadow-sm icon-container">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>One special character (@$!%*#?&)</span>
                    </div>
                </div>
            </div>

            <script>
                function togglePassword(inputId) {
                    const input = document.getElementById(inputId);
                    input.type = input.type === 'password' ? 'text' : 'password';
                }

                document.getElementById('new_password').addEventListener('input', function(e) {
                    const password = e.target.value;
                    
                    const requirements = {
                        length: password.length >= 8,
                        caps: /[A-Z]/.test(password),
                        number: /[0-9]/.test(password),
                        special: /[@$!%*#?&]/.test(password)
                    };

                    updateRequirement('req-length', requirements.length);
                    updateRequirement('req-caps', requirements.caps);
                    updateRequirement('req-number', requirements.number);
                    updateRequirement('req-special', requirements.special);
                });

                function updateRequirement(id, met) {
                    const element = document.getElementById(id);
                    const iconBox = element.querySelector('.icon-container');
                    
                    if (met) {
                        element.classList.remove('text-gray-400');
                        element.classList.add('text-green-600');
                        iconBox.classList.remove('bg-gray-100', 'text-gray-300');
                        iconBox.classList.add('bg-green-100', 'text-green-600', 'shadow-green-100');
                    } else {
                        element.classList.remove('text-green-600');
                        element.classList.add('text-gray-400');
                        iconBox.classList.remove('bg-green-100', 'text-green-600', 'shadow-green-100');
                        iconBox.classList.add('bg-gray-100', 'text-gray-300');
                    }
                }
            </script>

            <div class="pt-6">
                <button type="submit" class="w-full bg-black hover:bg-orange-600 text-white font-black text-xs uppercase tracking-widest py-5 rounded-2xl transition-all shadow-2xl hover:shadow-orange-200 active:scale-95">
                    Update Password & Secure Account
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-8 flex items-center justify-center space-x-2 text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        <span class="text-xs font-bold uppercase tracking-wider">End-to-end encrypted security layer enabled</span>
    </div>
</div>
@endsection
