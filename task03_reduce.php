<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

$length = rand(4, 8); 
$numbers = [];
for ($i = 0; $i < $length; $i++) {
    $numbers[] = rand(1, 20);
}

$sum = array_reduce($numbers, fn(int $carry, int $n) => $carry + $n, 0);
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Задача 3 — reduce()</title>
  <style>
    body { font-family: system-ui, sans-serif; margin: 24px; }
    .card { border:1px solid #ddd; border-radius:12px; padding:16px; max-width:720px; }
    h1 { margin: 0 0 12px; font-size: 20px; }
    .numbers { font-size: 18px; margin: 12px 0; }
    .highlight { color: darkblue; font-weight: bold; }
    .muted { color:#666; font-size: 13px; margin-top: 16px; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Использование <code>reduce</code>: сумма элементов массива</h1>
    <p class="numbers">
      Массив: [ <?= implode(", ", $numbers) ?> ]
    </p>
    <p class="numbers">
      Сумма элементов = <span class="highlight"><?= $sum ?></span>
    </p>
    <p class="muted">
      При каждом обновлении страницы создаётся новый случайный массив чисел.
    </p>
  </div>
</body>
</html>