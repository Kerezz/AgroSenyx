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

                    $new_user_id = mysqli_insert_id($conn);

                    // Dodavanje parcela
                    mysqli_query($conn, "
                        INSERT INTO fields (user_id, field_name) 
                        VALUES 
                        ('$new_user_id', 'Ravnica'),
                        ('$new_user_id', 'Dolina')
                    ");

                    // Uzimamo ID parcela koje smo upravo dodali
                    $field_ids = mysqli_query($conn, "
                        SELECT id FROM fields 
                        WHERE user_id='$new_user_id'
                        ORDER BY id ASC
                        LIMIT 2
                    ");

                    $ids = [];
                    while($row = mysqli_fetch_assoc($field_ids)){
                        $ids[] = $row['id'];
                    }

                    // Demo senzorski podaci za obe parcele
                    mysqli_query($conn, "
                        INSERT INTO sensors 
                        (field_id, soil_moisture, soil_temp, ph_value, ec_value, air_humidity, rainfall, last_updated)
                        VALUES
                        ('$ids[0]', 43.2, 18.5, 6.8, 1.2, 60, 0, NOW()),
                        ('$ids[1]', 31.5, 19.2, 6.7, 1.3, 60, 0, NOW())
                    ");

                    echo "<p style='color:green; margin-top: 15px;'>Uspeh! <a href='index.php'>Prijavi se</a></p>";
                }
            }
        }
        ?>
        <p style="margin-top: 20px;">Već imaš nalog? <a href="index.php" style="color: var(--primary); font-weight: bold; text-decoration:none;">Prijavi se</a></p>
    </div>
</body>
</html>