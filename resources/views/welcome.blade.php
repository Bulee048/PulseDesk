@php
    $plans = \App\Models\Plan::all();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PulseDesk - The Helpdesk for Teams Who Hate Helpdesks</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @media (prefers-reduced-motion: no-preference) {
                .mock-ticket {
                    animation: slide-up 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                    opacity: 0;
                    transform: translateY(20px);
                }
                .mock-ticket:nth-child(1) { animation-delay: 0.2s; }
                .mock-ticket:nth-child(2) { animation-delay: 0.8s; }
                .mock-ticket:nth-child(3) { animation-delay: 1.4s; }
                
                @keyframes slide-up {
                    to { opacity: 1; transform: translateY(0); }
                }
            }
        </style>
    </head>
    <body class="bg-cloud text-ink font-sans antialiased selection:bg-signal selection:text-white">
        <!-- Top Nav -->
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded bg-ink flex items-center justify-center">
                    <svg class="w-5 h-5 text-cloud" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/></svg>
                </div>
                <span class="font-heading font-bold text-xl tracking-tight">PulseDesk</span>
            </div>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-medium text-slate hover:text-ink transition focus:outline-none focus:ring-2 focus:ring-signal rounded-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-slate hover:text-ink transition focus:outline-none focus:ring-2 focus:ring-signal rounded-sm">Log in</a>
                    @endauth
                @endif
                <a href="{{ route('signup') }}" class="font-medium text-signal hover:text-ink transition focus:outline-none focus:ring-2 focus:ring-signal rounded-sm">Start free</a>
            </div>
        </nav>

        <!-- Hero -->
        <main>
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h1 class="text-5xl lg:text-7xl font-heading font-bold leading-tight mb-6">Stop managing tickets. Start solving problems.</h1>
                    <p class="text-xl text-slate mb-8 max-w-lg leading-relaxed">
                        Your support team doesn't need another clunky, legacy enterprise tool that takes 3 weeks to configure. PulseDesk gives you real-time collaboration, zero clutter, and blazing fast performance right out of the box.
                    </p>
                    <div class="flex gap-4 items-center">
                        <a href="{{ route('signup') }}" class="bg-signal text-white px-8 py-4 rounded-lg font-bold hover:bg-ink transition focus:outline-none focus:ring-2 focus:ring-signal focus:ring-offset-2 focus:ring-offset-cloud text-lg">Start free 14-day trial</a>
                        <span class="text-slate text-sm">No credit card required.</span>
                    </div>
                </div>
                
                <!-- Animated Mock Feed -->
                <div class="relative bg-white p-6 rounded-2xl shadow-xl border border-line overflow-hidden">
                    <!-- Pulse Strip Motif -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-signal animate-pulse-strip" style="animation-iteration-count: infinite; animation-duration: 3s;"></div>
                    
                    <div class="space-y-4 pt-2">
                        <div class="mock-ticket bg-cloud p-4 rounded-lg border border-line">
                            <div class="flex justify-between mb-2">
                                <span class="font-mono text-xs text-signal">#TKT-1042</span>
                                <span class="font-mono text-xs text-slate">Just now</span>
                            </div>
                            <h3 class="font-heading font-bold text-ink">Cannot access production database</h3>
                            <p class="text-sm text-slate mt-1 line-clamp-1">Hi team, since the deployment this morning, our app servers are returning 500s...</p>
                        </div>
                        <div class="mock-ticket bg-cloud p-4 rounded-lg border border-line">
                            <div class="flex justify-between mb-2">
                                <span class="font-mono text-xs text-ember">#TKT-1043</span>
                                <span class="font-mono text-xs text-slate">1m ago</span>
                            </div>
                            <h3 class="font-heading font-bold text-ink">Billing issue with Stripe</h3>
                            <p class="text-sm text-slate mt-1 line-clamp-1">My card was charged twice for the annual subscription.</p>
                        </div>
                        <div class="mock-ticket bg-cloud p-4 rounded-lg border border-line">
                            <div class="flex justify-between mb-2">
                                <span class="font-mono text-xs text-signal">#TKT-1044</span>
                                <span class="font-mono text-xs text-slate">3m ago</span>
                            </div>
                            <h3 class="font-heading font-bold text-ink">How do I add a new team member?</h3>
                            <p class="text-sm text-slate mt-1 line-clamp-1">Looking through the settings but can't find the invite button.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How It Works -->
            <section class="bg-white border-y border-line py-20 lg:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-4xl font-heading font-bold text-center mb-16">How PulseDesk works</h2>
                    <div class="grid md:grid-cols-3 gap-12 text-center">
                        <div>
                            <div class="w-16 h-16 bg-cloud rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-signal font-mono">1</div>
                            <h3 class="font-heading font-bold text-xl mb-3">Sign up in seconds</h3>
                            <p class="text-slate leading-relaxed">Enter your company name, grab your dedicated subdomain, and you're instantly ready to go. No sales calls.</p>
                        </div>
                        <div>
                            <div class="w-16 h-16 bg-cloud rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-signal font-mono">2</div>
                            <h3 class="font-heading font-bold text-xl mb-3">Invite your agents</h3>
                            <p class="text-slate leading-relaxed">Add your support staff to your workspace. They'll get an invite and can start replying to customers immediately.</p>
                        </div>
                        <div>
                            <div class="w-16 h-16 bg-cloud rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-signal font-mono">3</div>
                            <h3 class="font-heading font-bold text-xl mb-3">Crush the queue</h3>
                            <p class="text-slate leading-relaxed">Watch tickets update live on your dashboard via WebSockets. See who's typing and resolve issues faster than ever.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Grid -->
            <section class="py-20 lg:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-4xl font-heading font-bold text-center mb-16">Everything you need. Nothing you don't.</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white p-8 rounded-2xl border border-line shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-signal/10 rounded-lg flex items-center justify-center text-signal mb-6">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h3 class="font-heading font-bold text-lg mb-2">Real-time WebSockets</h3>
                            <p class="text-slate">No more refreshing. New tickets and replies appear instantly across all your open tabs.</p>
                        </div>
                        <div class="bg-white p-8 rounded-2xl border border-line shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-signal/10 rounded-lg flex items-center justify-center text-signal mb-6">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h3 class="font-heading font-bold text-lg mb-2">Multi-tenant Isolation</h3>
                            <p class="text-slate">Your data is strictly partitioned. Secure custom subdomains (`yourcompany.pulsedesk.test`) for every account.</p>
                        </div>
                        <div class="bg-white p-8 rounded-2xl border border-line shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-signal/10 rounded-lg flex items-center justify-center text-signal mb-6">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <h3 class="font-heading font-bold text-lg mb-2">Integrated Knowledge Base</h3>
                            <p class="text-slate">Deflect tickets before they happen. Create help articles that customers can search instantly.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pricing -->
            <section class="bg-ink text-cloud py-20 lg:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-heading font-bold mb-4">Simple, transparent pricing</h2>
                        <p class="text-cloud/70 text-lg">No hidden fees. Upgrade or downgrade at any time.</p>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        @foreach($plans as $plan)
                            <div class="bg-cloud/5 border border-line/20 rounded-2xl p-8 flex flex-col relative {{ $plan->name === 'Starter' ? 'ring-2 ring-signal transform md:-translate-y-4' : '' }}">
                                @if($plan->name === 'Starter')
                                    <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-signal text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Most Popular</span>
                                @endif
                                <h3 class="text-2xl font-heading font-bold mb-2">{{ $plan->name }}</h3>
                                <div class="mb-6">
                                    <span class="text-4xl font-heading font-bold">${{ number_format($plan->price_cents / 100, 2) }}</span>
                                    <span class="text-cloud/50">/month</span>
                                </div>
                                <ul class="space-y-4 mb-8 flex-1">
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Up to <strong>{{ $plan->agent_limit }}</strong> Agents</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span><strong>{{ number_format($plan->ticket_limit_per_month) }}</strong> Tickets/mo</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Custom Knowledge Base</span>
                                    </li>
                                </ul>
                                <a href="{{ route('signup') }}" class="block text-center w-full py-3 rounded-lg font-bold transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-ink {{ $plan->name === 'Starter' ? 'bg-signal text-white hover:bg-cloud hover:text-ink focus:ring-signal' : 'bg-cloud/10 text-cloud hover:bg-cloud hover:text-ink focus:ring-cloud' }}">
                                    Get started
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-white border-t border-line py-12 text-center text-slate">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} PulseDesk. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
