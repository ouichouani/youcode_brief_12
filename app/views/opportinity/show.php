<section class="bg-slate-50 min-h-screen py-10">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="mb-8">
            <a href="<?= APP_ROOT ?>/opportunities"
                class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">←
                Retour au marché</a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="bg-slate-900 p-12 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-indigo-600 opacity-10 blur-3xl rounded-full -top-20 -left-20"></div>
                <div class="relative z-10">
                    <span
                        class="inline-block bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full border border-emerald-500/20 mb-6">
                        Revenu Estimé: $<?= number_format($opportunity['estimated_income'] ?? 0) ?> / mois
                    </span>
                    <h1 class="text-4xl font-black text-white mb-4 tracking-tight">
                        <?= htmlspecialchars($opportunity['title']) ?></h1>
                    <div class="flex justify-center items-center space-x-6 text-slate-400 text-sm font-medium">
                        <span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg><?= htmlspecialchars($opportunity['difficulty'] ?? 'Intermédiaire') ?></span>
                        <span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>Flexible</span>
                    </div>
                </div>
            </div>

            <div class="p-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="md:col-span-2 space-y-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-800 mb-4 uppercase tracking-tighter">Description de
                                l'opportunité</h3>
                            <p class="text-slate-600 leading-relaxed">
                                <?= nl2br(htmlspecialchars($opportunity['description'])) ?>
                            </p>
                        </div>

                        <div class="p-8 bg-indigo-50 rounded-2xl border border-indigo-100">
                            <h4 class="text-indigo-900 font-bold mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Pourquoi cette opportunité ?
                            </h4>
                            <p class="text-indigo-800/80 text-sm leading-relaxed">
                                L'intelligence artificielle a détecté que votre profil correspond à 85% à cette offre.
                                En suivant votre roadmap actuelle, vous serez prêt à postuler ou lancer ce service dans
                                environ 2 semaines.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Compétences
                                Clés</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php
                                $skills = explode(',', $opportunity['skills'] ?? 'Analyse,IA,Business');
                                foreach ($skills as $s):
                                    ?>
                                    <span
                                        class="px-3 py-1 bg-white rounded-lg border border-slate-200 text-[10px] font-bold text-slate-600"><?= htmlspecialchars(trim($s)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <a href="<?= $opportunity['external_link'] ?>"
                            class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all uppercase tracking-widest text-xs">
                            Postuler maintenant
                        </a>
                        <p class="text-center text-[10px] text-slate-400 font-medium">Lien externe vers la plateforme
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>