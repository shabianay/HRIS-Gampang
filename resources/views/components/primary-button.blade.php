<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-primary-600/25 hover:bg-primary-700 hover:shadow-xl hover:shadow-primary-600/30 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
