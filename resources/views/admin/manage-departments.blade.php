@extends('layouts.admin')

@section('page_title', 'Manage Departments')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Add Department Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[2.5rem] shadow-xl p-10 border border-gray-50">
            <h3 class="text-2xl font-black text-gray-800 tracking-tight mb-2 uppercase">Create Unit</h3>
            <p class="text-xs text-gray-400 font-bold tracking-widest leading-loose mb-10">Establish a new organizational department and assign a supervisor.</p>

            <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Department Name</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 placeholder:text-gray-300 focus:ring-2 focus:ring-orange-500 transition-all shadow-sm" placeholder="e.g. IT Department">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Assign Supervisor</label>
                    <select name="supervisor_id" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-orange-500 transition-all shadow-sm">
                        <option value="">Select HR Staff</option>
                        @foreach($supervisors as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Description (Optional)</label>
                    <textarea name="description" rows="3" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700 placeholder:text-gray-300 focus:ring-2 focus:ring-orange-500 transition-all shadow-sm"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-orange-gradient hover:bg-orange-700 text-white font-black text-xs uppercase py-5 rounded-2xl transition-all shadow-xl hover:shadow-orange-200 active:scale-[0.98]">
                        Establish Department
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Departments List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
            <div class="px-10 py-8 border-b border-gray-50">
                <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">Existing Departments</h3>
                <p class="text-sm text-gray-400 font-medium">Organizational breakdown of Akwaaba360 units.</p>
            </div>

            @if(session('success'))
            <div class="mx-10 mt-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl">
                <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
            @endif

            <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($departments as $d)
                <div class="bg-gray-50/50 border border-gray-100 rounded-3xl p-8 hover:bg-orange-50/20 transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center shadow-sm">
                            <span class="text-lg font-black text-orange-500">{{ strtoupper(substr($d->name, 0, 1)) }}</span>
                        </div>
                        <span class="text-xs font-black text-gray-300 group-hover:text-orange-300 transition-colors uppercase tracking-widest pl-2">
                            ID: #{{ str_pad($d->id, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <h4 class="text-lg font-extrabold text-gray-800 tracking-tight mb-2">{{ $d->name }}</h4>
                    <p class="text-xs text-gray-400 font-medium mb-8 leading-relaxed">{{ $d->description ?: 'No description provided.' }}</p>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Supervisor</p>
                            <p class="text-xs font-extrabold text-gray-700 tracking-tight">{{ $d->supervisor->name ?? 'Unassigned' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Staff Count</p>
                            <p class="text-xs font-extrabold text-gray-700 tracking-tight">{{ $d->personnel_count }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-32 text-center text-gray-400 font-medium">
                    No departments established yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
