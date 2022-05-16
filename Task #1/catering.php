<?php

if (isset($_REQUEST['submit'])) {
    
    echo "<style>
    table, td, th {
      border: 1px solid black;
    }
    td {
    padding: 10px;
    width: 100px;
    }
    </style>";

    $min = $_REQUEST['min'];
    $max = $_REQUEST['max'];
    $costArray = array();

    if ((is_numeric($min) && is_numeric($max)) && ($max >= $min) && ($max >= 0 && $min >= 0)) {

        $insertHTML = "<table>"."<tr>"."<th> cost per person → <br> ↓ party size </th>";

        for ($i = 1; $i<=5; $i++){
            $key = "c".$i;
            if (is_numeric($_REQUEST[$key])){
                array_push($costArray,$_REQUEST[$key]);
                $j = $i - 1;
                $insertHTML .= "<td> {$costArray[$j]} </td>";
            }
            else {
                break;
            }
        }

        if (count($costArray) == 5) {
            echo $insertHTML;
            for ($i = $min; $i <= $max; $i+=5) {
                echo "<tr>"."<td> $i </td>";
                for ($j = 0; $j < 5; $j++){
                    $value = $i * $costArray[$j];
                    echo "<td> $value </td>";
                }
                echo "</tr>";        
            }
            echo "</table>";
        }

        else {
            echo "Please insert numeric values in all the fields!";
        }

    }

    else {
        echo "Please insert numeric values in all the fields!";
    }
    
}

?>