<?php


// データベース接続
$db = new PDO('mysql:host=localhost;dbname=reservations', 'root', '');


// 予約フォーム処理
if (isset($_POST['submit'])) {
  // ユーザー入力
  $name = $_POST['name'];
  $email = $_POST['email'];
  $date = $_POST['date'];
  $time = $_POST['time'];


  // データベースへの保存
  $sql = "INSERT INTO reservations (name, email, date, time) VALUES (?, ?, ?, ?)";
  $stmt = $db->prepare($sql);
  $stmt->execute([$name, $email, $date, $time]);


  // 予約確認メール送信
  $message = "予約が完了しました。\n\n";
  $message .= "氏名: $name\n";
  $message .= "メールアドレス: $email\n";
  $message .= "予約日: $date\n";
  $message .= "予約時間: $time\n";
  mail($email, "予約確認", $message);


  // 予約完了ページへリダイレクト
  header('Location: complete.php');
}


// 予約カレンダー表示
$sql = "SELECT * FROM reservations";
$stmt = $db->query($sql);
$reservations = $stmt->fetchAll();


?>