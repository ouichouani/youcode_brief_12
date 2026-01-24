<section class="bg-slate-50 min-h-screen py-10 font-sans">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Bonjour, <?= htmlspecialchars($user['name']); ?> 👋
                </h1>
                <p class="text-slate-500 mt-1">Voici l'analyse de votre progression et de vos revenus.</p>
            </div>
            <a href="/plan/generate"
                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                </svg>
                Régénérer le plan
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Compétences Clés</h3>
                    <span class="bg-indigo-50 text-indigo-600 text-xs font-bold px-2 py-1 rounded-md">Top 3</span>
                </div>
                <div class="space-y-3">
                    <?php foreach (array_slice($skills, 0, 3) as $skill): ?>
                        <div class="flex items-center p-2 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="text-sm font-semibold text-slate-700"><?= htmlspecialchars($skill['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="text-right">
                        <span class="block text-2xl font-black text-slate-800"><?= $progress ?></span>
                        <span class="text-slate-400 text-xs font-medium uppercase">Score IA</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-amber-400 h-full rounded-full" style="width: <?= $progress ?>%"></div>
                </div>
                <p class="text-slate-500 text-xs mt-3 font-medium">Performance actuelle</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Ma plan</h3>
                    <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                </div>
                <div class="min-h-[300px] bg-slate-50 rounded-2xl p-6 border border-dashed border-slate-200">
                    <div class="prose prose-slate max-w-none text-slate-600">
                        <?= !empty($plan['content']) ? nl2br(htmlspecialchars($plan['content'])) : 'Générez votre plan pour voir la roadmap détaillée...'; ?>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
                <h3 class="text-xl font-bold text-slate-800 mb-6 uppercase tracking-tight">Opportunités</h3>

                <div class="space-y-4 flex-grow">
                    <?php if (empty($opportunities)) : ?>
                        <div class="text-center py-10">
                            <p class="text-slate-400 italic">Pas d'opportunités pour le moment.</p>
                        </div>
                    <?php else : ?>
                        <?php foreach (array_slice($opportunities, 0, 3) as $op): ?>
                            <div class="group p-4 bg-white border border-slate-100 rounded-xl hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-200">
                                <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors"><?= htmlspecialchars($op['title']) ?></h4>
                                <p class="text-sm text-slate-500 line-clamp-2 mt-1 mb-3 font-medium"><?= htmlspecialchars($op['description']) ?></p>
                                
                                <div class="flex items-center justify-between mt-auto">
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">
                                        + $<?= number_format($op['estimated_income']) ?>
                                    </span>
                                    <a href="/opportunity/show?id=<?= $op['id'] ?>" class="text-xs font-bold text-indigo-600 hover:underline">
                                        Détails →
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <button class="w-full mt-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                            Voir toutes les opportunités
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>