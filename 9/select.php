<?php
/************************************************************
 *  ログイン認証OKの場合表示
 ************************************************************/
//1. SESSION開始
session_start();
include("func.php");

//2. セッションチェック(前ページのSESSION＿IDと現在のsession_idを比較)
sessionCheck();

//★SESSION IDを確認したい場合(検証→Resources→Cookies)
//echo session_id();


//セッションハイジャック対策（追加してください！）

//2. 認証後にSetされたSESSION変数を受け取り表示
$name = "名前： " . $_SESSION["name"] . "";

//3. 管理者FLGを表示
loginRollSet();
if($_SESSION["kanri_flg"] == 1) {
    $admin = "権限： 管理者";
} else {
    $admin = "権限： 一般";
}



//1.  DB接続します
$pdo = db();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
    $view .= '<tr><th>時刻</th><th>名前</th><th>メール</th><th>権限</th></tr>';
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    //管理FLGで表示を切り分けたりしてみましょう！！！（追加してください！）
    $view .= '<tr><td><a href="detail.php?id='.$result["id"].'">'.$result["indate"].'</a></td><td><a href="detail.php?id='.$result["id"].'">'.$result["name"].'</a></td><td><a href="detail.php?id='.$result["id"].'">'.$result["email"].'</td><td>'.$result[""].'</td></tr>';
  }
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/main.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="index.php">データ登録</a>
        <p>
            <?=$name?>
        </p>
        <p>
            <?=$admin?>
        </p>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
