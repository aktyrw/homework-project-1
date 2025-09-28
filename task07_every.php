<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

$allPositive = fn(array $arr) => array_reduce(
    $arr,
    fn(bool $carry, int $n) => $carry && ($n > 0),
    true
);

$examples = [
    [1, 2, 3, 4],
    [1, -2, 3, 4]
];

$userResult = null;
if (!empty($_POST['numbers'])) {
    $input = trim($_POST['numbers']);
    $parts = preg_split('/[\s,;]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
    $arr = array_map('intval', $parts);
    $userResult = [
        'array' => $arr,
        'result' => $allPositive($arr)
    ];
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Задача 7 — every()</title>
  <style>
    body { font-family: system-ui, sans-serif; margin: 24px; background: #ffe6f0; }
    .card { background: white; border: 2px solid #ff80bf; border-radius: 16px; padding: 20px; max-width: 720px; box-shadow: 0 4px 10px rgba(255,105,180,0.3); margin: auto; }
    h1 { margin: 0 0 16px; font-size: 24px; color: #ff1493; text-align: center; }
    .example, .result { background: #ffccf2; border-radius: 12px; padding: 10px 14px; margin: 8px 0; font-size: 18px; display: flex; align-items: center; gap: 10px; }
    .icon { font-size: 20px; }
    form { margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap; }
    input, button { padding: 8px 12px; border-radius: 8px; border: 1px solid #ff80bf; }
    input:focus { outline: none; border-color: #ff1493; }
    button { background: #ff66b2; color: white; font-weight: bold; cursor: pointer; }
    button:hover { background: #ff1493; }
    .true { color: green; font-weight: bold; }
    .false { color: red; font-weight: bold; }
  </style>
</head>
<body>
  <div class="card">
    <h1>🌸 все ли числа положительные?</h1>

    <h2>Примеры:</h2>
    <?php foreach ($examples as $arr): ?>
      <div class="example">
        <span class="icon">🌺</span>
        [<?= implode(", ", $arr) ?>] →
        <span class="<?= $allPositive($arr) ? 'true' : 'false' ?>">
          <?= $allPositive($arr) ? 'true ✅' : 'false ❌' ?>
        </span>
      </div>
    <?php endforeach; ?>

    <h2>🔢 Проверь свой массив:</h2>
    <form method="post">
      <input type="text" name="numbers" placeholder="Напр. 1, 2, 3, 4" required />
      <button type="submit">Проверить</button>
    </form>

    <?php if ($userResult !== null): ?>
      <div class="result">
        <span class="icon">🌟</span>
        [<?= implode(", ", $userResult['array']) ?>] →
        <span class="<?= $userResult['result'] ? 'true' : 'false' ?>">
          <?= $userResult['result'] ? 'true ✅' : 'false ❌' ?>
        </span>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>