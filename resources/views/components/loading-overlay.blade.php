<div
    x-data
    x-show="$store.loading.show"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] flex items-center justify-center bg-white/80 backdrop-blur-sm"
>
    <div class="flex flex-col items-center gap-4">
        <div class="h-10 w-10 animate-spin rounded-full border-4 border-slate-200 border-t-primary-600"></div>
        <p class="text-sm font-medium text-slate-600">Memproses...</p>
    </div>
</div>
