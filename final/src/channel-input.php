<?php require 'header.php';?>
<?php require 'db-connect.php';?>
    <h1>youtuber登録</h1>
    <hr>
<?php
    $pdo=new PDO($connect,USER,PASS);
    //登録フォーム表示
    echo '<form method="post" action="channel-output.php" enctype="multipart/form-data">';
        echo '<p>チャンネル名</p>';
        echo '<input type="text" id="name" name="name" value="" required>';

        echo '<p>チャンネル画像</p>';
        echo '<input type="file" name="image" required">';

        echo '<p>カテゴリ</p>';
        $sql2=$pdo->query('select * from youtuber_ct');
        echo '<select id="category" name="category_select" required>';
        foreach($sql2 as $row){
            echo '<option value="',$row['ct_id'],'">',$row['ct_name'],'</option>';
        }
        echo '</select>';

        echo '<p>登録者数（万人）</p>';
        echo '<input type="text" id="subscriber" name="subscriber" value="" required>';

        echo '<p>詳細</p>';
        echo '<input type="text" id="explanation" name="explanation" value="" >';
    echo '<input type="submit" name="upload" value="登録">';
    echo '</form>';
?>
    <a href="product.php">TOPへ</a>
<?php require 'footer.php'; ?>
