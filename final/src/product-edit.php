<?php require 'header.php';?>
<?php require 'db-connect.php';?>
    <link rel="stylesheet" type="text/css" href="css/edit-delete.css">
    <h1>youtuber情報編集</h1>
    <hr>
<?php
$pdo = new PDO($connect, USER, PASS);

if (isset($_POST['upload'])) {
    // 古い画像のファイル名を取得
    $oldImageSql = "SELECT image FROM youtuber_inf WHERE id = :id";
    $oldImageStmt = $pdo->prepare($oldImageSql);
    $oldImageStmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $oldImageStmt->execute();
    $oldImageResult = $oldImageStmt->fetch(PDO::FETCH_ASSOC);
    
    // 新しい画像のアップロード処理
    $image = uniqid(mt_rand(), true);
    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
    $file = "images/$image";

    if (!empty($_FILES['image']['name'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);

        // 古い画像が存在する場合は削除
        if (!empty($oldImageResult['image'])) {
            $oldImagePath = './images/' . $oldImageResult['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // 更新クエリ
        $updateSql = "UPDATE youtuber_inf SET image = :image WHERE id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindValue(':image', $image, PDO::PARAM_STR);
        $updateStmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        
        if (exif_imagetype($file)) {
            $message = '画像をアップロードしました';
            $updateStmt->execute();
        } else {
            $message = '画像ファイルではありません';
        }
    }
    
    //データ更新
    $sql=$pdo->prepare('update youtuber_inf set name=?, subscriber=?, explanation=? where id=?');
    $sql->execute([
        $_POST['name'], $_POST['subscriber'],
        $_POST['explanation'], $_GET['id']]);
    echo 'データ更新しました。';
}
    //データ表示
    echo '<form method="post" enctype="multipart/form-data">';
        $sql = $pdo->prepare('SELECT * FROM youtuber_inf WHERE id = ?');
        $sql->execute([$_GET['id']]);
        foreach ($sql as $row) {
            echo '<input type="text" id="name" name="name" value="',$row['name'],'" required>';

            echo '<p><img alt="image" src="images/', $row['image'], '"></p>';
            echo '<p>アップロード画像</p>';
            echo '<input type="file" name="image">';

            echo '<p>登録者数（万人）</p><input type="text" id="subscriber" name="subscriber" value="',$row['subscriber'],'" required>';
            echo '<p>詳細</p><br>
                <input type="text" id="explanation" name="explanation" value="',$row['explanation'],'">';
        }
    echo '<input type="submit" name="upload" value="更新">';
    echo '</form>';
?>
    <a href="product.php">TOPへ</a>
<?php require 'footer.php'; ?>
