<?php

    include("../connection.php");
    $arr = [];
    $result = $database->query("select * from patient_appointments where completed IS NULL");
    for ($y=0;$y<$result->num_rows;$y++){
        $arr[] = $result->fetch_assoc();
    }
    echo json_encode($arr);

