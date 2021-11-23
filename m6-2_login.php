<?php
    session_start();
    //クロスサイトリクエストフォージェリ(CSRF)対策
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];
    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');
    //データベース情報
    $dsn = "mysql:dbname=tb230282db;host=localhost";
    $user = "tb-230282";
    $password = "HdLbwzKL6t";
    //エラーメッセージの初期化
    $errors = array();
    //データベース接続
    $pdo = new PDO($dsn,$user,$password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    $address = $_POST["address"];
    $sql = "SELECT * FROM User_Info WHERE user_address=:user_address";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue("user_address", $address, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();
    //指定したハッシュがパスワードにマッチしているかチェック
    if (password_verify($_POST["password"], $user["user_password"])) {
        //データベースのユーザー情報をセッションに保存
        $_SESSION["id"] = $user["user_id"];
        $_SESSION["name"] = $user["user_name"];
         //本登録完了メール送信
        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';
        require 'phpmailer/setting.php';

        // PHPMailerのインスタンス生成
        $name = $_SESSION["name"];
        $address = $_POST["address"];
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
        $mail->addAddress($address, $name . "さん"); //受信者（送信先）を追加する
        //    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
        //    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
        //    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
        $mail->Subject = MAIL_SUBJECT; // メールタイトル
        $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
        $body = "ログインされました<br>身に覚えのないログインの場合、こちらのメールに返信をお願い致します。";
        $mail->Body  = $body; // メール本文
        // メール送信の実行
        if(!$mail->send()) {
            echo 'メッセージは送られませんでした！';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        header("Location: m6-2_home_page.php");
        exit();
    } else {
        $msg = "メールアドレスもしくはパスワードが間違っています。";
        $link = '<a href="m6-1_login_form.php">戻る</a>';
    }
    ?>
    
    
    <h1><?php echo $msg; ?></h1>
    <?php echo $link; ?>