<?php
//DB接続
function db(){
    //1. 接続します
    try {
      return new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
    } catch (PDOException $e) {
      exit('DbConnectError:'.$e->getMessage());
    }
}

//認証OK時の初期値セット
function loginSessionSet(){

}

//セッションチェック用関数
function sessionCheck(){
    if( !isset($_SESSION["chk_ssid"]) || ($_SESSION["chk_ssid"] != session_id()) ){
        echo "LOGIN ERROR";
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}

//ログイン時のセッションへの情報セット
function loginRollSet(){
    if( $_SESSION["kanri_flg"]==1 ) {
      $admin  =  "<p>権限：管理者</p>";
      $admin .=  '<p><a href="#">管理者メニュー</a></p>';
    }else if( $_SESSION["kanri_flg"]==0 ){
      $admin = "<p>権限：一般</p>";
    }
}

//HTML XSS対策
function htmlEnc($value) {
    return htmlspecialchars($value,ENT_QUOTES);
}

// POSTデータ登録時のチェック
function checkPostData() {
    if(
      !isset($_POST["name"]) || $_POST["name"]=="" ||
      !isset($_POST["email"]) || $_POST["email"]=="" ||
      !isset($_POST["username"]) || $_POST["username"]=="" ||
      !isset($_POST["password"]) || $_POST["password"]=="" ||
      !isset($_POST["naiyou"]) || $_POST["naiyou"]=="" ||
    
    ){
      exit('ParamError');
    }
}


?>
