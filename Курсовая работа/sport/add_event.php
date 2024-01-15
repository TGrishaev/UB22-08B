
<?php
session_start();


if (!isset($_SESSION["user_id"]) && $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}


include "db.php";


$sportsSql = "SELECT * FROM sports";
$sportsResult = $conn->query($sportsSql);
$sports = $sportsResult->fetch_all(MYSQLI_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST["event_name"];
    $sportId = $_POST["sport_id"];
    $eventLocation = $_POST["event_location"];
    $eventTime = $_POST["event_date"];


    if (empty($eventName)) {
        $error = "Введите название мероприятия";
    } else {

        $insertSql = "INSERT INTO events (event_name, sport_id, event_location, event_date) 
                      VALUES ('$eventName', '$sportId', '$eventLocation', '$eventTime')";
        if ($conn->query($insertSql) === TRUE) {
            $successMessage = "Новое мероприятие успешно добавлено";
        } else {
            $error = "Ошибка при добавлении мероприятия: " . $conn->error;
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
    <title>Добавить мероприятие</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>


<section>
    <h2>Добавить мероприятие</h2>

    <form id="addEventForm" action="" method="post">
        <label for="event_name">Название мероприятия:</label>
        <input type="text" id="event_name" name="event_name" required>

        <label for="sport_id">Вид спорта:</label>
        <select id="sport_id" name="sport_id" required>
            <?php foreach ($sports as $sport): ?>
                <option value="<?php echo $sport['sport_id']; ?>"><?php echo $sport['sport_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="event_location">Место проведения:</label>
        <input type="text" id="event_location" name="event_location" required>

        <label for="event_date">Время начала:</label>
        <input type="datetime-local" id="event_date" name="event_date" required>

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
