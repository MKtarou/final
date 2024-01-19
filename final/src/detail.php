<?php require 'header.php';?>
<?php require 'db-connect.php';?>
<link rel="stylesheet" type="text/css" href="css/detail-style.css">
<?php
$pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select * from youtuber_inf where id=?');
    $sql->execute([$_GET['id']]);
    foreach($sql as $row){
        echo '<div class="img">';
        echo '<a href="product-edit.php?id=', $row['id'],'"><img alt="image" src="images/edit.png"></a>';
        echo '<a href="delete.php?id=', $row['id'],'"><img alt="image" src="images/trash.png"></a>';
        echo '</div>';

        echo '<div class="name">';
        echo '<p>', $row['name'],'</p>';
        echo '</div>';

        echo '<div class="icon">';
        echo '<p><img alt="image" src="images/',$row['image'],'"></p>';
        echo '</div>';
        echo '登録者数：',$row['subscriber'],'万人<br>
             詳細<br>',
             $row['explanation'],'</p>';

}
?>
    <div class="button">
    <a href="product.php">戻る</a>
    </div>
<?php require 'footer.php'; ?>