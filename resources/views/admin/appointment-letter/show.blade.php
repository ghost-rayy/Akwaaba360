<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Letter - {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; margin: 0; }
            .letter-container { box-shadow: none; border: none; margin: 0; width: 100%; height: auto; }
        }
        body { font-family: 'Outfit', sans-serif; }
        .official-heading { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 py-12 px-4">
    <!-- Toolbar -->
    <div class="fixed top-8 left-0 right-0 z-50 flex justify-center no-print">
        <div class="bg-white/80 backdrop-blur-xl px-8 py-4 rounded-[2rem] shadow-2xl border border-white flex items-center space-x-6">
            <p class="text-sm font-black text-gray-800 tracking-tight">Akwaaba360 <span class="text-orange-500 font-extrabold ml-2">Document Engine</span></p>
            <div class="w-px h-6 bg-gray-200"></div>
            <button onclick="window.print()" class="bg-orange-600 hover:bg-orange-700 text-white font-black text-xs uppercase px-8 py-3 rounded-2xl transition-all shadow-xl hover:shadow-orange-200 active:scale-95">
                Print / Save PDF
            </button>
            <button onclick="window.close()" class="text-gray-400 hover:text-gray-600 font-black text-xs uppercase tracking-widest">
                Close
            </button>
        </div>
    </div>

    <!-- Letter Container -->
    <div class="letter-container max-w-[850px] mx-auto bg-white shadow-2xl rounded-[3rem] p-24 relative overflow-hidden min-h-[1100px]">
        <!-- Watermark / Design Element -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-orange-50 rounded-full opacity-50 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-orange-50 rounded-full opacity-50 blur-3xl"></div>

        <!-- Header -->
        <div class="flex justify-between items-start mb-24 relative">
            <div>
                <h1 class="official-heading text-4xl font-black text-gray-900 tracking-tight leading-none mb-2 uppercase">Akwaaba360</h1>
                <p class="text-sm font-black text-orange-500 uppercase tracking-widest">Institutional Onboarding</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Date Issuance</p>
                <p class="font-extrabold text-gray-800 tracking-tight">{{ date('F d, Y') }}</p>
            </div>
        </div>

        <!-- Recipient -->
        <div class="mb-16">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Letter Addressed To</p>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">{{ $user->name }}</h2>
            <p class="font-bold text-gray-500 text-lg">NSS ID: {{ $user->nss_number }}</p>
            <p class="font-bold text-gray-400 text-sm italic mt-1">{{ $user->email }}</p>
        </div>

        <!-- Body -->
        <div class="text-gray-700 leading-relaxed space-y-8 text-lg font-medium">
            <h3 class="text-xl font-bold text-gray-900 tracking-tight border-b-2 border-orange-500 inline-block pb-1">Sub: LETTER OF APPOINTMENT</h3>
            
            <p>Dear <span class="font-bold text-gray-900">{{ $user->name }}</span>,</p>

            <p>Following your successful enrollment and endorsement through the Akwaaba360 Personnel Management System, we are delighted to officially offer you an appointment within the organization.</p>

            <p>Your appointment is governed by the regulations set forth by the National Service Secretariat and the internal policies of Akwaaba360. This role is a vital component of our organizational workforce and we look forward to your active contribution.</p>

            <p>By accepting this letter, you agree to adhere to the core values of professionalism, accountability, and excellence that define our institution.</p>

            <p>Please log in to your **Akwaaba360 Portal** to complete your final documentation and view your department assignment details.</p>
        </div>

        <!-- Signatures -->
        <div class="mt-32 pt-16 border-t border-gray-100 flex justify-between items-end">
            <div>
                <p class="text-sm font-black text-gray-900 mb-10">Director of Human Resources</p>
                <div class="w-48 h-px bg-gray-200"></div>
                <p class="mt-4 text-xs font-black text-gray-400 uppercase tracking-widest leading-none">Official Seal / Signature</p>
            </div>
            <div class="text-right flex flex-col items-end">
                <div class="w-16 h-16 bg-orange-gradient rounded-2xl shadow-xl flex items-center justify-center font-black text-white text-xl mb-4">A</div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] leading-none">Akwaaba360 Verified</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-16 left-24 right-24 text-center">
            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.5em] leading-none">Strictly Confidential • Akwaaba360 Onboarding System</p>
        </div>
    </div>
</body>
</html>
