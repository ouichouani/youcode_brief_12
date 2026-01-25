<section class="bg-slate-50 min-h-screen py-10">
    <div class="container mx-auto px-6">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Opportunités de Revenus</h1>
            <p class="text-slate-500 mt-1">L'IA identifie les meilleures opportunités basées sur vos compétences
                actuelles.</p>
        </div>

        <?php if (empty($opportunities)): ?>
            <div class="bg-white rounded-3xl p-20 text-center border border-slate-100 shadow-sm">
                <div
                    class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Aucune opportunité pour le moment</h3>
                <p class="text-slate-500 mt-2 max-w-sm mx-auto">Générez ou régénérez votre plan pour permettre à l'IA
                    d'analyser le marché pour vous.</p>
                <a href="/plan"
                    class="mt-8 inline-flex bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all">Analyser
                    le marché</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($opportunities as $op): ?>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-6">
                                <span
                                    class="bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                                    + $<?= number_format($op['estimated_income'] ?? 0) ?> / mois
                                </span>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase"><?= htmlspecialchars($op['difficulty'] ?? 'Intermédiaire') ?></span>
                            </div>

                            <h3 class="text-xl font-black text-slate-800 mb-3 group-hover:text-indigo-600 transition-colors">
                                <?= htmlspecialchars($op['title']) ?></h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">
                                <?= htmlspecialchars($op['description']) ?>
                            </p>

                            <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Freelance /
                                        Remote</span>
                                </div>
                                <a href="<?= APP_ROOT ?>/opportinity?id=<?= $op['id'] ?>"
                                    class="text-indigo-600 font-bold text-sm hover:translate-x-1 transition-transform">
                                    Détails & Action →
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>