<?php
declare(strict_types=1);
session_start();
ini_set('display_errors','1');ini_set('display_startup_errors','1');error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        ['name' => 'Alice', 'age' => 28, 'isSubscribed' => true],
        ['name' => 'Bob', 'age' => 35, 'isSubscribed' => false],
    ];
}

if (!empty($_POST['name']) && !empty($_POST['age'])) {
    $_SESSION['users'][] = [
        'name' => trim($_POST['name']),
        'age' => (int)$_POST['age'],
        'isSubscribed' => isset($_POST['sub'])
    ];
}

$users = $_SESSION['users'];
$filtered = array_values(array_filter($users, fn($u) => $u['isSubscribed'] && $u['age'] > 30));
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Задача 9 — Пользователи</title>
  <style>
    body{font-family:system-ui;background:#ffe6f0;margin:24px}
    .card{background:white;border:2px solid #ff80bf;border-radius:16px;padding:20px;max-width:720px;margin:auto;box-shadow:0 4px 10px rgba(255,105,180,.3)}
    h1{color:#ff1493;text-align:center}
    ul{list-style:none;padding:0}
    li{background:#ffccf2;padding:10px;margin:6px 0;border-radius:12px}
    form{margin:16px 0;display:flex;gap:8px;flex-wrap:wrap}
    input,button{padding:6px;border:1px solid #ff80bf;border-radius:6px}
    button{background:#ff66b2;color:white;cursor:pointer}
    button:hover{background:#ff1493}
  </style>
</head>
<body>
<div class="card">
  <h1>👩‍💻Users</h1>
  
  <form method="post">
    <input type="text" name="name" placeholder="Имя" required>
    <input type="number" name="age" placeholder="Возраст" required>
    <label><input type="checkbox" name="sub"> Подписка</label>
    <button type="submit">Добавить</button>
  </form>

  <h2>Все пользователи:</h2>
  <ul>
    <?php foreach($users as $u): ?>
      <li><?= htmlspecialchars($u['name']) ?> (<?= $u['age'] ?>) — <?= $u['isSubscribed'] ? '✅ подписка' : '❌ нет' ?></li>
    <?php endforeach; ?>
  </ul>

  <h2>Фильтр: старше 30 и с подпиской</h2>
  <ul>
    <?php foreach($filtered as $u): ?>
      <li>🌸 <?= htmlspecialchars($u['name']) ?> (<?= $u['age'] ?>)</li>
    <?php endforeach; ?>
    <?php if(empty($filtered)): ?><li>❌ Никого нет</li><?php endif; ?>
  </ul>
</div>
</body>
</html>