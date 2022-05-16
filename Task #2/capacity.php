<?php

if (isset($_GET['submit'])) {

    include "mysql-connect.php";

    echo "<style>
    table, td, th {
    border: 1px solid black;
    }
    td {
    padding: 10px;
    width: 200px;
    }
    </style>";

    $minCapacity = $_GET['minCapacity'];
    $maxCapacity = $_GET['maxCapacity'];

    if ((is_numeric($minCapacity) && is_numeric($maxCapacity)) && ($maxCapacity >= $minCapacity) && ($maxCapacity >= 0 && $minCapacity >= 0)){

        $conn = mysqli_connect($serverName, $username, $password, $dbName);
        if (!$conn) {
            die ("Connection failed: ".mysqli_connect_error());
        }


        $query = "SELECT name, weekday_price, weekend_price FROM `venue` WHERE licensed = 1 AND capacity >= $minCapacity AND capacity <= $maxCapacity";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<table> <tr> <th> Name of venue </th> <th> Weekday price of venue </th>  <th> Weekend price of venue </th> </tr>";
            while($row = mysqli_fetch_array($result)) {
                echo "<tr> <td>".$row['name']."</td>"."<td>".$row['weekday_price']."</td>"."<td>".$row['weekend_price']."</td> </tr>" ;
            }
            echo "</table>";
        }
        else {
            echo "No results have been found. Please re-do the search.";
        }
        mysqli_close($conn); 
    }

    else {
        echo "Please insert proper numeric values!";
    }
    
}

?>