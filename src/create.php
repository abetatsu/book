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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>読書ログ登録</title>
</head>
<body>
     <h1>読書ログ</h1>
     <form action="create.php" method="post">
     <?php if (count($errors)) : ?>
          <ul>
               <?php foreach($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
               <?php endforeach; ?>
          </ul>
     <?php endif; ?>
     <div>
          <label for="title">書籍名</label>
          <input type="text" name="title" id="title">
     </div>
     <div>
          <label for="author">著者名</label>
          <input type="text" name="author" id="author">
     </div>
     <div>
          <label>読書状況</label>
          <div>
               <div>
                    <input type="radio" name="status" id="yet" value="未読">
                    <label for="yet">未読</label>
               </div>
               <div>
                    <input type="radio" name="status" id="now" value="読んでいる">
                    <label for="now">読んでいる</label>
               </div>
               <div>
                    <input type="radio" name="status" id="done" value="読了">
                    <label for="done">読了</label>
               </div>
          </div>
     </div>
     <div>
          <label for="score">評価(5点満点の整数)</label>
          <input type="number" name="score" id="score">
     </div>
     <div>
          <label for="summary">感想</label>
          <textarea type="text" name="summary" id="summary"></textarea>
     </div>
     <input type="submit" value="登録する">
</form>
</body>
</html>
