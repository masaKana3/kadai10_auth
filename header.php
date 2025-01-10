<?php
session_start();
$isLoggedIn = isset($_SESSION['chk_ssid']) && $_SESSION['chk_ssid'] === session_id();
$loggedInUser = $isLoggedIn ? $_SESSION['lid'] : null;
// echo $loggedInUser;
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>体調に関するアンケート</title>
</head>

<body>
    <div class="header-navi">
        <div class="menu-header">
            <h1>管理メニュー</h1>
            <?php if ($isLoggedIn): ?>
                <div class="user-info">
                    <span>ログイン中: <?= h($loggedInUser) ?></span>
                    <a href="logout_act.php" class="logout-link">ログアウト</a>
                </div>
            <?php endif; ?>
        </div>
        <nav>
            <ul class="menu-list">
                <li><a href="read.php">回答を見る</a></li>
                <li><a href="chart1.php">集計結果を見る</a></li>
                <li><a href="index.php">アンケートに戻る</a></li>
                <li>
                    <a href="download.php">
                        CSVダウンロード <img src="img/download.png" alt="ダウンロード" class="menu-icon">
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <style>
        .header-navi {
            background-color: #f0f0f0;
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* ヘッダーのタイトルとログイン情報 */
        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1200px;
        }
        .menu-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .user-info {
            display: flex;
            gap: 15px;
            align-items: center;
            font-size: 14px;
        }
        .user-info span {
            color: #555;
        }
        .logout-link {
            color: #333;
            text-decoration: none;
            font-size: 14px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .logout-link:hover {
            background-color: #007bff;
            color: white;
        }

        .menu-list {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
        }
        .menu-list li {
            display: inline-block;
        }
        .menu-list a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            padding: 5px 10px;
            transition: color 0.3s;
        }
        .menu-list a:hover {
            color: #007bff;
        }
        /* メニューアイコン */
        .menu-icon {
            vertical-align: middle;
            width: 20px;
            height: 20px;
            margin-left: 5px;
        }
    </style>
</body>
</html>
