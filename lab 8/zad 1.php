<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 50%;
  margin-left: auto;
  margin-right: auto;
}

th, td {
  padding: 10px;
  text-align: center;
}

th {
  background-color: #ccc;
}

td {
  background-color: #f2f2f2;
}
</style>
</head>
<body>

<table>
  <tr>
    <th></th>
    <?php
    for ($i = 0; $i <= 10; $i++) {
        echo "<th>$i</th>";
    }
    ?>
  </tr>
  <?php
  for ($i = 0; $i <= 10; $i++) {
      echo "<tr>";
      for ($j = 0; $j <= 10; $j++) {
          if ($j === 0) {
              echo "<th>$i</th>";
          }
          echo "<td>" . ($i * $j) . "</td>";
      }
      echo "</tr>";
  }
  ?>
</table>

</body>
</html>