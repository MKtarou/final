<?php require 'header.php';?>
<?php require 'db-connect.php';?>
<?php
$pdo = new PDO($connect, USER, PASS);
if (isset($_POST['upload'])) {
    // 新しい画像のアップロード処理
    if (!empty($_FILES['image']['name'])) {
        $image = uniqid(mt_rand(), true);
        $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
        $file = "images/$image";

        move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);

        // 登録クエリ
        $insertSql = "INSERT INTO youtuber_inf (name, subscriber, explanation,ct_id, image) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->execute([
            $_POST['name'], $_POST['subscriber'],
            $_POST['explanation'],$_POST['category_select'],$image
        ]);

        if (exif_imagetype("images/$image")) {
            $message = '画像をアップロードしました';
        } else {
            $message = '画像ファイルではありません';
        }
    } else {
        // 画像がアップロードされなかった場合の処理を追加するか、エラーメッセージを表示するなどの対応が必要です。
        $message = '画像がアップロードされていません';
    }
}
?>
    <p>登録しました。</p>
    <a href="product.php">TOPへ</a>
<?php require 'footer.php'; ?>
