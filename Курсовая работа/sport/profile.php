<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$userId = $_SESSION["user_id"];
$userInfo = getUserInfoFromDatabase($userId);

if (!$userInfo) {
    die("Ошибка при получении информации о пользователе");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["new_username"];

    if (empty($newUsername)) {
        $error = "Введите новое имя пользователя";
    } else {
        $updateSql = "UPDATE users SET username = '$newUsername' WHERE user_id = $userId";
        if ($conn->query($updateSql) === TRUE) {
            // Обновляем информацию в текущей сессии
            $_SESSION["username"] = $newUsername;
            // Обновляем информацию о пользователе
            $userInfo["username"] = $newUsername;
        } else {
            $error = "Ошибка при обновлении имени пользователя: " . $conn->error;
        }
    }

    if (isset($_POST["cancel_event"])) {
        $eventId = $_POST["cancel_event"];
        $cancelEventSql = "DELETE FROM user_events WHERE user_id = '$userId' AND event_id = '$eventId'";
        if ($conn->query($cancelEventSql) === TRUE) {
            header("Location: profile.php");
            exit();
        } else {
            $error = "Ошибка при отмене записи на мероприятие: " . $conn->error;
        }
    }
}

$userEventsSql = "SELECT events.* FROM events
                  INNER JOIN user_events ON events.event_id = user_events.event_id
                  WHERE user_events.user_id = '$userId'";
$userEventsResult = $conn->query($userEventsSql);
$userEvents = $userEventsResult->fetch_all(MYSQLI_ASSOC);

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>

<section>
    <h2>Привет, <?php echo $userInfo["username"]; ?>!</h2>
    <p>Email: <?php echo $userInfo["email"]; ?></p>
    <p>Роль: <?php echo ($userInfo["role_id"] == 1) ? "Администратор" : "Пользователь"; ?></p>

    <?php if ($userInfo["role_id"] == 1): ?>
        <h3>Функционал администратора:</h3>
        <ul>
            <li><a href="/add_sport.php">Добавить вид спорта</a></li>
            <li><a href="/view_sports.php">Список видов спорта</a></li>
            <li><a href="/add_event.php">Добавить мероприятие</a></li>
            <li><a href="/view_events.php">Список мероприятий</a></li>
            <li><a href="/user_list.php">Список пользователей</a></li>
        </ul>
    <?php endif; ?>

    <h3>Мероприятия, на которые вы записаны:</h3>
    <ul>
        <?php foreach ($userEvents as $event): ?>
            <li>
                <?php echo $event['event_name']; ?>
                <form method="post" action="">
                    <input type="hidden" name="cancel_event" value="<?php echo $event['event_id']; ?>">
                    <button type="submit">Отменить запись</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Изменить имя пользователя</h3>
    <form id="changeUsernameForm" action="" method="post">
        <label for="new_username">Новое имя пользователя:</label>
        <input type="text" id="new_username" name="new_username" required>

        <button type="submit">Изменить имя</button>
    </form>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>


</section>

</body>
</html>
