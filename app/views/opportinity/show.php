<div class="bg-white shadow-md rounded-lg p-4 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4"><?= $opportunity['title'] ?></h2>
    <p class="mb-2"><?= $opportunity['description'] ?></p>
    <p class="text-sm text-gray-500">Skills: <?= $opportunity['skills'] ?? 'N/A' ?></p>
    <p class="text-sm text-green-600">Estimated income: $<?= $opportunity['estimated_income'] ?></p>
    <a href="/dashboard" class="text-blue-500 mt-4 inline-block">Retour au dashboard</a>
</div>
