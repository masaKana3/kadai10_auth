<?php
require_once('funcs.php');
$pdo = db_conn();

// ハッシュ化する対象のユーザーIDとパスワード
$lid = '*****'; // ユーザーID追加されたらここに入れる
$plain_password = '*****'; // 平文のパスワードを入れる

// パスワードをハッシュ化
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// データベースに保存
$stmt = $pdo->prepare("UPDATE survey1_user_table SET lpw = :lpw WHERE lid = :lid");
$stmt->bindValue(':lpw', $hashed_password, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status) {
    echo $hashed_password;
    echo "パスワードをハッシュ化して保存しました。";
} else {
    echo "エラーが発生しました。";
}
?>
