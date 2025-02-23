<?php

    include("../connection.php");
    $arr = [];
    $result = $database->query("select * from patient_appointments where surgery_sequence IS NOT NULL and completed IS NULL ORDER BY updated_sequence ASC");
    for ($y=0;$y<$result->num_rows;$y++){
        $arr[] = $result->fetch_assoc();
    }
    echo json_encode($arr);

