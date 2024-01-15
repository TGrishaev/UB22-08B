<?php
session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["user_id"])) {
    header("Location: user_list.php");
    exit();
}

$userId = $_GET["user_id"];

$userSql = "SELECT * FROM users WHERE user_id = '$userId'";
$userResult = $conn->query($userSql);

if ($userResult->num_rows == 0) {
    header("Location: user_list.php");
    exit();
}

$user = $userResult->fetch_assoc();

$isAdministrator = isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 1;

// Обработка изменения имени пользователя и роли
if ($isAdministrator && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_user"])) {
    $newUsername = $_POST["new_username"];
    $newRole = $_POST["new_role"];

    $updateSql = "UPDATE users SET username = '$newUsername', role_id = '$newRole' WHERE user_id = '$userId'";
    if ($conn->query($updateSql) === TRUE) {
        // Обновление успешно
        header("Location: user_details.php?user_id=$userId");
        exit();
    } else {
        $error = "Ошибка при обновлении пользователя: " . $conn->error;
    }
}
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о пользователе</title>
    <link rel="stylesheet" href="/css/profile.css">
    <style>
        button:hover {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<section>
    <h2><?php echo $user['username']; ?></h2>

    <p>Email: <?php echo $user['email']; ?></p>
    <p>Роль: <?php echo ($user['role_id'] == 1) ? 'Администратор' : 'Пользователь'; ?></p>

    <?php if ($isAdministrator): ?>
        <h3>Изменить информацию о пользователе:</h3>
        <form method="post" action="" id="updateUserForm">
            <label for="new_username">Новое имя пользователя:</label>
            <input type="text" id="new_username" name="new_username" value="<?php echo $user['username']; ?>" required>

            <label for="new_role">Новая роль:</label>
            <select id="new_role" name="new_role" required>
                <option value="1" <?php echo ($user['role_id'] == 1) ? 'selected' : ''; ?>>Администратор</option>
                <option value="2" <?php echo ($user['role_id'] == 2) ? 'selected' : ''; ?>>Пользователь</option>
            </select>

            <button type="button" onclick="confirmUpdate()">Обновить</button>
            <input type="hidden" name="update_user" value="1">
        </form>
    <?php endif; ?>

    <a href="user_list.php">Назад к списку пользователей</a>
</section>

<?php
if (isset($error)) {
    echo "<p class='error'>$error</p>";
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("button").forEach(function (button) {
            button.addEventListener("mouseover", function () {
                button.style.backgroundColor = "#4CAF50";
                button.style.color = "white";
            });

            button.addEventListener("mouseout", function () {
                button.style.backgroundColor = "";
                button.style.color = "";
            });
        });
    });

    function confirmUpdate() {
        var confirmation = confirm("Вы уверены, что хотите обновить информацию о пользователе?");
        if (confirmation) {
            document.getElementById("updateUserForm").submit();
        }
    }
</script>

</body>
</html>
