<?php

$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

if (!$link) {
     echo 'Error: データベースに接続できませんでした' . PHP_EOL;
     echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
     exit;
}

echo 'データベースに接続できました' . PHP_EOL;

// $sql = <<<EOT
// INSERT INTO companies (
//      name,
//      establishment_date,
//      founder
// ) VALUES (
//      'SmartHR Inc',
//      '2013-01-27',
//      'Shoji Miyata'
// )
// EOT;

// mysqli_query($link, $sql);

$sql = 'SELECT name, founder FROM companies';
$result = mysqli_query($link, $sql);

while ($company = mysqli_fetch_assoc($result)) {
     echo '会社名：' . $company['name'] . PHP_EOL;
     echo '社長名：' . $company['founder'] . PHP_EOL;
}

mysqli_free_result($result);

mysqli_close($link);
echo 'データベースとの接続を切断しました' . PHP_EOL;
