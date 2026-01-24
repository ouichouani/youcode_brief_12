
<?php
$opportunities = $opportunities ?? [];

?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($opportunities as $op): ?>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-bold mb-2"><?= $op['title'] ?></h3>
            <p class="text-gray-700 mb-2"><?= $op['description'] ?></p>
            <p class="text-sm text-gray-500">Skills: <?= $op['skills'] ?? 'N/A' ?></p>
            <p class="text-sm text-green-600">Estimated income: $<?= $op['estimated_income'] ?></p>
            <a href="/opportunity?id=<?= $op['id'] ?>" class="text-blue-500 mt-2 inline-block">Voir plan détaillé</a>
        </div>
    <?php endforeach; ?>
</div>