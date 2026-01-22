<div style="max-width:600px; margin:auto;">

<?php foreach ($tasks as $task): ?>

    <div style="background:white;border:1px solid #e5e7eb;padding:16px;margin-bottom:12px;border-radius:8px;">

        <h3 style="margin:0; color:#1f2937;">
            <?= $task['title'] ?>
        </h3>

        <p style="color:#6b7280;">
            <?= $task['description'] ?>
        </p>

        <form method="POST" action="/controller/TasksController">
            <input type="hidden" name="id" value="<?= $task['id'] ?>">

            <?php if ($task['status'] === 'done'): ?>
                <button
                    style="background:#e5e7eb;color:#1f2937;border:none;padding:8px 14px;border-radius:6px;cursor:not-allowed;"disabled>
                    ✔ Completed
                </button>
            <?php else: ?>
                <button
                    style="background:#2563eb;color:white;border:none;padding:8px 14px;border-radius:6px;cursor:pointer;">
                    Mark as done
                </button>
            <?php endif; ?>
        </form>

    </div>

<?php endforeach; ?>

</div>
