<?php

//1.GETでidを取得
  $id = htmlspecialchars($_GET['id']);

//2.DB接続など
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', 'root');

//3.SELECT * FROM gs_an_table WHERE id=***; を取得（bindValueを使用！）
  $stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id=:id");
  $stmt->bindValue(':id', $id);
  $status = $stmt->execute();

  //４．データ登録処理後
    $name = "";
    $email = "";
    $comment = "";
    $date = "";
  if($status==false){
    //Errorの場合$status=falseとなり、エラー表示
    echo "SQLエラー";
    exit;
    
  }else{
      while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
          $name     = $result['name'];
          $email    = $result['email'];
          $comment  = $result['naiyou'];
          $date     = $result['indate'];
      }


  }
//4.select.phpと同じようにデータを取得（以下はイチ例）
// while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
//    $name = $result["name"];
//    $email = $result["name"];
//  }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid back"><a href="select.php">＜＜ 戻る</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container container-back">
<form method="post" action="update.php">
   <fieldset>
    <legend><?php echo $date ?></legend>
     <label>名前：<input type="text" name="name" value='<?php echo $name ?>'></label><br>
     <label>Email：<input type="text" name="email" value='<?php echo $email ?>'></label><br>
     <label><textArea name="naiyou" rows="4" cols="40"><?php echo $comment ?></textArea></label><br>
     <input type="hidden" name="id" value='<?php echo $id ?>'>
     <input type="submit" value="更新">
    </fieldset>
</form>
<form method="post" action="delete.php">
 <input type="hidden" name="id" value='<?php echo $id ?>'>
 <input type="submit" value="削除">
</form>
</div>

<!-- Main[End] -->


</body>
</html>






