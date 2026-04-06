@extends('layouts.auth')

@section('content')
<div class="glass-card shadow-2xl rounded-3xl p-8 border-t-4 border-orange-500 transform transition-transform hover:scale-[1.01]">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-orange-600 mb-2 tracking-tight">Akwaaba360</h1>
        <p class="text-gray-500 font-medium">Digital NSS Management System</p>
    </div>

    <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
        @csrf
        
        <div class="group">
            <label for="login" class="block text-sm font-semibold text-gray-700 mb-1 transition-colors group-focus-within:text-orange-500">
                Staff Number / Email / NSS Number
            </label>
            <input type="text" id="login" name="login" required 
                class="w-full px-5 py-3 rounded-xl border border-gray-200 outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100 transition-all text-gray-800 placeholder-gray-400 font-medium shadow-sm"
                placeholder="Enter your identifier"
                value="{{ old('login') }}">
            @error('login')
                <p class="text-red-500 text-xs mt-2 font-medium italic italic-none">{{ $message }}</p>
            @enderror
        </div>

        <div class="group">
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700 transition-colors group-focus-within:text-orange-500">
                    Password
                </label>
            </div>
            <input type="password" id="password" name="password" required 
                class="w-full px-5 py-3 rounded-xl border border-gray-200 outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-100 transition-all text-gray-800 placeholder-gray-400 font-medium shadow-sm"
                placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 cursor-pointer">
                <label for="remember" class="ml-2 block text-sm text-gray-600 font-medium cursor-pointer">Remember me</label>
            </div>
            <a href="#" class="text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-4 focus:ring-orange-200">
            Sign In
        </button>
    </form>

    <div class="mt-8 pt-8 border-t border-gray-100 text-center">
        <p class="text-gray-400 text-xs font-medium uppercase tracking-widest">
            Licensed to GCB Bank PLC
        </p>
    </div>
</div>
@endsection
