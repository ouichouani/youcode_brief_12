<?php
$userName = $_SESSION['user']['name'] ?? 'Utilisateur';
$userEmail = $_SESSION['user']['email'] ?? 'email@example.com';
?>
<section class="bg-slate-50 min-h-screen py-10">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mon Profil</h1>
            <p class="text-slate-500 mt-1">Gérez vos informations personnelles et vos préférences d'IA.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 text-center">
                    <div
                        class="w-24 h-24 bg-indigo-100 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl text-indigo-600 font-black">
                        <?= strtoupper(substr($userName, 0, 2)) ?>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">
                        <?= htmlspecialchars($userName) ?>
                    </h2>
                    <p class="text-sm text-slate-500 mb-6">
                        <?= htmlspecialchars($userEmail) ?>
                    </p>
                    <button
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-xl text-sm font-bold transition-all">Changer
                        l'avatar</button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">Informations du compte</h3>
                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nom Complet</label>
                                <input type="text" value="<?= htmlspecialchars($userName) ?>"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email</label>
                                <input type="email" value="<?= htmlspecialchars($userEmail) ?>"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit"
                                class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded-xl text-sm font-bold transition-all">Enregistrer
                                les modifications</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">Sécurité</h3>
                    <button
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2 rounded-xl text-sm font-bold transition-all border border-slate-200">Réinitialiser
                        le mot de passe</button>
                </div>
            </div>
        </div>
    </div>
</section>