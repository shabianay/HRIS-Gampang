@php
    $message = null;
    $type = 'success';

    if (session('success')) {
        $message = session('success');
    } elseif (session('error')) {
        $message = session('error');
        $type = 'error';
    } elseif (session('info')) {
        $message = session('info');
        $type = 'info';
    } elseif (session('status') === 'profile-updated') {
        $message = 'Profil berhasil diperbarui.';
    } elseif (session('status') === 'password-updated') {
        $message = 'Password berhasil diubah.';
    } elseif (session('status') === 'verification-link-sent') {
        $message = 'Link verifikasi telah dikirim.';
    } elseif (session('status')) {
        $message = session('status');
    }
@endphp

@if($message)
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transform ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         class="fixed top-4 right-4 z-50 max-w-sm w-full pointer-events-auto">
        <div class="rounded-xl shadow-lg border p-4 flex items-start gap-3
            @if($type === 'success') bg-emerald-50 border-emerald-200 text-emerald-800
            @elseif($type === 'error') bg-red-50 border-red-200 text-red-800
            @else bg-blue-50 border-blue-200 text-blue-800
            @endif">
            <div class="flex-shrink-0 mt-0.5">
                @if($type === 'success')
                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @elseif($type === 'error')
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>
            <p class="text-sm font-medium flex-1">{{ $message }}</p>
            <button @click="show = false" class="flex-shrink-0 p-0.5 rounded-lg hover:bg-black/5 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
@endif
