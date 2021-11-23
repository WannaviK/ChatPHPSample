<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    ?>
    
    <p>ログアウトしました。</p>
    <a href="m6-1_login_form.php">ログイン</a>