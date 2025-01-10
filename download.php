<?php
include("funcs.php");
$pdo = db_conn();

// CSVファイルのパス
$file_path = "conditions.csv";
$export_csv_title = ["ID", "性別", "年代", "居住地", "症状の有無", "症状1", "症状2", "症状3", "症状4", "症状5", "症状6", "日時"];

$sql = "SELECT id, gender, generation, area, agree, condition1, condition2, condition3, condition4, condition5, condition6, date FROM survey1_con_table";

// ヘッダー行をSJIS-winに変換
$export_header = array_map(function($val) {
    return mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
}, $export_csv_title);

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // 結果を配列で取得

    // ファイルを開く
    $file = fopen($file_path, "w");
    if (!$file) {
        throw new Exception("CSVファイルの作成に失敗しました。");
    }

    // ヘッダー行を書き込む
    fputcsv($file, $export_header);

    // データ行を書き込む
    foreach ($results as $row) {
        $data = array_map(function($value) {
            return mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
        }, $row);
        fputcsv($file, $data);
    }

    // ファイルを閉じる
    fclose($file);

    // ファイルをダウンロード
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);

    // 完了後、read.phpにリダイレクト
    header("Location: read.php");
    exit();
} catch (Exception $e) {
    echo "エラーが発生しました: " . $e->getMessage();
}

?>