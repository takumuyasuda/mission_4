<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_5-1</title>
    </head>
    
    <body>

    <?php

    //DB接続
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    //テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS table5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
    . "password char(32)"
    ." );";
    $stmt = $pdo->query($sql);

    //レコードの挿入
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass_p"]) && empty($_POST["edit_n"])){
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["pass_p"];

    $sql = "INSERT INTO table5 (name, comment, date, password) VALUES (:name, :comment, now(), :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    }

    //レコードの削除
    if(!empty($_POST["delete"]) && !empty($_POST["pass_d"])){
    $id = $_POST["delete"];
    $password = $_POST["pass_d"];

    $sql = 'delete from table5 where id=:id and password=:password';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    }

    //レコードの更新（編集）
    if(!empty($_POST["edit"]) && !empty($_POST["pass_e"])){
    $id = $_POST["edit"];
    $password = $_POST["pass_e"];
    $sql = 'SELECT * FROM table5 where id=:id and password=:password';
    $stmt = $pdo->prepare($sql);
    $stmt ->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt ->execute();
    $results = $stmt->fetch();
    $editnum = $results['id'];
    $editname = $results['name'];
    $editcomment = $results['comment'];
    $editpass = $results['password'];

    }
    

    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["edit_n"]) && !empty($_POST["pass_p"])){
    $id = $_POST["edit_n"];
    $name = $_POST["name"];
    $comment = $_POST["comment"]; 
    $password = $_POST["pass_p"];
    $sql = 'UPDATE table5 SET name=:name,comment=:comment, password=:password WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    }
    
    ?>

    <form action = "" method = "post">
        <p>
        投稿フォーム
        <input type = "text" name = "name" placeholder = "名前" value = "<?php if(!empty($editname)){ echo $editname; } ?>">
        <input type = "text" name = "comment" placeholder = "コメント" value = "<?php if(!empty($editcomment)){ echo $editcomment; } ?>">
        <input type = "password" name = "pass_p" placeholder = "パスワード" autocomplete="off" value = "<?php if(!empty($editpass)){ echo $editpass; } ?>">
        <input type = "submit" name = "submit">
        </p>
        <p>
        削除フォーム
        <input type = "num" name = "delete" placeholder = "削除対象番号">
        <input type = "password" name = "pass_d" placeholder = "パスワード" autocomplete="off">
        <input type = "submit" name = "submit" value = "削除">
        </p>
        <p> 
        編集フォーム
        <input type = "num" name = "edit" placeholder = "編集対象番号">
        <input type = "password" name = "pass_e" placeholder = "パスワード" autocomplete="off">
        <input type = "submit" name = "submit" value = "編集">
        <input type = "hidden" name = "edit_n" value = "<?php if(!empty($editnum)){ echo $editnum; } ?>">
        </p>
    </form>

    <?php

    //DB接続
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    //レコードの抽出（表示）
    echo "【投稿一覧】<br>";
    $sql = 'SELECT * FROM table5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date']. '<br>';
    echo "<hr>";
    }

    ?>

    </body>

</html>