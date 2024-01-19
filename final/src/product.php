<?php require 'header.php';?>
<?php require 'db-connect.php';?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<h1>YoutuberPedia</h1>
<?php
$pdo=new PDO($connect,USER,PASS);
        //カテゴリ機能
        echo 'カテゴリ';
        echo '<form action="product.php" method="post">';
        $sql2=$pdo->query('select * from youtuber_ct');
        echo '<select id="category" name="category_select" required>';
        echo '<option value="0">全表示</option>';
        foreach($sql2 as $row){
            $selected = ($_POST['category_select'] == $row['ct_id']) ? 'selected' : '';
            echo '<option value="',$row['ct_id'],'" ',$selected,'>',$row['ct_name'],'</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="検索">';
        echo '</form>';
        //新規登録url
        echo '<a href="channel-input.php">チャンネル追加</a>';
        echo '<hr>';

    if (isset($_POST['category_select']) && $_POST['category_select'] !=0){
        $sql=$pdo->prepare('select * from youtuber_inf where ct_id=? order by subscriber DESC');
        $sql->execute([$_POST['category_select']]);
    }else{
        $sql=$pdo->query('select * from youtuber_inf order by subscriber DESC');
    }

    echo '<table>';
    echo '<tr><th></th><th></th><th>チャンネル名</th><th>登録者数（万人）</th></tr>';
    $rank=1;
    foreach($sql as $row){
        echo '<tr>';
        echo '<td>', $rank, '</td>';
        echo '<td><a href="detail.php?id=', $row['id'],'"><img alt="image" src="images/',$row['image'],'"></a></td>';
        echo '<td>';
        echo '<a href="detail.php?id=', $row['id'],'">',$row['name'],'</a>';
        echo '</td>';
        echo '<td>', $row['subscriber'], '</td>';
        echo '</tr>';
        $rank=$rank+1;
    }
echo '</table>';
?>
<?php require 'footer.php'; ?>