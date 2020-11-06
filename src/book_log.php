<?php

function createReviews() {

     echo '読書ログを登録してください' . PHP_EOL;
     echo '書籍名 ：';
     $title = trim(fgets(STDIN));

     echo '著者名 ：';
     $author = trim(fgets(STDIN));

     echo '読書状況(未読、読んでいる、読了) ：';
     $status = trim(fgets(STDIN));

     echo '評価（5点満点の整数）：';
     $score = trim(fgets(STDIN));

     echo '感想　：';
     $summary = trim(fgets(STDIN));

     echo '登録が完了しました' . PHP_EOL. PHP_EOL;

     return [
          'title' => $title,
          'author' => $author,
          'status' => $status,
          'score' => $score,
          'summary' => $summary,
     ];
}

function showReviews($reviews) {

     echo '書籍名を表示します' . PHP_EOL;
          foreach($reviews as $review)
          {
               echo '書籍名　：' . $review['title'] . PHP_EOL;
               echo '著者名　：' . $review['author'] . PHP_EOL;
               echo '読書状況(未読、読んでいる、読了)　：' . $review['status'] . PHP_EOL;
               echo '評価（5点満点の整数）：' . $review['score'] . PHP_EOL;
               echo '感想　：' . $review['summary'] . PHP_EOL;
               echo '-------------' . PHP_EOL;
          }

}

function dbConnect()
{
     $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

     if (!$link) {
          echo 'Error: データベースに接続できません' . PHP_EOL;
          echo 'Debugging Error:' . mysqli_connect_error() . PHP_EOL;
          exit;
     }

     echo 'データベースに接続できました' . PHP_EOL;

     return $link;
}

$reviews = [];


$link = dbConnect();

while (true) {
     echo '1. 読書ログを登録' . PHP_EOL;
     echo '2. 読書ログを表示' . PHP_EOL;
     echo '9. アプリケーションを終了' . PHP_EOL;
     echo '番号を選択してください(1,2,9):';
     $num = trim(fgets(STDIN));

     if ($num === '1') {
          $reviews[] = createReviews();
     } elseif ($num === '2') {
          showReviews($reviews);
     } elseif ($num === '9') {
          mysqli_close($link);
     break;
     }
}
