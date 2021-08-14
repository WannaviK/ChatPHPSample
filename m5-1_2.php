<?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS Chat_Space2"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date datetime,"
    . "copassword TEXT,"
    . "del_flag INT"
    .");";
    $stmt = $pdo->query($sql);
    $sql = 'SHOW TABLES';
    $result = $pdo -> query($sql);
    foreach ($result as $row) {
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
    if (isset($_POST["submit"]) && empty($_POST["newnumber"])) {
        $sql = $pdo -> prepare("INSERT INTO Chat_Space2 (name, comment, date, copassword, del_flag) VALUES (:name, :comment, :date, :copassword, :del_flag)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> bindParam(':copassword', $copassword, PDO::PARAM_STR);
        $sql -> bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date('Y-m-d H:i:s');
        $copassword = $_POST["password"];
        $del_flag = 0;
        $sql -> execute();
    }
    
    if (isset($_POST["buttun"])) {
        $id = $_POST["delete"];
        $delete_password = $_POST["delete_password"];
        $sql = 'SELECT * FROM Chat_Space2 WHERE id = :id';
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $results = $stmt -> fetchAll();
        foreach ($results as $row) {
            if ($row["copassword"] == $delete_password) {
                $del_flag = 1;
                $sql = 'UPDATE  Chat_Space2 SET del_flag = :del_flag  WHERE id = :id';
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                $stmt -> bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
                $stmt -> execute();
                
            } else {
                echo "パスワードが違います";
            }
        }
    }
    
    if(isset($_POST["revival"])) {
        $id = $_POST["restore"];
        $restore_password = $_POST["restore_password"];
        $sql = 'SELECT * FROM Chat_Space2 WHERE id = :id';
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $results = $stmt -> fetchAll();
        foreach($results as $row) {
            if ($row["copassword"] == $restore_password) {
                $del_flag = 0;
                $sql = 'UPDATE  Chat_Space2 SET del_flag = :del_flag  WHERE id = :id';
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                $stmt -> bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
                $stmt -> execute();
            } else {
                echo "パスワードが違います";
            }
        }
    }
    
    if (isset($_POST["compile"])) {
        $edit_password = $_POST["edit_password"];
        $id = $_POST["edit"];
        $sql = 'SELECT * FROM Chat_Space2 WHERE id = :id';
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $results = $stmt -> fetchAll();
        foreach ($results as $row) {
             if ($row['id'] == $id && $row['copassword'] == $edit_password) {
                $newname = $row['name'];
                $newcomment = $row['comment'];
                $newnumber = $row['id'];
                $newpassword = $row['copassword'];
                
                
            }
        }
        
    }
    
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["newnumber"])) {
        $id = $_POST["newnumber"];
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date("Y/m/d H:i:s");
        $copassword = $_POST["password"];
        $sql = 'UPDATE Chat_Space2 SET name = :name, comment = :comment, date = :date, copassword = :copassword WHERE id = :id';
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
        $stmt -> bindParam(':copassword', $copassword, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    ?> 
    
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1_2</title>
</head>
<body>
    <form action="" method="post">
        <p>何でも書き込みOKです！！</p>
        <p>名前</p>
        <input type = "text" name = "name" placeholder = "名前を入力してください" value = "<?php if(!empty($_POST["edit"])) {if (!isset($newname)){ echo "パスワードと数値が一致しません";} else {echo $newname;}} else { echo "";} ?>">
        <p>コメントを入力してください</p> 
        <input type = "text" name = "comment" placeholder = "コメントを入力してください" value = "<?php if(!empty($_POST["edit"])){if (!isset($newcomment)){ echo "パスワードと数値が一致しません";} else {echo $newcomment;}} else {echo "";}?>">
        <p></p>
        <input type = "hidden" name = "newnumber" value = "<?php if(!empty($_POST["edit"])){ echo $newnumber;} else {echo "";}?>">
        <p>パスワード</p>
        <input type = "text" name = "password" placeholder = "パスワードを入力してください" value = "<?php if(!empty($_POST["edit"])){if (!isset($newname)){ echo "パスワードと数値が一致しません";} else { echo $newpassword;}} else { echo "";}?>">
        
        <input type="submit" name="submit" value = "送信">
    </form>
    <form action ="" method = "post">
        <p>削除</p>
        <input type = "text" name = "delete" placeholder = "削除したい投稿番号を入力してください">
        <p>パスワード</p>
        <input type = "text" name = "delete_password" placeholder = "パスワードを入力してください">
        <input type = "submit" name = "buttun" value = "削除">
    </form>
    <form action = "" method = "post">
        <p>編集</p>
        <input type = "text" name = "edit" placeholder = "編集したい投稿番号を入力してください">
        <p>パスワード</p>
        <input type ="text" name = "edit_password" placeholder = "パスワードを入力してください">
        <input type = "submit" name = "compile" value = "編集">
    </form>
    <form action = "" method = "post">
        <p>復元</p>
        <input type = "text" name = "restore" placeholder = "復元したい投稿番号を入力してください">
        <p>パスワード</p>
        <input type = "text" name = "restore_password" placeholder = "パスワードを入力してください">
        <input type = "submit" name = "revival" value = "復元">
    </form>
    <br>
    
    <?php
        $sql = "SELECT * FROM Chat_Space2";
        $stmt = $pdo -> query($sql);
        $results = $stmt -> fetchAll();
        foreach ($results as $row) {
            $data = $row["id"] . "<>" . $row["name"] . "<>" . $row["comment"] . "<>" . $row["date"] . "<>" . $row["copassword"] . "<>" . $row["del_flag"];
            $line = explode("<>",$data);
            if ($line[5] == "0") {
                echo $line[0] . " " . $line[1] . " " . $line[2] . " " . $line[3] . "<br>";
            }
        }
        echo "<hr>";
    ?>
</body>
</html>