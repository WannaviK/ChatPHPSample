<?php
    if(isset($_POST["pre_submit"])) {
        $error = 0;
        if (empty($_POST["pre_address"])) {
            $errors = "メールアドレスが未入力です。";
            $error = +1;
        } else {
            $pre_address = $_POST["pre_address"];
            
            if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$pre_address)) {
                $errors = "メールアドレスの形式が正しくありません";
                $error += 1;
            }
        }
        $dsn = "mysql:dbname=tb230282db;host=localhost";
        $user = "tb-230282";
        $password = "HdLbwzKL6t";
        $pdo = new PDO($dsn,$user,$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "SELECT user_id FROM Login_Info WHERE user_address = :user_address";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindValue(':user_address', $pre_address, PDO::PARAM_STR);
        $stmt -> execute();
        $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        if(isset($result["user_id"])) {
            $errors = "このメールアドレスは既に利用されております";
            $error += 1;
        }
        if(!isset($errors) &&  $error == 0) {
            $sql = "INSERT INTO pre (pre_address) VALUES (:pre_address)";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindValue(":pre_address", $pre_address, PDO::PARAM_STR);
            $stmt -> execute();
            
            require 'phpmailer/src/Exception.php';
            require 'phpmailer/src/PHPMailer.php';
            require 'phpmailer/src/SMTP.php';
            require 'phpmailer/setting.php';

            // PHPMailerのインスタンス生成
            $url = 'https://tech-base.net/tb-230282/mission6/m6-2_signup.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
            $mail->SMTPAuth = true;
            $mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
            $mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
            $mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
            $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
            $mail->Port = SMTP_PORT; // 接続するTCPポート

            // メール内容設定
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
            $mail->addAddress($pre_address,"ゲストさん"); //受信者（送信先）を追加する
            //    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
            //    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
            //    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
            $mail->Subject = MAIL_SUBJECT; // メールタイトル
            $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
            $body = 'Funityに登録ありがとうございます!<br>こちらのURLから登録お願いします<br>' . $url;

            $mail->Body  = $body; // メール本文
            // メール送信の実行
            if(!$mail->send()) {
    	        echo 'メッセージは送られませんでした！';
    	        echo 'Mailer Error: ' . $mail->ErrorInfo;
            } 

            
        }
    }
    ?>
        <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <h1>仮会員登録画面</h1>
    <?php if (isset($_POST['pre_submit']) && $error == 0 && empty($errors): ?>
        <!-- 登録完了画面 -->
        <p>メールを送信いたしました。24時間以内にメールに記載されたURLからご登録下さい。</p>
        <p>↓TEST用(後ほど削除):このURLが記載されたメールが届きます。</p>
        <a href = "https://tech-base.net/tb-230282/mission6/m6-2.php">https://tech-base.net/tb-230282/mission6/m6-2.php</a>
        <?php else: ?>
    <!--登録画面-->
    <?php 
        if(isset($errors)) {
            echo $errors;
        }
    ?>
    <form action = "" method = "post">
        <p>メールアドレス:<input type = "text" name = "pre_address" size = "50" value = "<?php if(!empty($_POST['pre_address'])){echo $_POST['pre_address'];}?>"></p>
        <input type = "submit" name = "pre_submit" value = "送信">
    </form>
    </body>
</html>
<?php endif ?>    