<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-ember border border-transparent rounded-md font-semibold text-xs font-mono text-white uppercase tracking-widest hover:bg-ember active:bg-ember focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
