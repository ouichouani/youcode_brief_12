
<div
    class="min-h-screen bg-slate-950 py-12 px-4 sm:px-6 lg:px-8 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-indigo-900/20 via-slate-950 to-slate-950">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-4">
                Personnalisez Votre <span class="text-indigo-500">Parcours</span>
            </h1>
            <p class="text-slate-400 text-lg">
                Répondez à quelques questions pour que notre IA puisse générer votre roadmap personnalisée.
            </p>
        </div>

        <form action="/questionnaire" method="POST" class="space-y-8">
            <?php if (empty($questions)): ?>
                <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-2xl p-8 text-center">
                    <p class="text-slate-400 italic">Chargement des questions...</p>
                    <!-- Fallback if database is empty -->
                    <div class="mt-6 space-y-6 text-left">
                        <div class="p-6 bg-slate-800/30 rounded-xl border border-slate-700/50">
                            <label class="block text-sm font-medium text-indigo-400 mb-2">Quel est votre objectif principal
                                ?</label>
                            <input type="text" name="responses[1]" placeholder="Ex: Devenir développeur Fullstack"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>
                        <div class="p-6 bg-slate-800/30 rounded-xl border border-slate-700/50">
                            <label class="block text-sm font-medium text-indigo-400 mb-2">Quel est votre niveau actuel
                                ?</label>
                            <select name="responses[2]"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                <option value="débutant">Débutant</option>
                                <option value="intermédiaire">Intermédiaire</option>
                                <option value="avancé">Avancé</option>
                            </select>
                        </div>
                        <div class="p-6 bg-slate-800/30 rounded-xl border border-slate-700/50">
                            <label class="block text-sm font-medium text-indigo-400 mb-2">Combien d'heures par semaine
                                pouvez-vous consacrer ?</label>
                            <input type="number" name="responses[3]" placeholder="Ex: 10"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($questions as $q): ?>
                        <div
                            class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 transition-all hover:border-indigo-500/50 group">
                            <label
                                class="block text-lg font-medium text-white mb-3 group-hover:text-indigo-400 transition-colors">
                                <?= htmlspecialchars($q['content']) ?>
                            </label>
                            <input type="text" name="responses[<?= $q['id'] ?>]" required
                                class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                                placeholder="Votre réponse ici...">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-center pt-8">
                <button type="submit"
                    class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/20">
                    Générer ma Roadmap
                    <svg class="w-5 h-5 ml-2 -mr-1 transition-all group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>