<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация пользователя</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }
        .registration-form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #02ff9e;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #aaa;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="registration-form">
        <h2>Регистрация пользователя</h2>
        <form action="process_registration.php" method="post">
            <div class="form-group">
                <label for="fullname">ФИО:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="login">Логин:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="birthdate">Дата рождения:</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = $_POST["fullname"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $birthdate = $_POST["birthdate"];
    echo "ФИО: " . $fullname . "<br>";
    echo "Логин: " . $login . "<br>";
    echo "Пароль: " . $password . "<br>";
    echo "Дата рождения: " . $birthdate . "<br>";
} else {
    
   
}
?>
