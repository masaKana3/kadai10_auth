<?php
session_start();

require_once("funcs.php");
$pdo = db_conn();

$error = $_SESSION['error'] ?? null; // セッションからエラーメッセージを取得
unset($_SESSION['error']); // エラーメッセージを一度表示したら削除

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>体調に関するアンケート</title>
    <div class="header-navi">
        
    </div>
</head>

<body>
    <h1>管理メニュー ログイン</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= h($error) ?></p>
    <?php endif; ?>
    <div class="login-container">
        <form method="post" action="login_act.php">
            <label for="username">ユーザーID:</label>
            <input type="text" id="username" name="lid" required>
            <br>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="lpw" required>
            <br>
            <button id="submit-button" type="submit">ログイン</button>
        </form>
    </div>
    <div class="button-box">
        <button id="top-page" type="button" onclick="location.href='index.php'">アンケートに戻る</button>
    </div>
</body>
</html>