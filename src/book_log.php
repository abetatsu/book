<?php

function validate($review) {

     $errors = [];

     if (!strlen($review['title'])) {
          $errors['title'] = '書籍名を入力してください';
     } elseif (strlen($review['title']) > 255) {
          $errors['title'] = '書籍名は255文字以内で入力してください';
     }

     if (!strlen($review['author'])) {
          $errors['author'] = '著者名を入力してください';
     } elseif (strlen($review['author']) > 100) {
          $errors['author'] = '著者名は255文字以内で入力してください';
     }

     if (!in_array($review['status'], ['未読', '読んでいる', '読了'], true)) {
          $errors['status'] = '読者状況は、未読、読んでいる、読了の中から選択してください';
     }


     if (1 > $review['score'] || 5 < $review['score']) {
          $errors['score'] = '1以上5以下の整数で入力してください';
     }

     if (!strlen($review['summary'])) {
          $errors['summary'] = '感想を入力してください';
     } elseif (strlen($review['summary']) > 100) {
          $errors['summary'] = '感想は1000文字以内で入力してください';
     }

     return $errors;
}

function createReviews($link) {

     $reviews = [];

     echo '読書ログを登録してください' . PHP_EOL;
     echo '書籍名 ：';
     $reviews['title'] = trim(fgets(STDIN));

     echo '著者名 ：';
     $reviews['author'] = trim(fgets(STDIN));

     echo '読書状況(未読、読んでいる、読了) ：';
     $reviews['status'] = trim(fgets(STDIN));

     echo '評価（5点満点の整数）：';
     $reviews['score'] = (int) trim(fgets(STDIN));

     echo '感想 ：';
     $reviews['summary'] = trim(fgets(STDIN));

     $validated = validate($reviews);
     if ($validated) {
          foreach($validated as $error) {
               echo $error . PHP_EOL;
          }
          return;
     }

     $sql =<<<EOD
     INSERT INTO reviews (
     title,
     author,
     status,
     score,
     summary
     ) VALUES (
     "{$reviews['title']}",
     "{$reviews['author']}",
     "{$reviews['status']}",
     "{$reviews['score']}",
     "{$reviews['summary']}"
     )
     EOD;

     $result = mysqli_query($link, $sql);
     if ($result) {
          echo '登録が完了しました' . PHP_EOL . PHP_EOL;
     } else {
          echo 'Error: データの追加に失敗しました' . PHP_EOL;
          echo 'Debugging Error: ' . mysqli_error($link) . PHP_EOL . PHP_EOL;
     }

}

function showReviews($link) {

     $sql = 'SELECT title, author, status, score, summary FROM reviews';
     $result = mysqli_query($link, $sql);

     while ($review = mysqli_fetch_assoc($result)) {
          echo '書籍名 ：' . $review['title'] . PHP_EOL;
          echo '著者名 ：' . $review['author'] . PHP_EOL;
          echo '読書状況(未読、読んでいる、読了) ：' . $review['status'] . PHP_EOL;
          echo '評価（5点満点の整数）：' . $review['score'] . PHP_EOL;
          echo '感想 ：' . $review['summary'] . PHP_EOL;
          echo '-------------' . PHP_EOL;
     }

     mysqli_free_result($result);

}

function dbConnect()
{
     $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

     if (!$link) {
          echo 'Error: データベースに接続できません' . PHP_EOL;
          echo 'Debugging Error:' . mysqli_connect_error() . PHP_EOL;
          exit;
     }

     return $link;
}

$link = dbConnect();

while (true) {
     echo '1. 読書ログを登録' . PHP_EOL;
     echo '2. 読書ログを表示' . PHP_EOL;
     echo '9. アプリケーションを終了' . PHP_EOL;
     echo '番号を選択してください(1,2,9):';
     $num = trim(fgets(STDIN));

     if ($num === '1') {
          createReviews($link);
     } elseif ($num === '2') {
          showReviews($link);
     } elseif ($num === '9') {
          mysqli_close($link);
     break;
     }
}
