@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 bg-white text-slate-900 focus:border-primary-500 focus:ring-primary-500/20 rounded-xl shadow-sm placeholder:text-slate-400 transition-all duration-200']) }}>
