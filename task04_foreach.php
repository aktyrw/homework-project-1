<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

// --- Массив студентов (по умолчанию) ---
$students = [
    ['name' => 'Alice', 'age' => 21],
    ['name' => 'Bob',   'age' => 22],
    ['name' => 'Carol', 'age' => 23],
];

// --- Если форма отправлена, добавляем нового студента ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $age  = (int)($_POST['age'] ?? 0);
    if ($name !== '' && $age > 0) {
        $students[] = ['name' => $name, 'age' => $age];
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Задача 4 — forEach()</title>
  <style>
    body { font-family: system-ui, sans-serif; margin: 24px; background: #ffe6f0; }
    .card { background: white; border: 2px solid #ff80bf; border-radius: 16px; padding: 20px; max-width: 720px; box-shadow: 0 4px 10px rgba(255,105,180,0.3); margin: auto; }
    h1 { margin: 0 0 16px; font-size: 24px; color: #ff1493; text-align: center; }
    ul { list-style: none; padding: 0; margin: 0; }
    li { background: #ffccf2; border-radius: 12px; padding: 10px 14px; margin: 8px 0; font-size: 18px; display: flex; align-items: center; gap: 10px; }
    .icon { font-size: 20px; }
    form { margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
    input, button { padding: 8px 12px; border-radius: 8px; border: 1px solid #ff80bf; }
    input:focus { outline: none; border-color: #ff1493; }
    button { background: #ff66b2; color: white; font-weight: bold; cursor: pointer; }
    button:hover { background: #ff1493; }
  </style>
</head>
<body>
  <div class="card">
    <h1> Список студентов</h1>
    <ul>
      <?php foreach ($students as $s): ?>
        <li><span class="icon">🌸</span> <?= htmlspecialchars($s['name']) ?> (<?= $s['age'] ?>)</li>
      <?php endforeach; ?>
    </ul>

    <form method="post">
      <input type="text" name="name" placeholder="Имя студента" required />
      <input type="number" name="age" placeholder="Возраст" min="1" required />
      <button type="submit">➕ Добавить</button>
    </form>
  </div>
</body>
</html>