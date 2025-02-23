<?php

include("../connection.php");
if ($_POST['type'] == 'DISABLE') {
    $sql = "UPDATE patient_appointments set disable = ? where id = ?";
    $stmt = $database->prepare($sql);
    $bind = $stmt->bind_param(
        "ii",
        $_POST['disable'],
        $_POST['id']
    );
    $stmt->execute();
    echo $stmt->error;
}
if ($_POST['type'] == 'SURGERY_CALL') {
    $sequence = 0;
    $result = $database->query("select surgery_sequence from patient_appointments order by surgery_sequence DESC LIMIT 1");
    for ($y=0;$y<$result->num_rows;$y++){
        $sequence = $result->fetch_assoc()['surgery_sequence'];
    }
    ++$sequence;
    $sql = "UPDATE patient_appointments set surgery_sequence = ? , updated_sequence = ? where id = ?";
    $stmt = $database->prepare($sql);
    $bind = $stmt->bind_param(
        "iii",
        $sequence,
        $sequence,
        $_POST['id']
    );
    $stmt->execute();
    echo $stmt->error;
}

if ($_POST['type'] == 'SEQUENCE_CHANGE') {
    $data = json_decode($_POST['data']);
    foreach ($data as $d) {
        $sql = "UPDATE patient_appointments set updated_sequence = ? where id = ?";
        $stmt = $database->prepare($sql);
        $bind = $stmt->bind_param(
            "ii",
            $d->newPosition,
            $d->id
        );
        $stmt->execute();
    }
    echo $stmt->error;
}
