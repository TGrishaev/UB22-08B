

<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


include "db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST["event_id"];
    $user_id = $_SESSION["user_id"];
    $comment = $_POST["review_text"];
    $rating = $_POST["rating"];


    if ($rating < 1 || $rating > 5) {
        $error = "Некорректная оценка. Пожалуйста, выберите оценку от 1 до 5.";
    } else {
        // Вставляем отзыв в таблицу reviews
        $sql = "INSERT INTO reviews (event_id, user_id, comment, rating) VALUES ('$event_id', '$user_id', '$comment', '$rating')";

        if ($conn->query($sql) === TRUE) {
            header("Location: event_details.php?event_id=$event_id");
            exit();
        } else {
            $error = "Ошибка при добавлении отзыва: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление отзыва</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
<header>
    <h1>Добавление отзыва</h1>
</header>

<section>
    <form method="post" action="">
        <input type="hidden" name="event_id" value="<?php echo $_GET['event_id']; ?>">
        <label for="review_text">Текст отзыва:</label>
        <textarea id="review_text" name="review_text" required></textarea>
        <label for="rating">Оценка (от 1 до 5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>
        <button type="submit">Отправить отзыв</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <a href="event_details.php?event_id=<?php echo $_GET['event_id']; ?>">Назад к мероприятию</a>
</section>
</body>
</html>
