@extends('layouts.admin')

@section('page_title', 'Administrative Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Company Profile Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden mb-10">
            <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/20">
                <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">Organization Profile</h3>
                <p class="text-sm text-gray-400 font-medium tracking-tight">Configure your company identity and official document assets.</p>
            </div>

            @if(session('success'))
            <div class="mx-10 mt-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl">
                 <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Company Name</label>
                        <input type="text" name="company_name" required value="{{ old('company_name', $settings->company_name) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-gray-300" placeholder="Akwaaba360 Institutional">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Company Email</label>
                        <input type="email" name="company_email" required value="{{ old('company_email', $settings->company_email) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-gray-300" placeholder="hr@akwaaba360.com">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Company Phone(s)</label>
                        <input type="text" name="company_phone" required value="{{ old('company_phone', $settings->company_phone) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-gray-300" placeholder="+233 XX XXX XXXX">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">P.O. BOX Address</label>
                        <input type="text" name="po_box" value="{{ old('po_box', $settings->po_box) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-gray-300" placeholder="P O Box CT 123, Accra">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-6 border-t border-gray-50">
                    <!-- Logo Upload -->
                    <div class="space-y-4">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Official Logo</label>
                        <div class="relative group">
                             <div id="logo-preview-container" class="w-full h-32 bg-gray-50 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-200 overflow-hidden group-hover:border-orange-200 transition-all relative">
                                @if($settings->logo_path)
                                    <img id="logo-preview-img" src="{{ Storage::url($settings->logo_path) }}" class="w-full h-full object-contain">
                                @else
                                    <svg id="logo-placeholder-svg" class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <img id="logo-preview-img" class="w-full h-full object-contain hidden">
                                @endif
                                <input type="file" name="logo" id="logo-input" onchange="previewImage(this, 'logo')" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                
                                <!-- Delete Button -->
                                <button type="button" onclick="removeImage('logo')" id="logo-delete-btn" class="absolute top-2 right-2 z-20 bg-red-500 text-white p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600 @if(!$settings->logo_path) hidden @endif">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                             </div>
                             <input type="hidden" name="delete_logo" id="delete_logo_input" value="0">
                             <p id="logo-filename" class="text-[9px] font-black text-orange-500 uppercase tracking-tighter mt-2 truncate max-w-full italic"></p>
                        </div>
                    </div>

                    <!-- Digital Signature Upload -->
                    <div class="space-y-4">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Digital Signature</label>
                        <div class="relative group">
                             <div id="signature-preview-container" class="w-full h-32 bg-gray-50 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-200 overflow-hidden group-hover:border-orange-200 transition-all relative">
                                @if($settings->signature_path)
                                    <img id="signature-preview-img" src="{{ Storage::url($settings->signature_path) }}" class="w-full h-full object-contain">
                                @else
                                    <svg id="signature-placeholder-svg" class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    <img id="signature-preview-img" class="w-full h-full object-contain hidden">
                                @endif
                                <input type="file" name="signature" id="signature-input" onchange="previewImage(this, 'signature')" class="absolute inset-0 opacity-0 cursor-pointer z-10">

                                <!-- Delete Button -->
                                <button type="button" onclick="removeImage('signature')" id="signature-delete-btn" class="absolute top-2 right-2 z-20 bg-red-500 text-white p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600 @if(!$settings->signature_path) hidden @endif">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                             </div>
                             <input type="hidden" name="delete_signature" id="delete_signature_input" value="0">
                             <p id="signature-filename" class="text-[9px] font-black text-orange-500 uppercase tracking-tighter mt-2 truncate max-w-full italic"></p>
                        </div>
                    </div>

                    <!-- Official Stamp Upload -->
                    <div class="space-y-4">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Official Stamp</label>
                        <div class="relative group">
                             <div id="stamp-preview-container" class="w-full h-32 bg-gray-50 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-200 overflow-hidden group-hover:border-orange-200 transition-all relative">
                                @if($settings->stamp_path)
                                    <img id="stamp-preview-img" src="{{ Storage::url($settings->stamp_path) }}" class="w-full h-full object-contain">
                                @else
                                    <svg id="stamp-placeholder-svg" class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                    <img id="stamp-preview-img" class="w-full h-full object-contain hidden">
                                @endif
                                <input type="file" name="stamp" id="stamp-input" onchange="previewImage(this, 'stamp')" class="absolute inset-0 opacity-0 cursor-pointer z-10">

                                <!-- Delete Button -->
                                <button type="button" onclick="removeImage('stamp')" id="stamp-delete-btn" class="absolute top-2 right-2 z-20 bg-red-500 text-white p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600 @if(!$settings->stamp_path) hidden @endif">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                             </div>
                             <input type="hidden" name="delete_stamp" id="delete_stamp_input" value="0">
                             <p id="stamp-filename" class="text-[9px] font-black text-orange-500 uppercase tracking-tighter mt-2 truncate max-w-full italic"></p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-black text-xs uppercase px-12 py-5 rounded-2xl transition-all shadow-xl hover:shadow-orange-200 active:scale-[0.98]">
                        Save Company Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- HR Staff Section -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
            <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">HR Staff</h3>
                <span class="text-xs font-black uppercase text-orange-500 bg-orange-50 px-3 py-1 rounded-lg">{{ $hrStaff->count() }}</span>
            </div>

            <!-- Add HR Staff Form -->
            <form action="{{ route('admin.staff.store') }}" method="POST" class="p-8 space-y-6 border-b border-gray-50 bg-gray-50/10">
                @csrf
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest pl-1 mb-2">New Administrative Access</p>
                <div>
                    <input type="text" name="name" required placeholder="Full Name"
                        class="w-full bg-white border-none rounded-xl px-5 py-3 text-sm font-bold text-gray-700 shadow-sm focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                </div>
                <div>
                    <input type="email" name="email" required placeholder="Email Address"
                        class="w-full bg-white border-none rounded-xl px-5 py-3 text-sm font-bold text-gray-700 shadow-sm focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                </div>
                <div>
                    <input type="text" name="staff_number" required placeholder="Staff Number"
                         class="w-full bg-white border-none rounded-xl px-5 py-3 text-sm font-bold text-gray-700 shadow-sm focus:ring-2 focus:ring-orange-100 transition-all placeholder:text-gray-200">
                </div>
                <button type="submit" class="w-full bg-gray-800 hover:bg-black text-white font-black text-[10px] uppercase py-4 rounded-xl transition-all shadow-lg active:scale-95">
                    Authorize HR Staff
                </button>
            </form>

            <!-- Staff List -->
            <div class="divide-y divide-gray-50">
                @forelse($hrStaff as $staff)
                <div class="p-6 flex justify-between items-center group">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center font-bold text-gray-400 group-hover:bg-orange-500 group-hover:text-white transition-all">
                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800 tracking-tight">{{ $staff->name }}</p>
                            <p class="text-[10px] text-gray-400 font-medium tracking-wide uppercase">{{ $staff->staff_number }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="p-10 text-center text-gray-400 text-sm font-medium">
                    No HR staff currently registered.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input, type) {
        const file = input.files[0];
        const previewImg = document.getElementById(`${type}-preview-img`);
        const placeholderSvg = document.getElementById(`${type}-placeholder-svg`);
        const filenameLabel = document.getElementById(`${type}-filename`);
        const deleteBtn = document.getElementById(`${type}-delete-btn`);
        const deleteInput = document.getElementById(`delete_${type}_input`);

        if (file) {
            // Reset delete signal
            deleteInput.value = "0";

            // Show filename
            filenameLabel.textContent = `Selected: ${file.name}`;
            
            // Show delete button
            deleteBtn.classList.remove('hidden');

            // Generate preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if (placeholderSvg) placeholderSvg.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage(type) {
        const input = document.getElementById(`${type}-input`);
        const previewImg = document.getElementById(`${type}-preview-img`);
        const placeholderSvg = document.getElementById(`${type}-placeholder-svg`);
        const filenameLabel = document.getElementById(`${type}-filename`);
        const deleteBtn = document.getElementById(`${type}-delete-btn`);
        const deleteInput = document.getElementById(`delete_${type}_input`);

        // Reset input
        input.value = "";
        
        // Signal deletion
        deleteInput.value = "1";

        // Reset UI
        previewImg.classList.add('hidden');
        previewImg.src = "";
        if (placeholderSvg) placeholderSvg.classList.remove('hidden');
        filenameLabel.textContent = "";
        deleteBtn.classList.add('hidden');
    }
</script>
@endpush
@endsection
