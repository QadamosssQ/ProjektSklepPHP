<?php

require_once 'conn.php';

$query = "SELECT * FROM samoloty";

$result = mysqli_query($conn, $query);





echo "<table>";

echo "<tr>";
echo "<td>Nazwa</td>";
echo "<td>Model</td>";
echo "<td>Typ</td>";
echo "<td>naped</td>";
echo "<td>cena</td>";

echo "</tr>";

while ($wynik = mysqli_fetch_assoc($result)){

    echo "<tr>";
    echo "<td>".$wynik['nazwa']."</td>";
    echo "<td>".$wynik['model']."</td>";
    echo "<td>".$wynik['typ']."</td>";
    echo "<td>".$wynik['naped']."</td>";
    echo "<td>".$wynik['cena']."</td>";


    echo "</tr>";
}


echo "</table>";