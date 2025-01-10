<?php
    session_start();
    require_once('funcs.php');
    require_once("header.php"); // 共通ナビメニューを読み込む

    loginCheck(); // funcs.php 内にセッションを確認する関数を実装
    $pdo = db_conn();

    // データを取得するクエリ
    $sql = "SELECT id, gender, generation, area, agree, condition1, condition2, condition3, condition4, condition5, condition6 FROM survey1_con_table";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // 結果を配列で取得

    $img_update = 'img/update.png';
    $img_delete = 'img/delete.png';
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
    <h1>アンケート回答結果</h1>

    <div class="data-table-container">
    
        <?php
        // データを画面に表示
            echo "<table class='data-table'>";
            echo "<tr><th>ID</th><th>性別</th><th>年代</th><th>居住地</th><th>症状はありますか</th>
                <th>症状1</th><th>症状2</th><th>症状3</th><th>症状4</th><th>症状5</th><th>症状6</th>
                <th>更新</th><th>削除</th></tr>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . h($row['id']) . "</td>";
                echo "<td>" . h($row['gender']) . "</td>";
                echo "<td>" . h($row['generation']) . "</td>";
                echo "<td>" . h($row['area']) . "</td>";
                echo "<td>" . h($row['agree']) . "</td>";
                for ($i = 1; $i <= 6; $i++) {
                    echo "<td>" . h($row["condition$i"]) . "</td>";
                }

                // 更新と削除のリンクを一列に正しく配置
                echo "<td><a href='detail.php?id=" . $row['id'] . "'>";
                echo "<img src='" . $img_update . "' alt='update' width='30' height='30'></a></td>";
                echo "<td><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"削除してよろしいですか？\");'>";
                echo "<img src='" . $img_delete . "' alt='delete' width='30' height='30'></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </div>
    
    <div class="button-box">
        <button id="next" type="button" onclick="location.href='chart1.php'">集計結果を表示</button>
        <button id="top-page" type="button" onclick="location.href='index.php'">アンケートに戻る</button>
        <div id="download-img"> 
            <a href="download.php"><img src="img/download.png" alt="download" width="30px"></a>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script></script>
</body>
</html>