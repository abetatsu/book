<?php

require_once __DIR__ . '/lib/mysqli.php';

function createReview($link, $review)
{
     $sql = <<<EOT
     INSERT INTO reviews (
          title,
          author,
          status,
          score,
          summary
     ) VALUES (
          "{$review['title']}",
          "{$review['author']}",
          "{$review['status']}",
          "{$review['score']}",
          "{$review['summary']}"
     )
EOT;

     $result = mysqli_query($link, $sql);
     if (!$result)
     {
          error_log('Error: fail to create error');
          error_log('Debugging Error:' . mysqli_error($link));
     }
}

function validate($review)
{
     $errors = [];

     if (!strlen($review['title'])) {
          $errors['title'] = '書籍名を入力してください';
     } else if (strlen($review['title']) > 255) {
          $errors['title'] = '書籍名は255文字以下で入力してください';
     }

     if (!strlen($review['author'])) {
          $errors['author'] = '著者名を入力してください';
     } else if (strlen($review['author']) > 100) {
          $errors['author'] = '著者名は100文字以下で入力してください';
     }

     if (!in_array($review['status'], ['未読', '読んでいる', '読了'])) {
          $errors['status'] = '読者状況は未読、読んでいる、読了から選択してください';
     }

     if ($review['score'] < 1 || $review['score'] > 5) {
          $errors['score'] = '1~5の数字で入力してください';
     }

     if (!strlen($review['summary'])) {
          $errors['summary'] = '感想を入力してください';
     } else if (strlen($review['summary']) > 1000) {
          $errors['summary'] = '感想は1000文字以下で入力してください';
     }

     return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $status = '';
     if (array_key_exists('status', $_POST)) {
          $status = $_POST['status'];
     }

     $review = [
          'title' => $_POST['title'],
          'author' => $_POST['author'],
          'status' => $status,
          'score' => $_POST['score'],
          'summary' => $_POST['summary']
     ];

     // バリデーション
     $errors = validate($review);
     if (!$errors) {
          // データベース接続
          $link = dbConnect();
          // データベースに登録
          createReview($link, $review);
          // データベースとの接続切断
          mysqli_close($link);
          header("Location: index.php");
     }
}

include 'views/new.php';
