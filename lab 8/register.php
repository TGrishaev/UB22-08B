<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Извлечение данных из формы
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];
    
    // Дополнительная обработка данных
    // ...
    
    // Вывод информации о пользователе
    echo "Вы успешно зарегистрировались!<br>";
    echo "ФИО: $fullname<br>";
    echo "Логин: $username<br>";
    echo "Пароль: $password<br>";
    echo "Дата рождения: $birthdate";
}
?>
