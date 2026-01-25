<section class="bg-slate-50 min-h-screen py-10">
    <div class="container mx-auto px-6">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Communauté AI Revenue</h1>
            <p class="text-slate-500 mt-1">Échangez avec d'autres entrepreneurs et partagez vos succès.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar / Trending -->
            <div class="space-y-6 order-2 lg:order-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-slate-800 font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Membres à suivre
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                    AS</div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Amine S.</p>
                                    <p class="text-xs text-slate-500">Expert SaaS</p>
                                </div>
                            </div>
                            <button class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Suivre</button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                                    ML</div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Marie L.</p>
                                    <p class="text-xs text-slate-500">Freelance UX</p>
                                </div>
                            </div>
                            <button class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Suivre</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6 order-1 lg:order-2">
                <!-- Create Post -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <div class="flex space-x-4">
                        <div class="w-12 h-12 rounded-full bg-slate-200 flex-shrink-0 flex items-center justify-center font-bold text-slate-500">
                            <?= strtoupper(substr($_SESSION['user']['name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="flex-grow">
                            <form action="<?= APP_ROOT ?>/community/post" method="POST">
                                <textarea name="content" placeholder="Quoi de neuf dans votre aventure ?"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                                    rows="3" required></textarea>
                                <div class="flex justify-end mt-4">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-bold transition-all shadow-lg shadow-indigo-100">Publier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Feed Posts -->
                <?php if (empty($posts)): ?>
                    <div class="bg-white p-12 rounded-2xl shadow-sm border border-slate-100 text-center">
                        <p class="text-slate-400">Aucun message pour le moment. Soyez le premier à partager !</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                            <?= strtoupper(substr($post['author'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($post['author']) ?></p>
                                            <p class="text-xs text-slate-500"><?= date('d M Y, H:i', strtotime($post['created_at'])) ?></p>
                                        </div>
                                    </div>
                                    <?php if ($post['is_high_value']): ?>
                                        <span class="bg-amber-100 text-amber-600 text-[10px] font-black px-2 py-1 rounded uppercase">High Value</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                                </p>
                                <div class="flex items-center space-x-6 pt-4 border-t border-slate-50">
                                    <form action="<?= APP_ROOT ?>/community/like" method="POST" class="inline">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <button type="submit" class="flex items-center space-x-2 <?= $post['is_liked'] ? 'text-rose-500' : 'text-slate-400' ?> hover:text-rose-500 transition-colors">
                                            <svg class="w-5 h-5" fill="<?= $post['is_liked'] ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium"><?= $post['likes_count'] ?></span>
                                        </button>
                                    </form>
                                    <div class="flex items-center space-x-2 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium"><?= count($post['comments']) ?></span>
                                    </div>
                                </div>
                                
                                <!-- Comments Section -->
                                <div class="mt-4 space-y-3">
                                    <?php foreach ($post['comments'] as $comment): ?>
                                        <div class="bg-slate-50 p-3 rounded-xl">
                                            <p class="text-xs font-bold text-slate-800"><?= htmlspecialchars($comment['author']) ?></p>
                                            <p class="text-xs text-slate-600"><?= htmlspecialchars($comment['content']) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <form action="<?= APP_ROOT ?>/community/comment" method="POST" class="mt-3">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <div class="flex space-x-2">
                                            <input type="text" name="content" placeholder="Ajouter un commentaire..." required
                                                class="flex-grow bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold font-bold">Envoyer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>