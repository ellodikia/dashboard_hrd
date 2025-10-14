<?php

session_start();
include 'koneksi.php'; 

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM akun WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1){
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];

        if ($row['level'] == "hrd") {
            header("Location: dashboard_hrd.php");
        } elseif ($row['level'] == "karyawan"){
            header("Location: dashboard_karyawan.php");
        } else {
            $error = "Level tidak dikenali";
        }
        exit();
    } else {
        $error = "Username atau password salah";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
    /* Global Reset dan Font */
    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7f6;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; 
        padding: 20px; 
    }
    
    /* Login Container */
    .login {
        width: 100%;
        max-width: 400px;
        background-color: #ffffff; 
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
        font-weight: 700;
    }
    
    /* Input Fields */
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px 15px; 
        height: auto;
        margin: 8px 0 15px;
        border: 1px solid #ccc; 
        border-radius: 8px; 
        outline: none;
        transition: border-color 0.3s;
    }
    
    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }

    /* Submit Button */
    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        outline: none;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.1s;
    }
    
    input[type="submit"]:hover {
        background-color: #0056b3; 
    }

    input[type="submit"]:active {
        transform: scale(0.99);
    }
    
    p.register {
        text-align: center;
        margin-top: 20px;
        color: #555;
        font-size: 0.9em;
    }

    p.register a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    p.register a:hover {
        text-decoration: underline;
    }
    
    /* Error Message */
    p.error {
        font-weight: 500;
        text-align: center;
        color: #dc3545; 
        background-color: #f8d7da; 
        border: 1px solid #f5c6cb;
        padding: 10px;
        margin-top: 15px;
        border-radius: 8px;
        font-size: 0.9em;
    }
</style>
<body>
    <div class="login">
        <h2>👋 Selamat Datang</h2>
        <form action="" method="post">
            <input type="text" name="username" required placeholder="👤 Username"> <br>
            <input type="password" name="password" required placeholder="🔑 Password"> <br><br>
            <input type="submit" value="Masuk">
        </form>
       <p class="register">Belum punya akun? Silahkan <a href="register.php">Mendaftar di sini</a></p>
                     <?php if($error): ?>
                     <p class="error"><?= $error ?></p>
                     <?php endif; ?>
    </div>
</body>
</html>