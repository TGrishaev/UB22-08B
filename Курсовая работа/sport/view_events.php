
<?php
session_start();

include "db.php";

if (!isset($_SESSION["user_id"]) && $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_event"])) {
    $eventId = $_POST["delete_event"];

    // Удаление отзывов связанных с мероприятием
    $deleteReviewsSql = "DELETE FROM reviews WHERE event_id = '$eventId'";
    if ($conn->query($deleteReviewsSql) === TRUE) {
        // Удаление самого мероприятия
        $deleteEventSql = "DELETE FROM events WHERE event_id = '$eventId'";
        if ($conn->query($deleteEventSql) === TRUE) {
            header("Location: view_events.php");
            exit();
        } else {
            $error = "Ошибка при удалении мероприятия: " . $conn->error;
        }
    } else {
        $error = "Ошибка при удалении отзывов: " . $conn->error;
    }
}

$eventsSql = "SELECT * FROM events";
$eventsResult = $conn->query($eventsSql);
$events = $eventsResult->fetch_all(MYSQLI_ASSOC);
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список мероприятий</title>
    <link rel="stylesheet" href="/css/view_events.css">
</head>
<body>


<section>
    <h2>Список мероприятий</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название мероприятия</th>
            <th>Вид спорта</th>
            <th>Место проведения</th>
            <th>Время начала</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo $event['event_id']; ?></td>
                <td><a href="event_details.php?event_id=<?php echo $event['event_id']; ?>"><?php echo $event['event_name']; ?></a></td>

                <td><?php echo $event['sport_id']; ?></td>
                <td><?php echo $event['event_location']; ?></td>
                <td><?php echo $event['event_date']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="delete_event" value="<?php echo $event['event_id']; ?>">
                        <button type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="profile.php">Назад в личный кабинет</a>
</section>

<?php
if (isset($error)) {
    echo "<p class='error'>$error</p>";
}
?>
</body>
</html>
