<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Registracija | AgroSenyx</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <h2 style="color: var(--primary);">Registracija</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Korisničko ime" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Lozinka" required>
            <button type="submit">Registruj se</button>
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
            if (mysqli_num_rows($check) > 0) {
                echo "<p style='color:red; margin-top: 15px;'>Email je već zauzet.</p>";
            } else {
                $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                if (mysqli_query($conn, $sql)) {
                    echo "<p style='color:green; margin-top: 15px;'>Uspeh! <a href='index.php'>Prijavi se</a></p>";
                }
            }
        }
        ?>
        <p style="margin-top: 20px;">Već imaš nalog? <a href="index.php" style="color: var(--primary); font-weight: bold; text-decoration:none;">Prijavi se</a></p>
    </div>
</body>
</html>