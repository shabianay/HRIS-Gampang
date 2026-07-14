<x-admin-layout>
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Jam Kantor</h1>
            <p class="text-sm text-slate-500 mt-1">Atur jam masuk dan jam pulang kantor</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-medium">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card p-4 sm:p-5">
            <h3 class="text-base font-semibold text-slate-900 mb-4">Pengaturan Jam Kantor</h3>
            <form action="{{ route('settings.office-hours.update', $officeHour) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="clock_in_time" class="block text-sm font-medium text-slate-700 mb-1">Jam Masuk</label>
                        <input type="time" id="clock_in_time" name="clock_in_time" value="{{ \Carbon\Carbon::parse($officeHour->clock_in_time)->format('H:i') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label for="clock_out_time" class="block text-sm font-medium text-slate-700 mb-1">Jam Pulang</label>
                        <input type="time" id="clock_out_time" name="clock_out_time" value="{{ \Carbon\Carbon::parse($officeHour->clock_out_time)->format('H:i') }}" class="input-field w-full">
                    </div>
                </div>
                <div class="mt-4">
                    <x-primary-button class="justify-center">Simpan Pengaturan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
