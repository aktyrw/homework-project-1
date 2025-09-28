<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

$books = [
    ['title' => '1984', 'author' => 'George Orwell'],
    ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
    ['title' => 'Brave New World', 'author' => 'Aldous Huxley'],
];

if (isset($_POST['add_title'], $_POST['add_author'])) {
    $title = trim($_POST['add_title']);
    $author = trim($_POST['add_author']);
    if ($title !== '' && $author !== '') {
        $books[] = ['title' => $title, 'author' => $author];
    }
}

$found = null;
if (isset($_POST['search_title'])) {
    $titleToFind = trim($_POST['search_title']);
    foreach ($books as $book) {
        if (mb_strtolower($book['title']) === mb_strtolower($titleToFind)) {
            $found = $book;
            break;
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Задача 5 — find()</title>
  <style>
    body { font-family: system-ui, sans-serif; margin: 24px; background: #ffe6f0; }
    .card { background: white; border: 2px solid #ff80bf; border-radius: 16px; padding: 20px; max-width: 760px; box-shadow: 0 4px 10px rgba(255,105,180,0.3); margin: auto; }
    h1 { margin: 0 0 16px; font-size: 24px; color: #ff1493; text-align: center; }
    ul { list-style: none; padding: 0; margin: 0 0 20px; }
    li { background: #ffccf2; border-radius: 12px; padding: 10px 14px; margin: 8px 0; font-size: 18px; display: flex; align-items: center; gap: 10px; }
    .icon { font-size: 20px; }
    form { margin: 12px 0; display: flex; gap: 10px; flex-wrap: wrap; }
    input, button { padding: 8px 12px; border-radius: 8px; border: 1px solid #ff80bf; }
    input:focus { outline: none; border-color: #ff1493; }
    button { background: #ff66b2; color: white; font-weight: bold; cursor: pointer; }
    button:hover { background: #ff1493; }
    .highlight { background: #ffb6e6; padding: 6px 10px; border-radius: 10px; display: inline-block; margin-top: 10px; }
  </style>
</head>
<body>
  <div class="card">
    <h1> Поиск книги</h1>

    <h2>Список книг:</h2>
    <ul>
      <?php foreach ($books as $book): ?>
        <li><span class="icon">🌸</span> <?= htmlspecialchars($book['title']) ?> — <em><?= htmlspecialchars($book['author']) ?></em></li>
      <?php endforeach; ?>
    </ul>

    <h2>🔍 Найти книгу по названию:</h2>
    <form method="post">
      <input type="text" name="search_title" placeholder="Введите название..." required />
      <button type="submit">Искать</button>
    </form>
    <?php if ($found !== null): ?>
      <p class="highlight">✅ Найдена: <?= htmlspecialchars($found['title']) ?> (<?= htmlspecialchars($found['author']) ?>)</p>
    <?php elseif (isset($_POST['search_title'])): ?>
      <p class="highlight">❌ Книга не найдена</p>
    <?php endif; ?>

    <h2>➕ Добавить книгу:</h2>
    <form method="post">
      <input type="text" name="add_title" placeholder="Название" required />
      <input type="text" name="add_author" placeholder="Автор" required />
      <button type="submit">Добавить</button>
    </form>
  </div>
</body>
</html>