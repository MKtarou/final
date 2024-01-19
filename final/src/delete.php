<?php require 'header.php';?>
<?php require 'db-connect.php';?>
    <link rel="stylesheet" type="text/css" href="css/edit-delete.css">
    <h1>youtuber情報削除</h1>
    <hr>
<?php
    $pdo=new PDO($connect,USER,PASS);
    if(isset($_POST['id'])){
        $sql=$pdo->prepare('delete from youtuber_inf where id=?');
        $sql->execute([$_POST['id']]);
        echo '削除しました';
    }else{
        echo 'こちらの情報を削除してもよろしいですか？';
    //youtuber情報
    $sql=$pdo->prepare('select * from youtuber_inf where id=?');
    $sql->execute([$_GET['id']]);
    foreach($sql as $row){
        echo '<tr>';
        echo '<td><p><img alt="image" src="images/',$row['image'],'"></td>';
        echo '<td><br>チャンネル名：', $row['name'], '</td><br>';
        echo '<td>登録者数：', $row['subscriber'], '</td>';
        echo '</tr>';
    }
    echo '<form method="post">';
        echo '<input type="hidden" name="id" value="',$_GET['id'],'">';
        echo '<input type="submit" name="delete" value="削除">';
    echo '</form>';
    }
    echo '<a href="product.php">TOPへ</a>';
?>
<?php require 'footer.php';?>
