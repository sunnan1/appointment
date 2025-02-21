<?php

if (isset($_POST['patient'])) {
    session_start();
    include("../connection.php");

    $mrn     = $_POST['patient']['mrn'];
    $name    = $_POST['patient']['name'];
    $father  = $_POST['patient']['father_name'];
    $age     = $_POST['patient']['age']; // if this is a number, consider casting it to int
    $dob     = $_POST['patient']['dob'];
    $contact = $_POST['patient']['contact'];
    $address = $_POST['patient']['state'] . ' ' . $_POST['patient']['district'];
    $gender = $_POST['patient']['gender'];
    $country = $_POST['patient']['country'];
    $procedure = $_POST['procedure'];
    $date    = date('Y-m-d H:i:s');
    $created_by = 1; // integer value

    $sql = "INSERT INTO patient_appointments 
            (proced, mrn, patient_name, father_name, age, dob, contact, address, gender, country, created_at, created_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $database->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $database->error);
    }

    $bind = $stmt->bind_param(
        "sssssssssssi",
        $procedure,
        $mrn, 
        $name, 
        $father, 
        $age, 
        $dob, 
        $contact, 
        $address,
        $gender,
        $country, 
        $date, 
        $created_by
    );
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute() === false) {
        die("Execute failed: " . $stmt->error);
    } else {
        echo 1;
    }

    $stmt->close();

}