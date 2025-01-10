<?php
session_start();
    require_once('funcs.php');
    require_once("header.php"); // 共通ナビメニューを読み込む

    loginCheck(); // funcs.php 内にセッションを確認する関数を実装
    $pdo = db_conn();

// 各項目ごとのデータ取得
$queries = [
    'gender' => "SELECT gender AS label, COUNT(*) AS count FROM survey1_con_table GROUP BY gender",
    'generation' => "SELECT generation AS label, COUNT(*) AS count FROM survey1_con_table GROUP BY generation",
    'area' => "SELECT area AS label, COUNT(*) AS count FROM survey1_con_table GROUP BY area ORDER BY count DESC",
    'agree' => "SELECT agree AS label, COUNT(*) AS count FROM survey1_con_table GROUP BY agree",
    'condition' => "
        SELECT condition_name AS label, SUM(count) AS count 
        FROM (
            SELECT condition1 AS condition_name, COUNT(*) AS count 
            FROM survey1_con_table WHERE condition1 IS NOT NULL GROUP BY condition1
            UNION ALL
            SELECT condition2 AS condition_name, COUNT(*) AS count 
            FROM survey1_con_table WHERE condition2 IS NOT NULL GROUP BY condition2
            UNION ALL
            SELECT condition2 AS condition_name, COUNT(*) AS count 
            FROM survey1_con_table WHERE condition3 IS NOT NULL GROUP BY condition3
            UNION ALL
            SELECT condition2 AS condition_name, COUNT(*) AS count 
            FROM survey1_con_table WHERE condition4 IS NOT NULL GROUP BY condition4
            UNION ALL
            SELECT condition2 AS condition_name, COUNT(*) AS count 
            FROM survey1_con_table WHERE condition5 IS NOT NULL GROUP BY condition5
            UNION ALL
            SELECT condition2 AS condition_name, COUNT(*) AS count 
            FROM survey1_con_table WHERE condition6 IS NOT NULL GROUP BY condition6
        ) AS combined_conditions
        GROUP BY condition_name ORDER BY count DESC"
];

$data = [];
foreach ($queries as $key => $sql) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data[$key] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// JSON に変換して JavaScript に渡す
$json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>アンケート集計結果</title>
</head>

<body>
    <h1>アンケート集計結果</h1>

    <!-- 集計結果とグラフを表示するコンテナ -->
    <div id="result-container">
        <?php foreach ($data as $key => $items): ?>
            <div class="result-section">
                <!-- 各項目のタイトル -->
                <h3><?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?></h3>

                <!-- 集計結果のリスト -->
                <div class="list-container">
                    <ul>
                        <?php foreach ($items as $item): ?>
                            <li><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>: <?= htmlspecialchars($item['count'], ENT_QUOTES, 'UTF-8') ?>件</li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- グラフ描画用のキャンバス -->
                <canvas id="<?= $key ?>Chart"></canvas>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // PHP から渡されたデータを JavaScript に変換
        const data = <?= $json_data ?>;

        // グラフ描画用設定
        const chartSettings = {
            gender: { title: "性別", type: "pie" },
            generation: { title: "年代", type: "pie" },
            area: { title: "居住地", type: "bar" },
            agree: { title: "症状の有無", type: "pie" },
            condition: { title: "症状", type: "bar" }
        };

        // 各項目ごとにグラフを生成
        Object.keys(data).forEach(key => {
            const canvas = document.getElementById(`${key}Chart`);

            // グラフタイプが "pie" の場合、サイズを調整
            if (chartSettings[key].type === 'pie') {
                canvas.style.width = '40%'; // 横幅を70%に設定
                canvas.style.height = '40%'; // 高さも70%に設定
                canvas.style.margin = '0 auto'; // 中央揃え
            } else {
                canvas.style.width = '80%'; // 横幅を70%に設定
                
                canvas.style.margin = '0 auto'; // 中央揃え
            }

            const ctx = document.getElementById(`${key}Chart`).getContext('2d');
            const chartData = data[key];
            const labels = chartData.map(item => item.label);
            const values = chartData.map(item => item.count);

            // グラフの色を自動生成
            const colors = Array.from({ length: values.length }, (_, i) => `hsl(${i * 360 / values.length}, 70%, 60%)`);

            // グラフを描画
            new Chart(ctx, {
                type: chartSettings[key].type,
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: chartSettings[key].title
                        }
                    }
                }
            });
        });
    </script>
    <div class="button-box">
        <button id="next" type="button" onclick="location.href='read.php'">回答結果を表示</button>
        <button id="top-page" type="button" onclick="location.href='index.php'">アンケートに戻る</button>
    </div>
</body>
</html>