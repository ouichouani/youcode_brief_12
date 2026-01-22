   <!-- Posts List -->
        <div class="space-y-6">
            <?php foreach ($posts as $post): ?>
            <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
                <div class="flex items-center mb-3">
                    
                    <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold">  </div>
                    <div class="ml-3">
                        <p class="font-semibold text-blue-900"><?= htmlspecialchars($post['username']) ?></p>
                        <p class="text-xs text-gray-500"><?= date('d M Y H:i', strtotime($post['created_at'])) ?></p>
                    </div>
                </div>
                <p class="text-gray-700"><?= htmlspecialchars($post['content']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>