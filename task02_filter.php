<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

$len = function (string $s): int {
    return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen($s);
};

$pool = ['apple','banana','kiwi','grapefruit','pear','strawberry','melon','plum','mango','pineapple'];

shuffle($pool);
$words = array_slice($pool, 0, 5);


$filtered = array_values(array_filter($words, fn(string $s) => $len($s) > 5));
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Задача 2 — filter()</title>
  <style>
    body { font-family: system-ui, sans-serif; margin: 24px; }
    .card { border:1px solid #ddd; border-radius:12px; padding:16px; max-width:720px; }
    h1 { margin: 0 0 12px; font-size: 20px; }
    .row { display:flex; gap:16px; flex-wrap:wrap; }
    .box { flex:1 1 300px; border:1px solid #eee; border-radius:10px; padding:12px; }
    ul { margin:8px 0 0; padding-left:18px; }
    .muted { color:#666; font-size: 13px; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Использование <code>filter</code>: слова длинее 5 символов</h1>
    <div class="row">
      <div class="box">
        <strong>Исходный массив (обнови страницу — будет другой):</strong>
        <ul>
          <?php foreach ($words as $w): ?>
            <li><?= htmlspecialchars($w, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> (<?= $len($w) ?>)</li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="box">
        <strong>Отфильтровано (длина &gt; 5):</strong>
        <?php if ($filtered): ?>
          <ul>
            <?php foreach ($filtered as $w): ?>
              <li><?= htmlspecialchars($w, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> (<?= $len($w) ?>)</li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="muted">Нет элементов, подходящих под условие.</p>
        <?php endif; ?>
      </div>
</body>
</html>