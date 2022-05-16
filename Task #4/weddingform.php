<?php

include "mysql-connect.php";

$conn = mysqli_connect($serverName, $username, $password, $dbName);
if (!$conn) {
    die ("Connection failed: ".mysqli_connect_error());
}

$partySize = $_REQUEST['partySize'];
$cateringGrade = $_REQUEST['cateringGrade'];
$bookingDate = $_REQUEST['bookingDate'];
$dataArray = array();

$SQL1 = "SELECT name, capacity, if(licensed, 'Licensed', 'Not licensed') as 'Licensed', if(count(booking_date) = 1, 'Booked', 'Not booked') as 'isBooked'
FROM venue LEFT JOIN venue_booking ON venue.venue_id = venue_booking.venue_id AND booking_date = '$bookingDate'
WHERE capacity >= $partySize
GROUP BY venue.venue_id;";

$SQL2 = "SELECT name, count(booking_date) as 'numBookings' 
from venue JOIN venue_booking ON venue.venue_id = venue_booking.venue_id 
WHERE capacity >= $partySize 
GROUP BY venue.venue_id;";

$SQL3 = "SELECT venue.name, any_value(cost) as 'PersonCost',
IF((WEEKDAY('$bookingDate') >= 0) AND (WEEKDAY('$bookingDate') <= 4), venue.weekday_price, venue.weekend_price) as 'DayCost',
SUM($partySize * cost + IF((WEEKDAY('$bookingDate') >= 0) AND (WEEKDAY('$bookingDate') <= 4), venue.weekday_price, venue.weekend_price)) as 'TotalCost'
FROM catering JOIN venue ON catering.venue_id = venue.venue_id AND grade = $cateringGrade 
WHERE capacity >= $partySize
GROUP BY venue.venue_id;";  

$SQL = $SQL1.$SQL2.$SQL3;

if (mysqli_multi_query($conn, $SQL)) {
    do {
      // Store first result set
      if ($result = mysqli_store_result($conn)) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $dataArray[] = $row;
        }
        mysqli_free_result($result);
      }
       //Prepare next result set
    } while (mysqli_next_result($conn));
  }
  
  echo json_encode($dataArray);
  mysqli_close($conn);

?>