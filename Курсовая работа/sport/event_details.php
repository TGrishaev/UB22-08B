<?php
session_start();


include "db.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if (!isset($_GET["event_id"])) {
    header("Location: view_events.php");
    exit();
}

$eventId = $_GET["event_id"];


$eventSql = "SELECT events.*, sports.sport_name 
             FROM events 
             INNER JOIN sports ON events.sport_id = sports.sport_id 
             WHERE event_id = '$eventId'";
$eventResult = $conn->query($eventSql);

if ($eventResult->num_rows == 0) {
    header("Location: view_events.php");
    exit();
}

$event = $eventResult->fetch_assoc();

$isAdministrator = isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 1;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register_event"])) {
    $userId = $_SESSION["user_id"];
    $registerSql = "INSERT INTO user_events (user_id, event_id, registration_date) VALUES ('$userId', '$eventId', NOW())";
    if ($conn->query($registerSql) === TRUE) {
        $successMessage = "Вы успешно записались на мероприятие!";
    } else {
        $error = "Ошибка при записи на мероприятие: " . $conn->error;
    }
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о мероприятии</title>
    <link rel="stylesheet" href="/css/event_details.css">
</head>
<body>



<section>
    <h2><?php echo $event['event_name']; ?></h2>

    <p>Вид спорта: <?php echo $event['sport_name']; ?></p>
    <p>Место проведения: <?php echo $event['event_location']; ?></p>
    <p>Дата и время начала: <?php echo $event['event_date']; ?></p>



    <h3>Отзывы:</h3>
    <?php

    $reviewsSql = "SELECT reviews.*, users.username 
                   FROM reviews 
                   INNER JOIN users ON reviews.user_id = users.user_id 
                   WHERE event_id = '$eventId'";
    $reviewsResult = $conn->query($reviewsSql);

    if ($reviewsResult->num_rows > 0) {
        while ($review = $reviewsResult->fetch_assoc()) {
            echo "<p>" . $review['username'] . " оценил мероприятие на " . $review['rating'] . " баллов:</p>";
            echo "<p>" . $review['comment'] . "</p>";
        }
    } else {
        echo "<p>Пока нет отзывов.</p>";
    }
    ?>
    <?php if (isset($_SESSION["user_id"])): ?>
        <h3>Оставить отзыв:</h3>
        <form method="post" action="add_review.php">
            <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
            <label for="review_text">Текст отзыва:</label>
            <textarea id="review_text" name="review_text" required></textarea>
            <label for="rating">Оценка (от 1 до 5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
            <button type="submit">Отправить отзыв</button>
        </form>
    <?php endif; ?>
    <?php if (isset($_SESSION["user_id"])): ?>
        <form method="post" action="">
            <input type="hidden" name="register_event" value="1">
            <button type="submit">Записаться на мероприятие</button>
        </form>
    <?php endif; ?>

    <?php if (isset($successMessage)): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

</section>

<script>
    function animateReviewButton() {
        var reviewButton = document.getElementById("submit-review");
        reviewButton.style.backgroundColor = "#004080";
        reviewButton.style.color = "#fff";
        setTimeout(function () {
            reviewButton.style.backgroundColor = "#0066cc";
            reviewButton.style.color = "#fff";
        }, 300);
    }
</script>

</body>
</html>
