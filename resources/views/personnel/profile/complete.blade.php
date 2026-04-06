@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col items-center justify-center p-6" x-data="{ 
    step: 1,
    fileName: '',
    formData: {
        first_name: '',
        surname: '',
        gender: '',
        residence: '',
        university: '',
        program: '',
        region: '',
        academic_year: '',
        confirmation: false
    },
    nextStep() { if(this.step < 3) this.step++; },
    prevStep() { if(this.step > 1) this.step--; },
    handleFileChange(e) {
        if(e.target.files.length > 0) {
            this.fileName = e.target.files[0].name;
        }
    }
}">
    <!-- Progress Header -->
    <div class="w-full max-w-2xl mb-12">
        <div class="flex justify-between items-center relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-10 -translate-y-1/2 rounded-full"></div>
            <div class="absolute top-1/2 left-0 h-1 bg-orange-500 -z-10 -translate-y-1/2 rounded-full transition-all duration-500" :style="'width: ' + ((step-1)*50) + '%'"></div>
            
            <template x-for="i in 3">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black transition-all duration-500 shadow-xl border-4"
                        :class="step >= i ? 'bg-orange-500 text-white border-orange-100 scale-110' : 'bg-white text-gray-300 border-gray-50'">
                        <span x-text="i"></span>
                    </div>
                </div>
            </template>
        </div>
        <div class="flex justify-between mt-4 px-2">
            <span class="text-[10px] font-black uppercase tracking-widest transition-colors" :class="step >= 1 ? 'text-orange-600' : 'text-gray-300'">Identity</span>
            <span class="text-[10px] font-black uppercase tracking-widest transition-colors" :class="step >= 2 ? 'text-orange-600' : 'text-gray-300'">Academic</span>
            <span class="text-[10px] font-black uppercase tracking-widest transition-colors" :class="step >= 3 ? 'text-orange-600' : 'text-gray-300'">Verification</span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="w-full max-w-2xl bg-white rounded-[3rem] shadow-2xl shadow-orange-100/50 border border-white p-12 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-orange-600"></div>

        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Step 1: Basic Identity -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0">
                <header class="mb-10">
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight mb-2 uppercase">Basic Identity</h2>
                    <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">Verify your personal details.</p>
                </header>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">First Name</label>
                        <input type="text" name="first_name" x-model="formData.first_name" required
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Surname</label>
                        <input type="text" name="surname" x-model="formData.surname" required
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                    </div>
                    <div class="col-span-2 space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Gender Identification</label>
                        <select name="gender" x-model="formData.gender" required
                            class="w-full bg-gray-100 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-span-2 space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Current Place of Residence</label>
                        <textarea name="residence" x-model="formData.residence" required rows="3"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200"></textarea>
                    </div>
                </div>
            </div>

            <!-- Step 2: Academic Background -->
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                <header class="mb-10">
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight mb-2 uppercase">Academic Background</h2>
                    <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">Educational origins and placement.</p>
                </header>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">University / Institution</label>
                        <input type="text" name="university" x-model="formData.university" required
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Programme of Study</label>
                        <input type="text" name="program" x-model="formData.program" required
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Region of Institution</label>
                            <input type="text" name="region" x-model="formData.region" required
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">NSS Academic Year</label>
                            <input type="text" name="academic_year" x-model="formData.academic_year" required placeholder="e.g. 2024/2025"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 shadow-inner focus:ring-2 focus:ring-orange-100 transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Documentation -->
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                <header class="mb-10">
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight mb-2 uppercase">Final Verification</h2>
                    <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">Official documentation upload.</p>
                </header>

                <div class="space-y-8">
                    <div class="bg-orange-50/50 p-8 rounded-[2rem] border-2 border-dashed border-orange-100 relative group transition-all hover:bg-orange-50"
                         :class="fileName ? 'border-orange-500 bg-orange-50' : ''">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center text-orange-500 transition-transform group-hover:-translate-y-1">
                                <svg x-show="!fileName" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <svg x-show="fileName" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-black text-gray-800 uppercase tracking-widest mb-1" x-text="fileName ? fileName : 'Official NSS Posting Letter'"></p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase" x-text="fileName ? 'Document Selected' : 'PDF format only (Max 5MB)'"></p>
                            </div>
                            <input type="file" name="nss_posting_letter" required accept="application/pdf" @change="handleFileChange"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 p-6 rounded-2xl flex items-start space-x-4">
                        <div class="pt-1">
                            <input type="checkbox" name="confirmation" required x-model="formData.confirmation"
                                class="w-5 h-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        </div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase leading-relaxed tracking-wide">
                            I confirm that all information provided is accurate and matches my official NSS documentation. I understand that false information will lead to disqualification.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="pt-10 flex items-center justify-between">
                <button type="button" x-show="step > 1" @click="prevStep()" 
                    class="bg-gray-100 text-gray-400 font-black text-[10px] uppercase px-10 py-5 rounded-2xl hover:bg-gray-200 transition-all active:scale-95">Back</button>
                <div x-show="step === 1" class="flex-1"></div>
                
                <button type="button" x-show="step < 3" @click="nextStep()" 
                    class="bg-orange-600 text-white font-black text-[10px] uppercase px-12 py-5 rounded-2xl shadow-xl hover:bg-orange-700 transition-all transform hover:-translate-y-1 active:scale-95">Next Phase</button>
                
                <button type="submit" x-show="step === 3" 
                    class="bg-black text-white font-black text-[10px] uppercase px-12 py-5 rounded-2xl shadow-2xl hover:bg-gray-900 transition-all transform hover:-translate-y-1 active:scale-95">Complete Enrollment</button>
            </div>
        </form>
    </div>

    <!-- Security Note -->
    <p class="mt-12 text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] flex items-center space-x-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        <span>Secure End-to-End Encryption Enabled</span>
    </p>
</div>
@endsection
