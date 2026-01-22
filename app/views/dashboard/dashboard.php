<section>
    <main class="min-h-screen bg-slate-950 text-slate-200 p-4 md:p-8">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white">Tableau de Bord pour <?= $user['name'] ?></h1>
                    <p class="text-slate-400 mt-1">Ravi de vous revoir. Votre IA a mis à jour votre plan aujourd'hui.</p>
                </div>
                <div class="flex gap-3">
                    <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm border border-slate-700 transition-all">
                        Refaire le Questionnaire
                    </button>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg shadow-indigo-500/20">
                        Générer Nouveau Plan
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <section class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                            <h2 class="font-bold text-xl flex items-center gap-2">
                                <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                                Roadmap
                            </h2>
                            <span class="text-xs font-mono text-indigo-400 bg-indigo-500/10 px-2 py-1 rounded">V2.4 Dynamique</span>
                        </div>

                        <div class="p-6 space-y-4">

                        <?= $Roadmap['content'] ?>
                            
                        </div>
                    </section>

                    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
                            <h3 class="text-slate-400 text-sm font-medium mb-2">Progression du Plan</h3>
                            <div class="flex items-end gap-4">
                                <span class="text-4xl font-bold text-white"><?= $progress ?></span>
                                <div class="flex-1 h-2 bg-slate-800 rounded-full mb-2">
                                    <div class="h-full bg-indigo-500 rounded-full w-[<?= $progress ?>%] shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
                            <h3 class="text-slate-400 text-sm font-medium mb-2">Compétences Validées</h3>
                            <div class="flex items-center gap-3">
                                <span class="text-4xl font-bold text-white"><?= 'ch7al mn skill' ?></span>
                                <div class="flex flex-wrap gap-1">
                                    <? foreach($skills as $skill) : ?>
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"><?= $skill["name"] ?></span>
                                        <? endforeach ; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="space-y-6">

                    <section class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                        <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                            <i class="fas fa-bolt text-amber-400"></i>
                            Opportunités IA
                        </h2>
                        <div class="space-y-4">

                            <?php foreach ($opportunities as $opp) : ?>

                                <div class="p-3 bg-slate-800/30 rounded-lg border border-slate-700 hover:bg-slate-800 transition-all cursor-pointer group">
                                    <h4 class="text-sm font-bold text-white group-hover:text-indigo-400"><?= $opp["title"] ?></h4>
                                    <p class="text-xs text-slate-500 mt-1"><?= $opp["market_source"] ?></p>
                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-emerald-400 font-mono text-xs"><?= $opp['estimated_income'] ?></span>
                                        <span class="text-indigo-400 text-[10px] font-bold"></span>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </section>

                    <section class="bg-indigo-600/5 border border-indigo-500/20 rounded-2xl p-6">
                        <h2 class="font-bold text-lg mb-4 text-white">Ressources IA</h2>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-slate-300">
                                <span class="p-2 bg-indigo-500/20 rounded text-indigo-400 text-xs">PDF</span>
                                Guide des prompts 2024
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-300">
                                <span class="p-2 bg-indigo-500/20 rounded text-indigo-400 text-xs">VID</span>
                                Comment scaler avec l'IA
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </main>

</section>