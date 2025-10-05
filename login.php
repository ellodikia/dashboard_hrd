<?php

session_start();
include 'koneksi.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1){
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];

    if ($row ['level'] == "hrd"){
        header ("Location: index.php");
    } elseif ($row ['level'] == "karyawan"){
        header ("Location: index_karyawan.php");
    } else {
        $error = "Level tidak dikenali";
    }
    exit();
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="login">
    <h2>Login</h2>
    <form action="" method="post">
        <label for="">Username</label>
        <input type="text" name="username" required> <br><br>
        <label for="">Password</label>
        <input type="password" name="password" required>
        <input type="submit" value="Login">

    </form>
    </div>
</body>
</html>