<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $review = [
          'title' => $_POST['title'],

     ];
}

// バリデーション
// データベース接続
// データベースに登録
// データベースとの接続切断
