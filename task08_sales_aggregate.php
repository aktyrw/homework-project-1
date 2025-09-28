<?php
declare(strict_types=1);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);
session_start();
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['sales'])) {
    $_SESSION['sales'] = [
        ['date' => '2023-10-01', 'item' => 'apple', 'amount' => 100],
        ['date' => '2023-10-02', 'item' => 'banana', 'amount' => 150],
    ];
}


if (!empty($_POST['date']) && !empty($_POST['item']) && !empty($_POST['amount'])) {
    $_SESSION['sales'][] = [
        'date' => $_POST['date'],
        'item' => trim($_POST['item']),
        'amount' => (int)$_POST['amount']
    ];
}

$sales = $_SESSION['sales'];

$totals = [];
foreach ($sales as $s) {
    $totals[$s['item']] = ($totals[$s['item']] ?? 0) + $s['amount'];
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Задача 8 — Продажи</title>
  <style>
    body{font-family:system-ui;background:#ffe6f0;margin:24px}
    .card{background:white;border:2px solid #ff80bf;border-radius:16px;padding:20px;max-width:800px;margin:auto;box-shadow:0 4px 10px rgba(255,105,180,.3)}
    h1{color:#ff1493;text-align:center}
    form{margin:16px 0;display:flex;gap:8px;flex-wrap:wrap}
    input{padding:6px;border:1px solid #ff80bf;border-radius:6px}
    button{padding:6px 12px;background:#ff66b2;color:white;border:none;border-radius:8px;cursor:pointer}
    button:hover{background:#ff1493}
    table{width:100%;border-collapse:collapse;margin:16px 0}
    th,td{border:1px solid #ffb6e6;padding:8px;text-align:center}
    th{background:#ffccf2}
    .highlight{background:#ffe0f7;font-weight:bold}
  </style>
</head>
<body>
<div class="card">
  <h1>📊Sales</h1>
  
  <form method="post">
    <input type="date" name="date" required>
    <input type="text" name="item" placeholder="Товар" required>
    <input type="number" name="amount" placeholder="Сумма" required>
    <button type="submit">Добавить продажу</button>
  </form>

  <h2>Все продажи:</h2>
  <table>
    <tr><th>Дата</th><th>Товар</th><th>Сумма</th></tr>
    <?php foreach($sales as $s): ?>
      <tr><td><?= htmlspecialchars($s['date']) ?></td><td><?= htmlspecialchars($s['item']) ?></td><td><?= $s['amount'] ?></td></tr>
    <?php endforeach; ?>
  </table>

  <h2>Итог по каждому товару:</h2>
  <table>
    <tr><th>Товар</th><th>Итого</th></tr>
    <?php foreach($totals as $item=>$sum): ?>
      <tr class="highlight"><td><?= htmlspecialchars($item) ?></td><td><?= $sum ?></td></tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>