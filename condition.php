<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>体調に関するアンケート</title>
</head>

<body>
    <h1>体調に関するアンケート</h1>
   
    <div class="container">
        <p>下記の質問にお答えください</p>
        <form id="survey-form2" method="post" action="write.php">
            <div class="survey">

                <?php
                require_once('funcs.php');
                $pdo = db_conn();

                $gender = $_POST['gender'];
                $generation = $_POST['generation'];
                $area = $_POST['area'];
                ?>

                <!-- 性別と年代を表示 -->
                <p>性別：<?= h($gender) ?></p>
                <p>年代：<?= h($generation) ?></p>
                <p>居住地：<?= h($area) ?></p>

                <!-- hidden フィールドで性別と年代を保持 -->
                <input type="hidden" name="gender" value="<?= h($gender) ?>">
                <input type="hidden" name="generation" value="<?= h($generation) ?>">
                <input type="hidden" name="area" value="<?= h($area) ?>">
                
                <ol start="4">
                    <!-- 複数回答できるように -->
                    <li>体調不良を感じることはありますか？</li>
                        <label><input type="radio" name="agree" value="はい">はい</label><br>
                        <label><input type="radio" name="agree" value="いいえ">いいえ</label><br>
                    <li>気になる症状に全てチェックを入れてください（複数回答可 最大６つまで）</li>
                        <label><input type="checkbox" name="condition[]" value="イライラする・怒りっぽい">イライラする・怒りっぽい</label><br>
                        <label><input type="checkbox" name="condition[]" value="ぼーっとする・集中できない">ぼーっとする・集中できない</label><br>
                        <label><input type="checkbox" name="condition[]" value="情緒不安定">情緒不安定</input><br>
                        <label><input type="checkbox" name="condition[]" value="頭痛・頭が重い">頭痛・頭が重い</label><br>
                        <label><input type="checkbox" name="condition[]" value="倦怠感">倦怠感</label><br>
                        <label><input type="checkbox" name="condition[]" value="動悸・息切れ">動悸・息切れ</label><br>
                        <label><input type="checkbox" name="condition[]" value="立ちくらみ・めまい・ふらつき">立ちくらみ・めまい・ふらつき</label><br>
                        <label><input type="checkbox" name="condition[]" value="皮膚や目が乾燥しやすい">皮膚や目が乾燥しやすい</label><br>
                        <label><input type="checkbox" name="condition[]" value="肩こり・腰痛・関節痛">肩こり・腰痛・関節痛</label><br>
                        <label><input type="checkbox" name="condition[]" value="むくみ">むくみ</label><br>
                        <label><input type="checkbox" name="condition[]" value="朝起きられない">朝起きられない</label><br>
                        <label><input type="checkbox" name="condition[]" value="寝つきが悪い">寝つきが悪い</label><br>
                        <label><input type="checkbox" name="condition[]" value="やる気が出ない">やる気が出ない</label><br>
                        <label><input type="checkbox" name="condition[]" value="生理前に調子が悪い">生理前に調子が悪い</label><br>
                        <label><input type="checkbox" name="condition[]" value="生理痛が重い">生理痛が重い</label><br>
                        <label><input type="checkbox" name="condition[]" value="生理周期の乱れ">生理周期の乱れ</label><br>
                        <label><input type="checkbox" name="condition[]" value="腹痛">腹痛</label><br>
                        <label><input type="checkbox" name="condition[]" value="肌荒れ・ニキビ">肌荒れ・ニキビ</label><br>
                        <label><input type="checkbox" name="condition[]" value="過食">過食</label><br>
                        <label><input type="checkbox" name="condition[]" value="食欲不振">食欲不振</label><br>
                        <label><input type="checkbox" name="condition[]" value="この中にはない">この中にはない</label><br>
                </ol>
            </div>
            <button id="submit-button" type="submit">送信</button>
        </form>
    </div>
        <div class="button-box">
            <button type="button" onclick="history.back()">前のページへ戻る</button>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
    // チェックボックスの変更を確認する
        $('input[type="checkbox"]').on('change', function() {
        // チェックされたチェックボックスの数をカウントする
        let checkedCount = $('input[type="checkbox"]:checked').length;

        // 最大6個まで許可
        if (checkedCount > 6) {
            // チェックを外す
            $(this).prop('checked', false);
            // アラートを表示
            alert("最大６つまでです");
        }
        });
    });

    $(document).ready(function () {
        $('#submit-button').on('click', function (e) {
            // "agree"ラジオボタンの選択確認
            const agreeSelected = $('input[name="agree"]:checked').val();

            if (!agreeSelected) { // 未選択の場合
                alert('「体調不良を感じることはありますか？」を選択してください。');
                e.preventDefault(); // フォーム送信をキャンセル
                return; // 他のチェックをスキップ
            }

            const selectedConditions = $('input[name="condition[]"]:checked')
                .map(function () {
                    return $(this).val();
                })
                .get();

            if (selectedConditions.length === 0) {
                alert('気になる症状はありませんか？');
                e.preventDefault(); // フォーム送信をキャンセル
            } else {
                const confirmMessage = `以下の内容で送信しますか？\n症状: ${selectedConditions.join(', ')}`;
                if (!confirm(confirmMessage)) {
                    e.preventDefault(); // フォーム送信をキャンセル
                }
            }
        });
    });
    </script>

</body>
</html>
