<section class="bg-slate-50 min-h-screen py-10">
    <div class="container mx-auto px-6">
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mes Compétences</h1>
                <p class="text-slate-500 mt-1">L'IA analyse votre progression réelle basée sur les tâches accomplies.
                </p>
            </div>
            <?php
            $totalCompleted = 0;
            $totalTasks = 0;
            foreach ($skills as $s) {
                $totalCompleted += $s['completed_tasks'];
                $totalTasks += $s['total_tasks'];
            }
            $globalProgress = $totalTasks > 0 ? round(($totalCompleted / $totalTasks) * 100) : 0;
            ?>
            <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Progression Globale
                        </p>
                        <p class="text-2xl font-black text-indigo-600">
                            <?= $globalProgress ?>%
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full border-4 border-indigo-50 flex items-center justify-center relative">
                        <svg class="w-12 h-12 transform -rotate-90">
                            <circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="4" fill="transparent"
                                class="text-slate-200" />
                            <circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="4" fill="transparent"
                                stroke-dasharray="113" stroke-dashoffset="<?= 113 - ($globalProgress / 100 * 113) ?>"
                                class="text-indigo-500" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($skills)): ?>
            <div class="bg-white rounded-3xl p-20 text-center border border-slate-100 shadow-sm">
                <div
                    class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Aucune compétence détectée</h3>
                <p class="text-slate-500 mt-2 max-w-sm mx-auto">Commencez par générer une roadmap pour identifier les
                    compétences clés à développer.</p>
                <a href="<?= APP_ROOT ?>/questionnaire"
                    class="mt-8 inline-flex bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all">Lancer
                    l'analyse AI</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($skills as $skill): ?>
                    <?php
                    $percent = round(($skill['completed_tasks'] / $skill['total_tasks']) * 100);
                    $colorClass = $percent > 70 ? 'indigo' : ($percent > 30 ? 'amber' : 'slate');
                    ?>
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-<?= $colorClass ?>-200 transition-all group">
                        <div class="flex justify-between items-start mb-6">
                            <div
                                class="w-12 h-12 bg-<?= $colorClass ?>-50 rounded-xl flex items-center justify-center text-<?= $colorClass ?>-600 group-hover:bg-<?= $colorClass ?>-600 group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span
                                class="text-[10px] font-black uppercase tracking-tighter text-slate-400 bg-slate-50 px-2 py-1 rounded">
                                <?= $skill['completed_tasks'] ?> /
                                <?= $skill['total_tasks'] ?> Tâches
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">
                            <?= htmlspecialchars($skill['skill_name']) ?>
                        </h3>

                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-<?= $colorClass ?>-600">
                                <?= $percent ?>% Maitrisé
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden mb-4">
                            <div class="bg-<?= $colorClass ?>-500 h-full rounded-full transition-all duration-1000"
                                style="width: <?= $percent ?>%"></div>
                        </div>
                        <p class="text-slate-400 text-xs leading-relaxed italic">
                            Basé sur l'accomplissement de votre plan d'action personnalisé.
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>