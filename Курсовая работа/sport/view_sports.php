

<?php
session_start();




include "db.php";

$sportsSql = "SELECT * FROM sports";
$sportsResult = $conn->query($sportsSql);
$sports = $sportsResult->fetch_all(MYSQLI_ASSOC);

$isAdministrator = isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 1;

if ($isAdministrator && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_sport"])) {
    $sportId = $_POST["delete_sport"];
    $deleteSql = "DELETE FROM sports WHERE sport_id = '$sportId'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: view_sports.php");
        exit();
    } else {
        $error = "Ошибка при удалении вида спорта: " . $conn->error;
    }
}
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список видов спорта</title>
    <link rel="stylesheet" href="/css/view_sports.css">
</head>
<body>


<section>
    <h2>Список видов спорта</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название спорта</th>
            <?php if ($isAdministrator): ?>
                <th>Действия</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sports as $sport): ?>
            <tr>
                <td><?php echo $sport['sport_id']; ?></td>
                <td>

                        <a href="events_by_sport.php?sport_id=<?php echo $sport['sport_id']; ?>">
                            <?php echo $sport['sport_name']; ?>
                        </a>

                </td>
                <?php if ($isAdministrator): ?>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="delete_sport" value="<?php echo $sport['sport_id']; ?>">
                            <button type="submit">Удалить</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</section>

<?php
if (isset($error)) {
    echo "<p class='error'>$error</p>";
}
?>
</body>
</html>
