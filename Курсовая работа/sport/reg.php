<?php
include "db.php";
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: profile.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $email = $_POST["email"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный формат email";
    } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9_]+$/u", $username)) {
        $error = "Имя пользователя может содержать только буквы, цифры и подчеркивания";
    } elseif (mb_strlen($password) < 8) {
        $error = "Пароль должен содержать не менее 8 символов";
    } elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают";
    } else {
        $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
        $email_check_result = $conn->query($email_check_sql);
        if ($email_check_result->num_rows > 0) {
            $error = "Пользователь с таким email уже зарегистрирован";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $role_id = 2;
            $sql = "INSERT INTO users (username, password, email, role_id) VALUES ('$username', '$hashed_password', '$email', '$role_id')";
            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Ошибка при регистрации: " . $db_connection->error;
            }
        }
    }
}
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/reg.css">
</head>
<body>


<section>
    <form id="registrationForm" action="" method="post">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Подтверждение пароля:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>
</section>

<script>
    document.getElementById("registrationForm").addEventListener("submit", function(event) {

        var emailInput = document.getElementById("email");
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            alert("Некорректный формат email");
            event.preventDefault();
            return;
        }

        var passwordInput = document.getElementById("password");
        if (passwordInput.value.length < 8) {
            alert("Пароль должен содержать не менее 8 символов");
            event.preventDefault();
            return;
        }

        var confirmPasswordInput = document.getElementById("confirm_password");
        if (passwordInput.value !== confirmPasswordInput.value) {
            alert("Пароли не совпадают");
            event.preventDefault();
            return;
        }
    });
</script>

</body>
</html>
