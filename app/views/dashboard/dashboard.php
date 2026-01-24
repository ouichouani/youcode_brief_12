<section class="bg-slate-50 min-h-screen py-10 font-sans">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Bonjour, <?= htmlspecialchars($user['name']); ?> 👋
                </h1>
                <p class="text-slate-500 mt-1">Voici l'analyse de votre progression et de vos revenus.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?= APP_ROOT ?>/questionnaire"
                    class="inline-flex items-center bg-white hover:bg-slate-50 text-slate-600 px-6 py-3 rounded-xl font-bold transition-all border border-slate-200 active:scale-95 text-xs">
                    Modifier mes réponses
                </a>
                <a href="<?= APP_ROOT ?>/plan"
                    class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 active:scale-95 text-xs">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                    </svg>
                    Régénérer le plan
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Global Progress Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="text-right">
                        <span class="block text-2xl font-black text-slate-800"><?= $progress ?>%</span>
                        <span class="text-slate-400 text-[10px] font-bold uppercase">Succès Total</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000"
                        style="width: <?= $progress ?>%"></div>
                </div>
            </div>

            <!-- Skills Summary Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 col-span-1 md:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Compétences en
                        développement</h3>
                    <a href="<?= APP_ROOT ?>/skills" class="text-indigo-600 text-[10px] font-bold hover:underline">Voir
                        détails →</a>
                </div>
                <div class="flex flex-wrap gap-2">
                    <?php if (empty($skills)): ?>
                        <p class="text-slate-400 text-xs italic">Aucune compétence active.</p>
                    <?php else: ?>
                        <?php foreach (array_slice($skills, 0, 5) as $skill): ?>
                            <div class="flex items-center px-3 py-1.5 bg-slate-50 rounded-lg border border-slate-100">
                                <span
                                    class="text-[10px] font-bold text-slate-600"><?= htmlspecialchars($skill['name'] ?? $skill['skill_name']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detailed Roadmap & Tasks -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Roadmap Phases Info -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Vision Stratégique</h3>
                            <p class="text-slate-400 text-xs mt-1">Votre parcours balisé vers l'indépendance financière.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <?php if (!empty($roadmap['structured_content']['phases'])): ?>
                            <?php foreach ($roadmap['structured_content']['phases'] as $idx => $phase): ?>
                                <div
                                    class="p-6 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-xs font-black text-indigo-600">
                                            <?= $idx + 1 ?>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800">
                                                <?= htmlspecialchars($phase['phase_title']) ?></h4>
                                            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">
                                                <?= htmlspecialchars($phase['objective']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-slate-400 text-sm italic">Générez une roadmap structurée pour voir les phases.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actionable Daily Tasks -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 shadow-indigo-50/50">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Plan d'Action Direct</h3>
                            <p class="text-slate-400 text-xs mt-1">Les étapes concrètes à accomplir dès maintenant.</p>
                        </div>
                        <span
                            class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1 rounded-full uppercase"><?= count(array_filter($dbTasks, fn($t) => !$t['is_completed'])) ?>
                            tâches restantes</span>
                    </div>

                    <div class="space-y-4">
                        <?php if (empty($dbTasks)): ?>
                            <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Prêt à démarrer ?</p>
                                <a href="<?= APP_ROOT ?>/plan"
                                    class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Calculer mon plan
                                    d'action</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($dbTasks as $task): ?>
                                <div
                                    class="flex items-center justify-between p-5 rounded-2xl transition-all border <?= $task['is_completed'] ? 'bg-slate-50 border-transparent opacity-60' : 'bg-white border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:-translate-y-1' ?>">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <?php if ($task['is_completed']): ?>
                                                <div
                                                    class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            <?php else: ?>
                                                <form action="<?= APP_ROOT ?>/markAsDone" method="POST" class="m-0">
                                                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                                    <button type="submit"
                                                        class="w-8 h-8 rounded-xl border-2 border-slate-100 bg-slate-50 hover:bg-white hover:border-indigo-500 transition-all flex items-center justify-center group/btn">
                                                        <div
                                                            class="w-2 h-2 rounded-full bg-slate-300 group-hover/btn:bg-indigo-500 transition-colors">
                                                        </div>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold <?= $task['is_completed'] ? 'text-slate-400 line-through' : 'text-slate-800' ?>">
                                                <?= htmlspecialchars($task['description']) ?>
                                            </p>
                                            <?php if (!empty($task['skill_name'])): ?>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span
                                                        class="text-[9px] font-black text-indigo-400 bg-indigo-50 px-2 py-0.5 rounded uppercase tracking-tighter"><?= htmlspecialchars($task['skill_name']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (!$task['is_completed']): ?>
                                        <div class="hidden md:block">
                                            <span class="text-[9px] font-bold text-slate-300 italic">Action Prioritaire</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Opportunities Sidebar -->
            <div class="space-y-8">
                <div class="bg-slate-900 p-8 rounded-3xl shadow-2xl overflow-hidden relative group">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-600 rounded-full blur-[80px] opacity-20 group-hover:opacity-40 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white mb-2 tracking-tight">Opportunités IA</h3>
                        <p class="text-slate-400 text-xs mb-8">Basées sur votre profil actuel.</p>

                        <div class="space-y-4">
                            <?php if (empty($opportunities)): ?>
                                <p class="text-slate-500 text-xs italic py-10 text-center">Aucune opportunité détectée...
                                </p>
                            <?php else: ?>
                                <?php foreach (array_slice($opportunities, 0, 3) as $op): ?>
                                    <a href="<?= APP_ROOT ?>/opportunity/<?= $op['id'] ?>"
                                        class="block p-5 bg-slate-800/50 rounded-2xl border border-slate-700 hover:border-indigo-500 transition-all group/card">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4
                                                class="text-xs font-bold text-white group-hover/card:text-indigo-400 transition-colors">
                                                <?= htmlspecialchars($op['title']) ?></h4>
                                            <span
                                                class="text-[9px] font-black text-emerald-400">$<?= number_format($op['estimated_income'] ?? 0) ?></span>
                                        </div>
                                        <p class="text-slate-400 text-[10px] line-clamp-2 leading-relaxed">
                                            <?= htmlspecialchars($op['description']) ?></p>
                                    </a>
                                <?php endforeach; ?>
                                <a href="<?= APP_ROOT ?>/opportunities"
                                    class="block text-center pt-4 text-[10px] font-black text-indigo-400 uppercase tracking-widest hover:text-white transition-colors">Voir
                                    tout le marché →</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Community Tip -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Astuce Communauté</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Partagez vos réussites sur le forum pour débloquer des badges exclusifs et attirer de nouveaux
                        clients.
                    </p>
                    <a href="<?= APP_ROOT ?>/community"
                        class="text-[10px] font-bold text-indigo-600 hover:underline">Accéder au forum →</a>
                </div>
            </div>
        </div>
    </div>
</section>