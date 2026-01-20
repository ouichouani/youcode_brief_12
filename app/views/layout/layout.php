<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>

    <header class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-white tracking-tight">AI<span class="text-indigo-400">Revenue</span></span>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-300">
                <a href="/dashboard" class="hover:text-white transition-colors">Tableau de bord</a>
                <a href="/opportunities" class="hover:text-white transition-colors">Opportunités</a>
                <a href="/community" class="hover:text-white transition-colors">Communauté</a>
                <a href="/skills" class="hover:text-white transition-colors">Mes Compétences</a>
            </div>

            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="flex items-center space-x-3">
                        <span class="text-slate-400 text-sm hidden lg:inline">Prêt pour votre plan, Alex ?</span>
                        <a href="/profile" class="w-8 h-8 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-xs text-white">JD</a>
                        <a href="/logout" class="text-slate-400 hover:text-red-400 p-2"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-slate-300 hover:text-white text-sm font-medium">Connexion</a>
                    <a href="/signup" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all transform hover:scale-105">
                        Essayer l'IA
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>

        {{content}}

    </main>

<footer class="bg-slate-900 border-t border-slate-800 pt-16 pb-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-white uppercase tracking-wider">AI Revenue</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Libérez votre potentiel financier avec des plans d'action quotidiens générés par l'IA et des opportunités de revenus sur mesure.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6">Plateforme</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Plans Quotidiens</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Marché d'Opportunités</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Ressources IA</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Classement Skills</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6">Communauté</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Forum d'entraide</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Succès Story</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Support Technique</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6">Newsletter IA</h4>
                <p class="text-slate-400 text-xs mb-4">Recevez une nouvelle opportunité de revenus chaque semaine.</p>
                <form class="flex">
                    <input type="email" placeholder="Votre email" class="bg-slate-800 border-none rounded-l-lg px-4 py-2 text-sm text-white focus:ring-1 focus:ring-indigo-500 w-full">
                    <button class="bg-indigo-600 px-4 py-2 rounded-r-lg text-white hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col md:row justify-between items-center text-slate-500 text-xs">
            <p>&copy; 2024 AI Revenue Application. Tous droits réservés.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-slate-300">Confidentialité</a>
                <a href="#" class="hover:text-slate-300">Conditions d'utilisation</a>
            </div>
        </div>
    </div>
</footer>
</body>

</html>