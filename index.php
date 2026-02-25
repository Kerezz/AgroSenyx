<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | AgroSenyx</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <h2 style="color:var(--primary);">Login - AgroSenyx</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Lozinka" required>
            <button type="submit">Prijavi se</button>
        </form>
        <p style="margin-top: 20px;">Nemaš nalog? <a href="register.php" style="color:var(--primary); font-weight:bold; text-decoration:none;">Registruj se</a></p>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = $_POST["password"];
            $sql = "SELECT * FROM users WHERE email='$email'";
            $res = mysqli_query($conn, $sql);
            $u = mysqli_fetch_assoc($res);
            if ($u && password_verify($password, $u["password"])) {
                $_SESSION["user_id"] = $u["id"];
                $_SESSION["username"] = $u["username"];
                header("Location: dashboard.php");
            } else { echo "<p style='color:red; margin-top:10px;'>Pogrešni podaci</p>"; }
        }
        ?>
    </div>
</body>
</html>