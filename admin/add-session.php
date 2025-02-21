<?php
session_start();
if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}
if ($_POST) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include("../connection.php");
    $title = $_POST["title"];
    $sessionType = $_POST["sessionType"];
    $docid = $_POST["docid"];
    $fromDate = $_POST["fromDate"];
    $toDate = $_POST["toDate"];

    $weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $selectedDays = [];
    $scheduleData = [];
    foreach ($weekdays as $day) {
        $dayKey = strtolower(substr($day, 0, 3)); // mon, tue, wed, etc.
        if (isset($_POST[$dayKey])) {
            $selectedDays[$dayKey] = [
                "enabled" => 1,
                "fromTime" => $_POST[$dayKey . "_open"] ?? "",
                "toTime" => $_POST[$dayKey . "_close"] ?? "",
                "sessions" => $_POST[$dayKey . "_nos"] ?? 0
            ];
        } else {
            $selectedDays[$dayKey] = ["enabled" => 0, "fromTime" => null, "toTime" => null, "sessions" => 0];
        }
    }

    $sql = "INSERT INTO schedule 
            (docid, title, session_type, fromdate, todate, 
            mon, mon_fromtime, mon_totime, mon_nos, 
            tue, tue_fromtime, tue_totime, tue_nos, 
            wed, wed_fromtime, wed_totime, wed_nos, 
            thu, thu_fromtime, thu_totime, thu_nos, 
            fri, fri_fromtime, fri_totime, fri_nos, 
            sat, sat_fromtime, sat_totime, sat_nos, 
            sun, sun_fromtime, sun_totime, sun_nos) 
            VALUES (?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?)";

    $stmt = $database->prepare($sql);
    
    $stmt->bind_param(
        "sssssssssssssssssssssssssssssssss",
        $docid, $title, $sessionType, $fromDate, $toDate,
        $selectedDays["mon"]["enabled"], $selectedDays["mon"]["fromTime"], $selectedDays["mon"]["toTime"], $selectedDays["mon"]["sessions"],
        $selectedDays["tue"]["enabled"], $selectedDays["tue"]["fromTime"], $selectedDays["tue"]["toTime"], $selectedDays["tue"]["sessions"],
        $selectedDays["wed"]["enabled"], $selectedDays["wed"]["fromTime"], $selectedDays["wed"]["toTime"], $selectedDays["wed"]["sessions"],
        $selectedDays["thu"]["enabled"], $selectedDays["thu"]["fromTime"], $selectedDays["thu"]["toTime"], $selectedDays["thu"]["sessions"],
        $selectedDays["fri"]["enabled"], $selectedDays["fri"]["fromTime"], $selectedDays["fri"]["toTime"], $selectedDays["fri"]["sessions"],
        $selectedDays["sat"]["enabled"], $selectedDays["sat"]["fromTime"], $selectedDays["sat"]["toTime"], $selectedDays["sat"]["sessions"],
        $selectedDays["sun"]["enabled"], $selectedDays["sun"]["fromTime"], $selectedDays["sun"]["toTime"], $selectedDays["sun"]["sessions"]
    );
    $stmt->execute();
    $schedule_id = $stmt->insert_id;

    $start_date = new DateTime($fromDate);
    $end_date = new DateTime($toDate);
    $interval = new DateInterval('P1D'); // 1-day interval
    $dateRange = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

    foreach ($dateRange as $date) {
        $dayKey = strtolower(substr($date->format("l"), 0, 3)); // Get the weekday short form (mon, tue, etc.)

        if ($selectedDays[$dayKey]["enabled"]) {
            $fromTime = strtotime($selectedDays[$dayKey]["fromTime"]);
            $toTime = strtotime($selectedDays[$dayKey]["toTime"]);
            $sessions = (int) $selectedDays[$dayKey]["sessions"];

            if ($sessions > 0 && $fromTime < $toTime) {
                $session_duration = ($toTime - $fromTime) / $sessions;
                $currentSlotTime = $fromTime;

                for ($i = 0; $i < $sessions; $i++) {
                    if ($currentSlotTime < $toTime) {
                        $slot_time = date("H:i:s", $currentSlotTime);
                        $slot_sql = "INSERT INTO schedule_slots 
                                    (schedule_id, appointment_date, appointment_time, original_date, original_time, created_at) 
                                    VALUES (?, ?, ?, ?, ?, ?)";
                        $slot_stmt = $database->prepare($slot_sql);
                        $created_at = date('Y-m-d H:i:s');
                        $formattedDate = $date->format('Y-m-d');
                        $slot_stmt->bind_param(
                            "isssss",
                            $schedule_id,
                            $formattedDate,
                            $slot_time,
                            $formattedDate,
                            $slot_time,
                            $created_at
                        );
                        $slot_stmt->execute();
                        $currentSlotTime += $session_duration;
                    }
                }
            }
        }
    }

    header("location: schedule.php?action=session-added&title=$title");
}
?>