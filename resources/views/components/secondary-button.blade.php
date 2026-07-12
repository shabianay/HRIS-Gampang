<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-200 rounded-xl font-semibold text-sm text-slate-700 shadow-sm hover:bg-slate-50 hover:border-slate-300 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
