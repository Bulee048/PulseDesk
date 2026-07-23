@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-slate']) }}>
    {{ $value ?? $slot }}
</label>
