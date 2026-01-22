<div class="relative bg-slate-900 overflow-hidden">
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover opacity-30"
            src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=2850&q=80"
            alt="Background">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-slate-900/50"></div>
    </div>

    <div class="relative container mx-auto px-6 py-32 md:py-48 flex flex-col items-center text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
            Transform Your Potential into <br>
            <span class="text-indigo-400">Recurring Revenue</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-300 mb-10 max-w-2xl">
            AI-driven roadmaps to help you build skills, find opportunities, and generate income. Start your journey
            today.
        </p>

        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
            <a href="<?= APP_ROOT ?>/login"
                class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-lg transition-all border border-slate-700 shadow-lg hover:shadow-xl w-full md:w-auto text-center">
                Login
            </a>
            <a href="<?= APP_ROOT ?>/signup"
                class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-all shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-105 w-full md:w-auto text-center">
                Start Now - It's Free
            </a>
        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-left max-w-4xl w-full">
            <div class="bg-slate-800/50 backdrop-blur-sm p-6 rounded-xl border border-slate-700/50">
                <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-white font-semibold mb-2">Personalized Roadmap</h3>
                <p class="text-slate-400 text-sm">Get a step-by-step plan tailored to your skills and goals.</p>
            </div>
            <div class="bg-slate-800/50 backdrop-blur-sm p-6 rounded-xl border border-slate-700/50">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="text-white font-semibold mb-2">Growth Tracking</h3>
                <p class="text-slate-400 text-sm">Monitor your progress and unlock new levels as you advance.</p>
            </div>
            <div class="bg-slate-800/50 backdrop-blur-sm p-6 rounded-xl border border-slate-700/50">
                <div class="w-12 h-12 bg-pink-500/20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-white font-semibold mb-2">Real Opportunities</h3>
                <p class="text-slate-400 text-sm">Access curated income opportunities matched to your profile.</p>
            </div>
        </div>
    </div>
</div>