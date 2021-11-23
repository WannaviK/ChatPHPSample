<?php
    session_start();
    //クロスサイトリクエストフォージェリ(CSRF)対策
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $token = $_SESSION['token'];
    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');
    $username = $_SESSION["name"];
    if(isset($_SESSION["id"])) {
        $msg = "こんにちは" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "さん";
        $link = '<a href="m6-2_logout.php">ログアウト</a>';
    } else {
        $msg = "ログインしていません";
        $link = '<a href="m6-1_login_form.php">ログイン</a>';
    }
    ?>
    
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="m6-2style.css">
</head>
<body>
    <aside>
        <p><?php echo $msg; ?></p>
        <nav>
            <ul>
                <li><a href="">ホーム</a></li>
                <li><a href="">Community</a></li>
                <li><a href="">チャット</a></li>
                <li><a href="">検索</a></li>
                <li><a href="">設定</a></li>
            </ul>
        </nav>
        <div>
            side footer
            <p><?php echo $link; ?></p>
        </div>
    </aside>
    <main>
        Main
    </main>

    <footer>
        Footer
    </footer>
</body>
</html>