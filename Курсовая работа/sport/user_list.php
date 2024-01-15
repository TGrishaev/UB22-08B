<?php
session_start();

if (!isset($_SESSION["user_id"]) && $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}


include "db.php";


$usersSql = "SELECT * FROM users";
$usersResult = $conn->query($usersSql);
$users = $usersResult->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    $userId = $_POST["delete_user"];


    $deleteReviewsSql = "DELETE FROM reviews WHERE user_id = '$userId'";
    $conn->query($deleteReviewsSql);

    $deleteUserEventsSql = "DELETE FROM user_events WHERE user_id = '$userId'";
    $conn->query($deleteUserEventsSql);

    $deleteUserSql = "DELETE FROM users WHERE user_id = '$userId'";
    if ($conn->query($deleteUserSql) === TRUE) {
        header("Location: user_list.php");
        exit();
    } else {
        $error = "Ошибка при удалении пользователя: " . $conn->error;
    }
}
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>


<section>
    <h2>Список пользователей</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><a href="user_details.php?user_id=<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></a></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo ($user['role_id'] == 1) ? 'Администратор' : 'Пользователь'; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="delete_user" value="<?php echo $user['user_id']; ?>">
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
