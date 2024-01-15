
<?php
session_start();


include "db.php";

if (!isset($_GET["sport_id"])) {
    header("Location: view_sports.php");
    exit();
}

$sportId = $_GET["sport_id"];

$sportSql = "SELECT * FROM sports WHERE sport_id = '$sportId'";
$sportResult = $conn->query($sportSql);

if ($sportResult->num_rows == 0) {
    header("Location: view_sports.php");
    exit();
}

$sport = $sportResult->fetch_assoc();

$eventsSql = "SELECT * FROM events WHERE sport_id = '$sportId'";
$eventsResult = $conn->query($eventsSql);
$events = $eventsResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мероприятия по виду спорта</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
<header>
    <h1>Мероприятия по виду спорта "<?php echo $sport['sport_name']; ?>"</h1>
</header>

<section>
    <h2>Список мероприятий</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название мероприятия</th>
            <th>Место проведения</th>
            <th>Дата и время начала</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo $event['event_id']; ?></td>
                <td><a href="event_details.php?event_id=<?php echo $event['event_id']; ?>"><?php echo $event['event_name']; ?></a></td>

                <td><?php echo $event['event_location']; ?></td>
                <td><?php echo $event['event_date']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="view_sports.php">Назад к списку видов спорта</a>
</section>
</body>
</html>
