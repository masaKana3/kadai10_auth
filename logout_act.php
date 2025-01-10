<?php
// セッションの開始
session_start();

// セッション変数をすべて削除
$_SESSION = [];

// クッキーにセッションIDがある場合は無効化
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// セッションを破棄
session_destroy();

// ログインページへリダイレクト
header("Location: login.php");
exit();