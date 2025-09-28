<?php
declare(strict_types=1);
session_start();
ini_set('display_errors','1');ini_set('display_startup_errors','1');error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = [
        ['task' => 'Write report', 'status' => 'completed', 'priority' => 'high'],
        ['task' => 'Send email', 'status' => 'pending', 'priority' => 'low'],
    ];
}

if (!empty($_POST['task'])) {
    $_SESSION['todos'][] = [
        'task' => trim($_POST['task']),
        'status' => $_POST['status'],
        'priority' => $_POST['priority']
    ];
}

$todos = $_SESSION['todos'];
$important = [];
foreach ($todos as $t) {
    if ($t['priority']==='high' && $t['status']!=='completed') {
        $important[]=$t;
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Задача 10 — Задачи</title>
  <style>
    body{font-family:system-ui;background:#ffe6f0;margin:24px}
    .card{background:white;border:2px solid #ff80bf;border-radius:16px;padding:20px;max-width:720px;margin:auto;box-shadow:0 4px 10px rgba(255,105,180,.3)}
    h1{color:#ff1493;text-align:center}
    ul{list-style:none;padding:0}
    li{background:#ffccf2;padding:10px;margin:6px 0;border-radius:12px}
    form{margin:16px 0;display:flex;gap:8px;flex-wrap:wrap}
    input,select,button{padding:6px;border:1px solid #ff80bf;border-radius:6px}
    button{background:#ff66b2;color:white;cursor:pointer}
    button:hover{background:#ff1493}
  </style>
</head>
<body>
<div class="card">
  <h1>📝To-Do</h1>
  
  <form method="post">
    <input type="text" name="task" placeholder="Новая задача" required>
    <select name="priority">
      <option value="high">Высокий</option>
      <option value="medium">Средний</option>
      <option value="low">Низкий</option>
    </select>
    <select name="status">
      <option value="pending">В процессе</option>
      <option value="completed">Выполнена</option>
    </select>
    <button type="submit">Добавить</button>
  </form>

  <h2>Все задачи:</h2>
  <ul>
    <?php foreach($todos as $t): ?>
      <li><?= htmlspecialchars($t['task']) ?> — <?= $t['priority'] ?> (<?= $t['status'] ?>)</li>
    <?php endforeach; ?>
  </ul>

  <h2>⚡ Важные невыполненные:</h2>
  <ul>
    <?php foreach($important as $t): ?>
      <li>🔥 <?= htmlspecialchars($t['task']) ?> (<?= $t['priority'] ?>)</li>
    <?php endforeach; ?>
    <?php if(empty($important)): ?><li>🌸 Всё выполнено!</li><?php endif; ?>
  </ul>
</div>
</body>
</html>