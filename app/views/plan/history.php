<main class="bg-slate-950 min-h-screen py-12">
    <div class="container mx-auto px-6">
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    History Plan for <span class="text-indigo-400"><?= htmlspecialchars($user['name']) ?></span>
                </h1>
                <p class="text-slate-400 mt-2">Review your past AI-generated strategies and progress.</p>
            </div>
            <div class="text-slate-500 text-sm font-medium bg-slate-900/50 px-4 py-2 rounded-lg border border-slate-800">
                Total Plans: <?= count($plans) ?>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">
            <?php foreach($plans as $plan) : ?>
                <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 shadow-xl">
                    <div class="p-6 md:p-8">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                            <div class="flex items-center text-slate-400 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?= date('M d, Y', strtotime($plan['created_at'])) ?>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Completion</span>
                                <div class="bg-slate-800 rounded-full h-2.5 w-32 overflow-hidden">
                                    <div class="bg-indigo-500 h-full rounded-full" style="width: <?= $plan['completion_percentage'] ?>%"></div>
                                </div>
                                <span class="text-indigo-400 font-bold text-sm"><?= $plan['completion_percentage'] ?>%</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2">
                                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-3">Plan Details</h3>
                                <div class="text-slate-200 leading-relaxed prose prose-invert max-w-none">
                                    <?= nl2br(htmlspecialchars($plan['content'])) ?>
                                </div>
                            </div>

                            <div class="bg-indigo-500/5 border border-indigo-500/10 rounded-xl p-5">
                                <div class="flex items-center mb-3">
                                    <svg class="w-5 h-5 text-indigo-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.536 14.95a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM15.657 15.657l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 01-1.414 1.414z" />
                                    </svg>
                                    <span class="text-indigo-300 font-semibold text-sm">AI Insights</span>
                                </div>
                                <p class="text-slate-400 text-sm italic italic leading-snug">
                                    "<?= htmlspecialchars($plan['ai_notes']) ?>"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ; ?>
        </div>
    </div>
</main>
