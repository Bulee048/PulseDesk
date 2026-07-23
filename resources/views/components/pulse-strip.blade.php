<div 
    x-data="{ pulsing: false }" 
    @ticket-updated.window="pulsing = false; setTimeout(() => pulsing = true, 10);"
    @ticket-created.window="pulsing = false; setTimeout(() => pulsing = true, 10);"
    class="fixed top-0 left-0 w-full h-1 z-50 origin-left bg-signal"
    :class="pulsing ? 'animate-pulse-strip' : ''"
    @animationend="pulsing = false"
></div>
