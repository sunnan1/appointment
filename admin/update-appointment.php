<?php

if (isset($_POST['id'])) {
    session_start();
    include("../connection.php");
    $_appointmentId = $_POST['id'];
    $_movedTo = $_POST['newDate'];

    // move the record of $_appointmentId to new date but here are few things you need to check
    // assign the empty patient slot to this record based on the newDate and update time as per the $_appointmentId record time
    // push forward all records to next step if no empty slot on that newDate
    // slots are created in schedule_slots and this is the structure of schedule_slots id, patient_id, schedule_id, appointment_date, appointment_time, original_date, original_Time


    $conn->begin_transaction();

    $stmt = $conn->prepare("SELECT schedule_id, appointment_time, patient_id FROM schedule_slots WHERE id = ?");
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();
    $stmt->close();

    if (!$appointment) {
        exit('Appointment not found');
    }

    $scheduleId = $appointment['schedule_id'];
    $appointmentTime = $appointment['appointment_time'];
    $patientId = $appointment['patient_id'];

    $stmt = $conn->prepare("SELECT id FROM schedule_slots 
                            WHERE schedule_id = ? AND appointment_date = ? AND patient_id IS NULL 
                            ORDER BY appointment_time ASC LIMIT 1");
    $stmt->bind_param("is", $scheduleId, $newDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $emptySlot = $result->fetch_assoc();
    $stmt->close();

    if ($emptySlot) {
        $slotId = $emptySlot['id'];
        $stmt = $conn->prepare("UPDATE schedule_slots SET 
            patient_id = ?, 
            appointment_time = ?, 
            WHERE id = ?");
        $stmt->bind_param("isi", $patientId, $appointmentTime, $slotId);
        $stmt->execute();
        $stmt->close();

        // Free up the old slot
        $stmt = $conn->prepare("UPDATE schedule_slots SET patient_id = NULL WHERE id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("SELECT id FROM schedule_slots 
                                WHERE schedule_id = ? AND appointment_date = ? 
                                ORDER BY appointment_time ASC");
        $stmt->bind_param("is", $scheduleId, $newDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointmentsToPush = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if ($appointmentsToPush) {
            foreach ($appointmentsToPush as $row) {
                // Move each appointment forward by 1 time slot
                $stmt = $conn->prepare("UPDATE schedule_slots 
                                        SET appointment_time = 
                                        (SELECT appointment_time FROM schedule_slots 
                                        WHERE id = ? LIMIT 1) 
                                        WHERE id = ?");
                $stmt->bind_param("ii", $row['id'], $row['id'] + 1); // Move to next slot
                $stmt->execute();
                $stmt->close();
            }
            
            // Now, move the dropped appointment to the first time slot
            $stmt = $conn->prepare("UPDATE schedule_slots SET appointment_date = ?, appointment_time = ? 
                                    WHERE id = ?");
            $stmt->bind_param("ssi", $newDate, $appointmentTime, $appointmentId);
            $stmt->execute();
            $stmt->close();
        }
    }
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Appointment successfully updated"]);
}





