<?php
    session_start();
    require_once('funcs.php');
    require_once("header.php"); // 共通ナビメニューを読み込む

    loginCheck(); // funcs.php 内にセッションを確認する関数を実装
    $pdo = db_conn();

    // $id = $_GET['id'];
    $id = $_SESSION['id'];
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
    <!-- id引き継げない問題発生中！ -->
    <h1>体調に関するアンケート ID:<?= h($id); ?></h1>

    <div class="container">
        <div class="text-box">
            <p>入力内容を確認してください</p>
        </div>
        
        <?php 
        // エラー確認のための設定（開発中のみ有効）
        // ini_set('display_errors', 1);
        // error_reporting(E_ALL);

        // POSTまたはGETでデータを取得
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $generation = isset($_POST['generation']) ? $_POST['generation'] : null;
        $area = isset($_POST['area']) ? $_POST['area'] : null;
        $agree = isset($_POST['agree']) ? $_POST['agree'] : null;
        // 条件が複数の場合に備えて
        $condition = isset($_POST['condition']) && is_array($_POST['condition']) ? $_POST['condition'] : [];

        // データが正しく送信されているか確認
        if ($gender === null || $generation === null || $area === null || $agree === null) {
            echo "<p style='color:red;'>エラー: データが送信されていません。</p>";
            exit; // 処理を中断
        }

        // 条件をカンマ区切りの文字列として保存
        $condition_str = implode(',', $condition);

        // デバッグ: POSTデータを確認
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        if ($id) {
            $sql = "UPDATE survey1_con_table 
                    SET gender = :gend, 
                        generation = :gene, 
                        area = :are, 
                        agree = :agr, 
                        condition1 = :con1, 
                        condition2 = :con2, 
                        condition3 = :con3, 
                        condition4 = :con4, 
                        condition5 = :con5, 
                        condition6 = :con6, 
                        conditions = :conds, 
                        date = now() 
                    WHERE id = :id";
        } else {
            // ID が渡されていない場合、新規作成
            $sql = "INSERT INTO survey1_con_table 
                    (id, gender, generation, area, agree, condition1, condition2, condition3, condition4, condition5, condition6, conditions, date) 
                    VALUES (NULL, :gend, :gene, :are, :agr, :con1, :con2, :con3, :con4, :con5, :con6, :conds, now())";
        }
            $stmt = $pdo->prepare($sql);

            // パラメータをバインドして実行
            $stmt->bindValue(':gend', $gender, PDO::PARAM_STR);
            $stmt->bindValue(':gene', $generation, PDO::PARAM_STR);
            $stmt->bindValue(':are', $area, PDO::PARAM_STR);
            $stmt->bindValue(':agr', $agree, PDO::PARAM_STR);
            $stmt->bindValue(':con1', $condition[0] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':con2', $condition[1] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':con3', $condition[2] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':con4', $condition[3] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':con5', $condition[4] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':con6', $condition[5] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':conds', $condition_str, PDO::PARAM_STR);
            if ($id) {
                $stmt->bindValue(':id', $id, PDO::PARAM_INT); // 更新時のみ ID をバインド
            }

            // SQL実行とエラーハンドリング
            if (!$stmt->execute()) {
                echo "SQLエラー: " . implode(", ", $stmt->errorInfo());
                exit;
            }
            echo "<h3>データが保存されました🙌</h3>";
        ?>

        <div class="input-box">
            <p>性別：<?= h($gender) ?></p>
            <p>年代：<?= h($generation) ?></p>
            <p>居住地：<?= h($area) ?></p>
            <p>体調不良を感じることはありますか？：<?= h($agree) ?></p>
            <p>気になる症状：<?= empty($condition) 
                ? "なし" 
                : implode(', ', array_map(fn($c) => h($c), $condition)) ?></p>
        </div>
        <div class="button-box">
            <button id="to-read" onclick="location.href='read.php'">管理メニューへ</button>
            <button id="top-page" type="button" onclick="location.href='index.php'">アンケートに戻る</button>
        </div>
    </div>
</body>
</html>