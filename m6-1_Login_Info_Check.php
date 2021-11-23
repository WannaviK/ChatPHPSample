<?php
    $dsn = 'mysql:dbname=tb230282db;host=localhost';
    $user = 'tb-230282';
    $password = 'HdLbwzKL6t';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = 'SHOW TABLES';
    $result = $pdo -> query($sql);
    foreach ($result as $row) {
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
    $sql = 'SELECT * FROM User_Info';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //
        echo $row['user_id'].',';
        echo $row['user_name'].',';
        echo $row['user_adderss'].',';
        echo $row['user_password'].',';
    echo "<hr>";
    }
    ?>