<?php 
session_start();
require_once('funcs.php');
require_once("header.php"); // 共通ナビメニューを読み込む

loginCheck(); // funcs.php 内にセッションを確認する関数を実装
$pdo = db_conn();

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM survey1_con_table WHERE id = :id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$result = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    // 取得データを連想配列として格納
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
}

 $conditions = explode(',', $result['conditions']);

// var_dump($result);
// var_dump($conditions);

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
    
    <h1>体調に関するアンケート ID:<?= h($id);?></h1>
   
    <div class="container">
        <p>下記の質問にお答えください</p>
        <form id="survey-form1" method="post" action="rewrite.php">
            <!-- IDをhiddenで送信する -->
            <input type="hidden" name="id" value="<?= h($result['id']) ?>">

            <div class="survey">
                <ol type="1">
                    <!-- radio-button -->
                    <li>性別</li>
                        <label><input type="radio" name="gender" value="男性" <?= $result['gender'] === '男性' ? 'checked' : '' ?>>男性</label><br>
                        <label><input type="radio" name="gender" value="女性" <?= $result['gender'] === '女性' ? 'checked' : '' ?>>女性</input><br>
                        <label><input type="radio" name="gender" value="未回答" <?= $result['gender'] === '未回答' ? 'checked' : '' ?>>回答したくない</label>
                    <li>年代</li>
                        <label><input type="radio" name="generation" value="10代以下" <?= $result['generation'] === '10代以下' ? 'checked' : '' ?>>10代以下</input><br>
                        <label><input type="radio" name="generation" value="20代" <?= $result['generation'] === '20代' ? 'checked' : '' ?>>20代</label><br>
                        <label><input type="radio" name="generation" value="30代" <?= $result['generation'] === '30代' ? 'checked' : '' ?>>30代</label><br>
                        <label><input type="radio" name="generation" value="40代" <?= $result['generation'] === '40代' ? 'checked' : '' ?>>40代</label><br>
                        <label><input type="radio" name="generation" value="50代" <?= $result['generation'] === '50代' ? 'checked' : '' ?>>50代</label><br>
                        <label><input type="radio" name="generation" value="60代以上" <?= $result['generation'] === '60代以上' ? 'checked' : '' ?>>60代以上</label><br>
                        <label><input type="radio" name="generation" value="未回答" <?= $result['generation'] === '未回答' ? 'checked' : '' ?>>回答したくない</label>
                    <div class="area-box">
                    <li>居住地</li>
                        <select name="area" required>
                        <option value="" disabled >--選択してください--</option>
                        <option value="北海道" <?= $result['area'] === '北海道' ? 'selected' : '' ?>>北海道</option>
                        <option value="青森県" <?= $result['area'] === '青森県' ? 'selected' : '' ?>>青森県</option>
                        <option value="岩手県" <?= $result['area'] === '岩手県' ? 'selected' : '' ?>>岩手県</option>
                        <option value="宮城県" <?= $result['area'] === '宮城県' ? 'selected' : '' ?>>宮城県</option>
                        <option value="秋田県" <?= $result['area'] === '秋田県' ? 'selected' : '' ?>>秋田県</option>
                        <option value="山形県" <?= $result['area'] === '山形県' ? 'selected' : '' ?>>山形県</option>
                        <option value="福島県" <?= $result['area'] === '福島県' ? 'selected' : '' ?>>福島県</option>
                        <option value="茨城県" <?= $result['area'] === '茨城県' ? 'selected' : '' ?>>茨城県</option>
                        <option value="栃木県" <?= $result['area'] === '栃木県' ? 'selected' : '' ?>>栃木県</option>
                        <option value="群馬県" <?= $result['area'] === '群馬県' ? 'selected' : '' ?>>群馬県</option>
                        <option value="埼玉県" <?= $result['area'] === '埼玉県' ? 'selected' : '' ?>>埼玉県</option>
                        <option value="千葉県" <?= $result['area'] === '千葉県' ? 'selected' : '' ?>>千葉県</option>
                        <option value="東京都" <?= $result['area'] === '東京都' ? 'selected' : '' ?>>東京都</option>
                        <option value="神奈川県" <?= $result['area'] === '神奈川県' ? 'selected' : '' ?>>神奈川県</option>
                        <option value="新潟県" <?= $result['area'] === '新潟県' ? 'selected' : '' ?>>新潟県</option>
                        <option value="富山県" <?= $result['area'] === '富山県' ? 'selected' : '' ?>>富山県</option>
                        <option value="石川県" <?= $result['area'] === '石川県' ? 'selected' : '' ?>>石川県</option>
                        <option value="福井県" <?= $result['area'] === '福井県' ? 'selected' : '' ?>>福井県</option>
                        <option value="山梨県" <?= $result['area'] === '山梨県' ? 'selected' : '' ?>>山梨県</option>
                        <option value="長野県" <?= $result['area'] === '長野県' ? 'selected' : '' ?>>長野県</option>
                        <option value="岐阜県" <?= $result['area'] === '岐阜県' ? 'selected' : '' ?>>岐阜県</option>
                        <option value="静岡県" <?= $result['area'] === '静岡県' ? 'selected' : '' ?>>静岡県</option>
                        <option value="愛知県" <?= $result['area'] === '愛知県' ? 'selected' : '' ?>>愛知県</option>
                        <option value="三重県" <?= $result['area'] === '三重県' ? 'selected' : '' ?>>三重県</option>
                        <option value="滋賀県" <?= $result['area'] === '滋賀県' ? 'selected' : '' ?>>滋賀県</option>
                        <option value="京都府" <?= $result['area'] === '京都府' ? 'selected' : '' ?>>京都府</option>
                        <option value="大阪府" <?= $result['area'] === '大阪府' ? 'selected' : '' ?>>大阪府</option>
                        <option value="兵庫県" <?= $result['area'] === '兵庫県' ? 'selected' : '' ?>>兵庫県</option>
                        <option value="奈良県" <?= $result['area'] === '奈良県' ? 'selected' : '' ?>>奈良県</option>
                        <option value="和歌山県" <?= $result['area'] === '和歌山県' ? 'selected' : '' ?>>和歌山県</option>
                        <option value="鳥取県" <?= $result['area'] === '鳥取県' ? 'selected' : '' ?>>鳥取県</option>
                        <option value="島根県" <?= $result['area'] === '島根県' ? 'selected' : '' ?>>島根県</option>
                        <option value="岡山県" <?= $result['area'] === '岡山県' ? 'selected' : '' ?>>岡山県</option>
                        <option value="広島県" <?= $result['area'] === '広島県' ? 'selected' : '' ?>>広島県</option>
                        <option value="山口県" <?= $result['area'] === '山口県' ? 'selected' : '' ?>>山口県</option>
                        <option value="徳島県" <?= $result['area'] === '徳島県' ? 'selected' : '' ?>>徳島県</option>
                        <option value="香川県" <?= $result['area'] === '香川県' ? 'selected' : '' ?>>香川県</option>
                        <option value="愛媛県" <?= $result['area'] === '愛媛県' ? 'selected' : '' ?>>愛媛県</option>
                        <option value="高知県" <?= $result['area'] === '高知県' ? 'selected' : '' ?>>高知県</option>
                        <option value="福岡県" <?= $result['area'] === '福岡県' ? 'selected' : '' ?>>福岡県</option>
                        <option value="佐賀県" <?= $result['area'] === '佐賀県' ? 'selected' : '' ?>>佐賀県</option>
                        <option value="長崎県" <?= $result['area'] === '長崎県' ? 'selected' : '' ?>>長崎県</option>
                        <option value="熊本県" <?= $result['area'] === '熊本県' ? 'selected' : '' ?>>熊本県</option>
                        <option value="大分県" <?= $result['area'] === '大分県' ? 'selected' : '' ?>>大分県</option>
                        <option value="宮崎県" <?= $result['area'] === '宮崎県' ? 'selected' : '' ?>>宮崎県</option>
                        <option value="鹿児島県" <?= $result['area'] === '鹿児島県' ? 'selected' : '' ?>>鹿児島県</option>
                        <option value="沖縄県" <?= $result['area'] === '沖縄県' ? 'selected' : '' ?>>沖縄県</option>
                        </select>
                    </div>
                    <div class="condition-page">
                    <li>体調不良を感じることはありますか？</li>
                        <label><input type="radio" name="agree" value="はい" <?= $result['agree'] === 'はい' ? 'checked' : '' ?>>はい</label><br>
                        <label><input type="radio" name="agree" value="いいえ" <?= $result['agree'] === 'いいえ' ? 'checked' : '' ?>>いいえ</label><br>
                        <li>気になる症状に全てチェックを入れてください（複数回答可 最大６つまで）</li>
                        <label><input type="checkbox" name="condition[]" value="イライラする・怒りっぽい" <?= in_array('イライラする・怒りっぽい', $conditions) ? 'checked' : '' ?>>イライラする・怒りっぽい</label><br>
                        <label><input type="checkbox" name="condition[]" value="ぼーっとする・集中できない" <?= in_array('ぼーっとする・集中できない', $conditions) ? 'checked' : '' ?>>ぼーっとする・集中できない</label><br>
                        <label><input type="checkbox" name="condition[]" value="情緒不安定" <?= in_array('情緒不安定', $conditions) ? 'checked' : '' ?>>情緒不安定</input><br>
                        <label><input type="checkbox" name="condition[]" value="頭痛・頭が重い" <?= in_array('頭痛・頭が重い', $conditions) ? 'checked' : '' ?>>頭痛・頭が重い</label><br>
                        <label><input type="checkbox" name="condition[]" value="倦怠感" <?= in_array('倦怠感', $conditions) ? 'checked' : '' ?>>倦怠感</label><br>
                        <label><input type="checkbox" name="condition[]" value="動悸・息切れ" <?= in_array('動悸・息切れ', $conditions) ? 'checked' : '' ?>>動悸・息切れ</label><br>
                        <label><input type="checkbox" name="condition[]" value="立ちくらみ・めまい・ふらつき" <?= in_array('立ちくらみ・めまい・ふらつき', $conditions) ? 'checked' : '' ?>>立ちくらみ・めまい・ふらつき</label><br>
                        <label><input type="checkbox" name="condition[]" value="皮膚や目が乾燥しやすい" <?= in_array('皮膚や目が乾燥しやすい', $conditions) ? 'checked' : '' ?>>皮膚や目が乾燥しやすい</label><br>
                        <label><input type="checkbox" name="condition[]" value="肩こり・腰痛・関節痛" <?= in_array('肩こり・腰痛・関節痛', $conditions) ? 'checked' : '' ?>>肩こり・腰痛・関節痛</label><br>
                        <label><input type="checkbox" name="condition[]" value="むくみ" <?= in_array('むくみ', $conditions) ? 'checked' : '' ?>>むくみ</label><br>
                        <label><input type="checkbox" name="condition[]" value="朝起きられない" <?= in_array('朝起きられない', $conditions) ? 'checked' : '' ?>>朝起きられない</label><br>
                        <label><input type="checkbox" name="condition[]" value="寝つきが悪い" <?= in_array('寝つきが悪い', $conditions) ? 'checked' : '' ?>>寝つきが悪い</label><br>
                        <label><input type="checkbox" name="condition[]" value="やる気が出ない" <?= in_array('やる気が出ない', $conditions) ? 'checked' : '' ?>>やる気が出ない</label><br>
                        <label><input type="checkbox" name="condition[]" value="生理前に調子が悪い" <?= in_array('生理前に調子が悪い', $conditions) ? 'checked' : '' ?>>生理前に調子が悪い</label><br>
                        <label><input type="checkbox" name="condition[]" value="生理痛が重い" <?= in_array('生理痛が重い', $conditions) ? 'checked' : '' ?>>生理痛が重い</label><br>
                        <label><input type="checkbox" name="condition[]" value="生理周期の乱れ" <?= in_array('生理周期の乱れ', $conditions) ? 'checked' : '' ?>>生理周期の乱れ</label><br>
                        <label><input type="checkbox" name="condition[]" value="腹痛" <?= in_array('腹痛', $conditions) ? 'checked' : '' ?>>腹痛</label><br>
                        <label><input type="checkbox" name="condition[]" value="肌荒れ・ニキビ" <?= in_array('肌荒れ・ニキビ', $conditions) ? 'checked' : '' ?>>肌荒れ・ニキビ</label><br>
                        <label><input type="checkbox" name="condition[]" value="過食" <?= in_array('過食', $conditions) ? 'checked' : '' ?>>過食</label><br>
                        <label><input type="checkbox" name="condition[]" value="食欲不振" <?= in_array('食欲不振', $conditions) ? 'checked' : '' ?>>食欲不振</label><br>
                        <label><input type="checkbox" name="condition[]" value="この中にはない" <?= in_array('この中にはない', $conditions) ? 'checked' : '' ?>>この中にはない</label><br>
                    </div>
                </ol>
            </div>
           
            <button id="submit-button" type="submit">更新して次のページへ</button>
        </form>
    </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>