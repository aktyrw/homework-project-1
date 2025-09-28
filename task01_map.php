<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$numbers = [];
for ($i = 0; $i < 5; $i++) {
    $numbers[] = rand(1, 10);
}


$doubled = array_map(fn(int $n) => $n * 2, $numbers);


echo "Использование map:<br>";
echo "Исходный массив: [" . implode(", ", $numbers) . "]<br>";
echo "Умноженный на 2: [" . implode(", ", $doubled) . "]<br>";