<div
    class="min-h-screen bg-slate-950 py-12 px-4 sm:px-6 lg:px-8 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-indigo-900/20 via-slate-950 to-slate-950">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">
                    Votre <span class="text-indigo-500">Roadmap</span> IA
                </h1>
                <p class="text-slate-400 mt-2">Générée sur mesure selon vos objectifs et compétences.</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.print()"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg border border-slate-700 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Imprimer
                </button>
                <a href="/questionnaire"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all flex items-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refaire
                </a>
                <a href="/dashboard"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all flex items-center shadow-lg shadow-green-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Tableau de bord
                </a>
            </div>
        </div>

        <?php if (empty($roadmap)): ?>
            <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-3xl p-12 text-center">
                <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Aucune roadmap trouvée</h3>
                <p class="text-slate-400 mb-8">Vous n'avez pas encore généré de roadmap personnalisée.</p>
                <a href="/questionnaire"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-all inline-block">
                    Commencer le questionnaire
                </a>
            </div>
        <?php else: ?>
            <div
                class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-32 h-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>

                <div id="roadmap-content"
                    class="prose prose-invert max-w-none prose-headings:text-indigo-400 prose-strong:text-white prose-li:text-slate-300">
                    <!-- Markdown content will be rendered here -->
                    <div class="flex justify-center py-20">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
                    </div>
                </div>
            </div>

            <!-- Markdown Renderer -->
            <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const rawContent = <?= json_encode($roadmap['content']) ?>;
                    const contentDiv = document.getElementById('roadmap-content');

                    if (rawContent) {
                        contentDiv.innerHTML = marked.parse(rawContent);
                    } else {
                        contentDiv.innerHTML = '<p class="text-slate-500 italic">Contenu de la roadmap indisponible.</p>';
                    }
                });
            </script>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Custom styles for markdown content to match the theme */
    .prose h1,
    .prose h2,
    .prose h3 {
        margin-top: 2em;
        margin-bottom: 1em;
        font-weight: 800;
        letter-spacing: -0.025em;
    }

    .prose h1 {
        border-bottom: 1px solid #1e293b;
        padding-bottom: 0.5em;
    }

    .prose ul {
        list-style-type: none;
        padding-left: 0;
    }

    .prose li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .prose li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0.6em;
        width: 0.5rem;
        height: 0.5rem;
        background-color: #6366f1;
        border-radius: 9999px;
    }

    .prose p {
        color: #94a3b8;
        line-height: 1.8;
    }

    .prose strong {
        color: #f8fafc;
    }

    .prose blockquote {
        border-left: 4px solid #6366f1;
        padding-left: 1rem;
        font-style: italic;
        background: rgba(99, 102, 241, 0.05);
        padding: 1rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }
</style>