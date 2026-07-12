<div
    x-data
    x-show="$store.confirm.show"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="$store.confirm.cancel()"></div>

    <div
        x-show="$store.confirm.show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="relative bg-white rounded-2xl shadow-2xl shadow-slate-900/20 p-6 w-full max-w-sm mx-auto"
    >
        <div class="flex items-center gap-3 mb-4">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl"
                  :class="{
                      'bg-red-100': $store.confirm.type === 'danger',
                      'bg-amber-100': $store.confirm.type === 'warning',
                      'bg-blue-100': $store.confirm.type !== 'danger' && $store.confirm.type !== 'warning'
                  }">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     :class="{
                         'text-red-600': $store.confirm.type === 'danger',
                         'text-amber-600': $store.confirm.type === 'warning',
                         'text-blue-600': $store.confirm.type !== 'danger' && $store.confirm.type !== 'warning'
                     }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </span>
            <div>
                <p class="text-base font-semibold text-slate-900" x-text="$store.confirm.type === 'danger' ? 'Konfirmasi Hapus' : 'Konfirmasi'"></p>
                <p class="text-sm text-slate-500 mt-0.5" x-text="$store.confirm.message"></p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
            <button type="button" @click="$store.confirm.cancel()" class="btn-secondary text-sm px-4 py-2" x-text="$store.confirm.cancelText"></button>
            <button type="button" @click="$store.confirm.confirm()"
                    class="text-sm px-4 py-2 rounded-lg font-semibold text-white transition-colors"
                    :class="{
                        'bg-red-600 hover:bg-red-700': $store.confirm.type === 'danger',
                        'bg-amber-600 hover:bg-amber-700': $store.confirm.type === 'warning',
                        'bg-primary-600 hover:bg-primary-700': $store.confirm.type !== 'danger' && $store.confirm.type !== 'warning'
                    }"
                    x-text="$store.confirm.confirmText">
            </button>
        </div>
    </div>
</div>
