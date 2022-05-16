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

    $month = $_GET['month'];
    if (is_numeric($month) && ($month >= 1 && $month <= 12)){


        $conn = mysqli_connect($serverName, $username, $password, $dbName);
        if (!$conn) {
            die ("Connection failed: ".mysqli_connect_error());
        }
        
        $query = "SELECT name, COUNT(venue_booking.venue_id) as count FROM venue_booking, venue WHERE venue.venue_id = venue_booking.venue_id AND MONTH(booking_date) = $month GROUP BY name ORDER BY count desc";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          echo "<table> <tr> <th> Name of venue </th> <th> Number of bookings </th> </tr>";
          while($row = mysqli_fetch_array($result)){
            echo "<tr> <td>".$row['name']."</td>"."<td>".$row['count']."</td> </tr>" ;
          }
          echo "</table>";  
        }

        else {
            echo "No results available!";
        }
        mysqli_close($conn);
    }
    else {
        echo "Please insert proper numeric values in the fields!";
    }

}
?>
