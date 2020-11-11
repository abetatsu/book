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
          <input type="text" name="title" id="title" value="<?php echo $review['title'] ?>">
     </div>
     <div>
          <label for="author">著者名</label>
          <input type="text" name="author" id="author" value="<?php echo $review['author'] ?>">
     </div>
     <div>
          <label>読書状況</label>
          <div>
               <div>
                    <input type="radio" name="status" id="yet" value="未読" <?php echo ($review['status'] === '未読') ? 'checked' : ''; ?>>
                    <label for="yet">未読</label>
               </div>
               <div>
                    <input type="radio" name="status" id="now" value="読んでいる" <?php echo ($review['status'] === '読んでいる') ? 'checked' : ''; ?>>
                    <label for="now">読んでいる</label>
               </div>
               <div>
                    <input type="radio" name="status" id="done" value="読了" <?php echo ($review['status'] === '読了') ? 'checked' : ''; ?>>
                    <label for="done">読了</label>
               </div>
          </div>
     </div>
     <div>
          <label for="score">評価(5点満点の整数)</label>
          <input type="number" name="score" id="score" value="<?php echo $review['score'] ?>">
     </div>
     <div>
          <label for="summary">感想</label>
          <textarea type="text" name="summary" id="summary"><?php echo $review['summary'] ?></textarea>
     </div>
     <input type="submit" value="登録する">
</form>
</body>
</html>
