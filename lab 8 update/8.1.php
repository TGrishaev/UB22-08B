<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
</head>
<body>
    <h2>Таблица умножения от 0 до 10</h2>
    <table border="1">
        <tr>
            <th>&nbsp;</th>
            <?php
                
                for ($i = 0; $i <= 10; $i++) {
                    echo "<th>$i</th>";
                }
            ?>
        </tr>
        <?php
            
            for ($i = 0; $i <= 10; $i++) {
                echo "<tr><th>$i</th>";
                for ($j = 0; $j <= 10; $j++) {
                    echo "<td>" . ($i * $j) . "</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>
