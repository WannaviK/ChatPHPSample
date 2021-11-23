<!DOCTYPE html>
<html lang="ja">

    <head>
      <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
        <meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>Funity!</title>

    </head>

    <body>


    <!-- 見出し 第１レベル -->
    <!--（氏名）の公開を避ける場合はイニシャルやニックネームでOK-->
    <h1 class="midashi_1">Funity! </h1>

    <hr>

    <!-- 見出し 第２レベル ・以下、h2レベルで項目を色々書いていきましょう -->
    <!-- 自己紹介で言いたい項目を見出しにいれて、文章をつくりましょう。項目名は編集OK。項目を足してもOK。 -->
    <h2>Funityとは</h2>
    　Fun(趣味、楽しみ) + Community(共同体)<br>
    　Funityは、同じFun(趣味、楽しみ)を持った人々同士でCommunity(共同体)を作って、運営していき同じFunを持つ人のつながりを深めFunをもっと楽しむためのオンラインサークルです!<br>
    　Funで繋がり楽しみを倍増させよう！<br>

    <hr>

    <!-- 以下は投稿フォーム欄ですが、今は＆このままでは機能しておらずエラーが発生します。 -->
    <!-- したがって今はコピペするだけでOKです。スタートアップ以降のPHPミッションを進める際に、参考にしてください。 -->
    <h3>登録はこちら！</h3>
    <form method="POST" action="m6-1_signup_mail.php">
        <input type="submit" name="submit" value="仮登録画面へ!">
    </form>
    
    <h4>ログインはこちら</h4>
    <form method = "POST" action = "m6-1_login_form.php">
        <input type = "submit" name = "login" value = "ログイン">
    </form>

    </body>
    </html>