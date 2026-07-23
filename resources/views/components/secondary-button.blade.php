<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-line rounded-md font-semibold text-xs font-mono text-slate uppercase tracking-widest shadow-sm hover:bg-cloud focus:outline-none focus:ring-2 focus:ring-signal focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
