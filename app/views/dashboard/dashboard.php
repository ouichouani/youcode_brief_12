<main class="bg-slate-950 min-h-screen py-12">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight">
                    Bonjour, <span class="text-indigo-400"><?= htmlspecialchars($user['name']); ?></span> 👋
                </h1>
                <p class="text-slate-400 mt-2 text-lg">Voici l'analyse de votre progression et de vos revenus.</p>
            </div>
            <a href="/plan/generate"
                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 hover:scale-105 active:scale-95 group">
                <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                </svg>
                Régénérer le plan
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Compétences Clés</h3>
                    <span class="bg-indigo-500/10 text-indigo-400 text-xs font-bold px-2 py-1 rounded-md border border-indigo-500/20">Top 3</span>
                </div>
                <div class="space-y-2">
                    <?php foreach (array_slice($skills, 0, 3) as $skill): ?>
                        <div class="flex items-center p-2.5 bg-slate-800/50 rounded-xl border border-slate-700/50 group hover:border-indigo-500/50 transition-colors">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 mr-3"></div>
                            <span class="text-sm font-medium text-slate-200"><?= htmlspecialchars($skill['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-indigo-600/10 rounded-2xl flex items-center justify-center text-indigo-400 border border-indigo-600/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="text-right">
                        <span class="block text-3xl font-black text-white"><?= $progress ?></span>
                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-tighter">Score IA Global</span>
                    </div>
                </div>
                <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-full rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)] transition-all duration-1000" style="width: <?= $progress ?>%"></div>
                </div>
                <p class="text-slate-500 text-xs mt-4 font-medium flex justify-between">
                    <span>Performance actuelle</span>
                    <span class="text-indigo-400"><?= $progress ?>%</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-white uppercase tracking-tight">Mon Plan d'Action</h3>
                            <p class="text-slate-500 text-sm mt-1">Stratégie générée par l'IA pour aujourd'hui</p>
                        </div>
                        <div class="flex items-center px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse mr-2"></span>
                            <span class="text-emerald-500 text-[10px] font-bold uppercase">En cours</span>
                        </div>
                    </div>
                    <div class="bg-slate-950/50 rounded-2xl p-6 border border-slate-800 min-h-[400px]">
                        <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed">
                            <?= !empty($plan['content']) ? nl2br(htmlspecialchars($plan['content'])) : '<div class="flex flex-col items-center justify-center py-20 text-slate-600"><svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>Générez votre plan pour voir la roadmap détaillée...</div>'; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl flex flex-col">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white uppercase tracking-tight">Opportunités</h3>
                    <p class="text-slate-500 text-sm mt-1">Revenus potentiels détectés</p>
                </div>

                <div class="space-y-4 flex-grow">
                    <?php if (empty($opportunities)) : ?>
                        <div class="text-center py-10 bg-slate-950/30 rounded-2xl border border-dashed border-slate-800">
                            <p class="text-slate-600 italic text-sm">Pas d'opportunités pour le moment.</p>
                        </div>
                    <?php else : ?>
                        <?php foreach (array_slice($opportunities, 0, 3) as $op): ?>
                            <div class="group p-5 bg-slate-800/30 border border-slate-800 rounded-2xl hover:border-indigo-500/50 hover:bg-slate-800/60 transition-all duration-300">
                                <h4 class="font-bold text-slate-100 group-hover:text-indigo-400 transition-colors"><?= htmlspecialchars($op['title']) ?></h4>
                                <p class="text-sm text-slate-400 line-clamp-2 mt-2 mb-4 font-medium leading-relaxed"><?= htmlspecialchars($op['description']) ?></p>
                                
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-700/50">
                                    <span class="text-xs font-bold text-emerald-400 bg-emerald-400/10 px-3 py-1 rounded-lg">
                                        + $<?= number_format($op['estimated_income']) ?>
                                    </span>
                                    <a href="/opportunity/show?id=<?= $op['id'] ?>" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition-colors flex items-center">
                                        Détails
                                        <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <button class="w-full mt-6 py-4 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-2xl text-sm font-bold text-slate-300 hover:text-white transition-all">
                            Voir toutes les opportunités
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>