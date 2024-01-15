

<?php
session_start();


if (!isset($_SESSION["user_id"]) && $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}


include "db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sportName = $_POST["sport_name"];


    if (empty($sportName)) {
        $error = "Введите название спорта";
    } else {

        $insertSql = "INSERT INTO sports (sport_name) VALUES ('$sportName')";
        if ($conn->query($insertSql) === TRUE) {
            $successMessage = "Новый вид спорта успешно добавлен";
        } else {
            $error = "Ошибка при добавлении вида спорта: " . $conn->error;
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
    <title>Добавить вид спорта</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>


<section>
    <h2>Добавить вид спорта</h2>

    <form id="addSportForm" action="" method="post">
        <label for="sport_name">Название спорта:</label>
        <input type="text" id="sport_name" name="sport_name" required>

        <button type="submit">Добавить</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    } elseif (isset($successMessage)) {
        echo "<p class='success'>$successMessage</p>";
    }
    ?>

    <a href="profile.php">Назад в личный кабинет</a>
</section>
</body>
</html>
