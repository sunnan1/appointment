<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.4/main.min.css" rel="stylesheet">
    <title>Schedule</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.4/main.min.js"></script>
</head>
<body>
<?php

//learn from w3schools.com

session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
        header("location: ../login.php");
    }

}else{
    header("location: ../login.php");
}



//import database
include("../connection.php");


?>
<div class="container">
    <div class="menu">
        <table class="menu-container" border="0">
            <tr>
                <td style="padding:10px" colspan="2">
                    <table border="0" class="profile-container">
                        <tr>
                            <td width="30%" style="padding-left:20px" >
                                <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                            </td>
                            <td style="padding:0px;margin:0px;">
                                <p class="profile-title">Administrator</p>
                                <p class="profile-subtitle">admin@edoc.com</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-dashbord" >
                    <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
    </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-doctor ">
            <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">Doctors</p></a></div>
</td>
</tr>
<tr class="menu-row" >
    <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Schedule</p></div></a>
    </td>
</tr>
<tr class="menu-row">
    <td class="menu-btn menu-icon-appoinment">
        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
    </td>
</tr>
<tr class="menu-row" >
    <td class="menu-btn menu-icon-patient">
        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Patients</p></a></div>
    </td>
</tr>

</table>
</div>
<div class="dash-body">
    <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
        <tr >
            <td width="13%" >
                <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
            </td>
            <td>
                <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Shedule Manager</p>

            </td>
            <td width="15%">
                <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                    Today's Date
                </p>
                <p class="heading-sub12" style="padding: 0;margin: 0;">
                    <?php

                    date_default_timezone_set('Asia/Kolkata');

                    $today = date('d-M-Y');
                    echo $today;

                    $list110 = $database->query("select  * from  schedule;");

                    ?>
                </p>
            </td>
            <td width="10%">
                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
            </td>


        </tr>

        <tr>
            <td colspan="4" >
                <div style="display: flex;margin-top: 40px;">
                    <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
                    <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add Schedule</font></button>
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:10px;width: 100%;" >

                <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Sessions (<?php echo $list110->num_rows; ?>)</p>
            </td>

        </tr>
        <tr>
            <td colspan="4" style="padding-top:0px;width: 100%;" >
                <center>
                    <table class="filter-container" border="0" >
                        <tr>
                            
                            <td width="5%" style="text-align: left;font-size:18px;" class="heading-main12">
                                Doctor:
                            </td>
                            <td width="30%">
                                <select name="docid" id="" class="box filter-container-items" style="width:90% ;height: 40px;margin: 0;font-size:18px;" >
                                    <option value="" disabled selected hidden>All Sessions</option><br/>

                                    <?php

                                    $list11 = $database->query("select  * from  doctor order by docname asc;");

                                    for ($y=0;$y<$list11->num_rows;$y++){
                                        $row00=$list11->fetch_assoc();
                                        $sn=$row00["docname"];
                                        $id00=$row00["docid"];
                                        echo "<option value=".$id00.">$sn</option><br/>";
                                    };

                                    ?>

                                </select>
                            </td>
                            <td width="5%" style="text-align: left;font-size:18px;" class="heading-main12">
                                Date:
                            </td>
                            <td width="30%">
                                <form action="" method="post">
                                 <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                            </td>
                            
                            <td width="12%">
                                <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                                </form>
                            </td>

                        </tr>
                    </table>

                </center>
            </td>

        </tr>

        <?php
        if($_POST){
            //print_r($_POST);
            $sqlpt1="";
            if(!empty($_POST["sheduledate"])){
                $sheduledate=$_POST["sheduledate"];
                $sqlpt1=" schedule.scheduledate='$sheduledate' ";
            }

            $sqlpt2="";
            if(!empty($_POST["docid"])){
                $docid=$_POST["docid"];
                $sqlpt2=" doctor.docid=$docid ";
            }
            //echo $sqlpt2;
            //echo $sqlpt1;
            $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.fromdate, schedule.todate from schedule inner join doctor on schedule.docid=doctor.docid ";
            $sqllist=array($sqlpt1,$sqlpt2);
            $sqlkeywords=array(" where "," and ");
            $key2=0;
            foreach($sqllist as $key){

                if(!empty($key)){
                    $sqlmain.=$sqlkeywords[$key2].$key;
                    $key2++;
                };
            };
            //echo $sqlmain;



            //
        }else{
            $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.fromdate, schedule.session_type, schedule.todate, schedule.mon, schedule.tue, schedule.wed, schedule.thu, schedule.fri, schedule.sat, schedule.sun from schedule inner join doctor on schedule.docid=doctor.docid order by doctor.docname asc";
        }
        ?>

        <tr>
            <td colspan="4">
                <center>
                    <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                            <thead>
                            <tr>
                                <th class="table-headin">
                                    Session Title
                                </th>
                                <th class="table-headin">

                                    Scheduled Date

                                </th>
                                <th class="table-headin">

                                    Days

                                </th>
                                <th class="table-headin">
                                    Total Sessions
                                </th>
                                <th class="table-headin">
                                    Events
                                </th>


                            </tr>
                            </thead>
                            <tbody>

                            <?php

                            $result= $database->query($sqlmain);

                            if($result->num_rows==0){
                                echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                            }
                            else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $scheduledate= date('d-M-Y' , strtotime($row["fromdate"])) .' - ' . date('d-M-Y' , strtotime($row["todate"]));
                                    $sqlTwo = "select COUNT(*) as slots from schedule_slots where schedule_id = ".$scheduleid;
                                    $sqlThree = "select COUNT(*) as booked from schedule_slots where schedule_id = ".$scheduleid." and patient_id IS NOT NULL";
                                    $resultTwo= $database->query($sqlTwo);
                                    $resultThree= $database->query($sqlThree);
                                    $class = 'var(--primarycolor)';
                                    if ($row['session_type'] == 'Panel') {
                                        $class = 'green';
                                    }

                                    $daysArray = [];

                                    if ($row["mon"] == 1) $daysArray[] = 'M';
                                    if ($row["tue"] == 1) $daysArray[] = 'Tu';
                                    if ($row["wed"] == 1) $daysArray[] = 'W';
                                    if ($row["thu"] == 1) $daysArray[] = 'Th';
                                    if ($row["fri"] == 1) $daysArray[] = 'F';
                                    if ($row["sat"] == 1) $daysArray[] = 'Sa';
                                    if ($row["sun"] == 1) $daysArray[] = 'Su';

                                    $days = implode(', ', $daysArray);
                                    echo '<tr>
                                        <td style="border-left: 7px solid '.$class.';"> &nbsp;'.
                                        $title
                                        .'</td>
                                        <td style="text-align:center;">
                                            '.$scheduledate.'
                                        </td>
                                        <td style="text-align:center;">
                                            '.$days.'
                                        </td>
                                        <td style="text-align:center;">
                                            '.$resultThree->fetch_assoc()['booked'] .' / '.$resultTwo->fetch_assoc()['slots'].'
                                        </td>
                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View Sessions</font></button></a>
                                        </div>
                                        </tdfromDate>
                                    </tr>';
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </center>
            </td>
        </tr>



    </table>
</div>
</div>
<?php

if($_GET){
    $id=$_GET["id"];
    $action=$_GET["action"];
    if($action=='add-session'){

        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    
                    
                        <a class="close" href="schedule.php">&times;</a> 
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                                <form action="add-session.php" method="POST" class="add-new-form">
                                <td class="label-td" colspan="2"></td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Session.</p><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <select name="docid" id="" class="box doctor" >
                                    <option value="" disabled selected hidden>Select Doctor</option><br/>';


        $list11 = $database->query("select  * from  doctor order by docname asc;");

        for ($y=0;$y<$list11->num_rows;$y++){
            $row00=$list11->fetch_assoc();
            $sn=$row00["docname"];
            $id00=$row00["docid"];
            echo "<option value=".$id00.">$sn</option><br/>";
        };
        echo     '       </select><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <select name="sessionType" id="" class="box sessionType">
                                    <option value="" disabled selected hidden>Select Type</option>
                                    <option value="Panel">Panel</option><br>
                                    <option value="Self Finance">Self Finance</option><br>
                                </select>
                                </td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="title" class="input-text sessionName" placeholder="Name of this Session" required disabled><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td">
                                    <label for="toDate" class="form-label">Start Date: </label>
                                    <input type="date" name="fromDate" class="input-text" min="'.date('Y-m-d').'" required>
                                </td>
                                <td class="label-td">
                                    <label for="date" class="form-label">End Date: </label>
                                    <input type="date" name="toDate" class="input-text" min="'.date('Y-m-d').'" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nop" class="form-label">Select Working Hours : </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table class="business-hours-table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="mon">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Monday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="mon_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="mon_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="mon_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="tue">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Tuesday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="tue_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="tue_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="tue_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="wed">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Wednesday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="wed_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="wed_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="wed_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="thu">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Thursday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="thu_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="thu_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="thu_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="fri">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Friday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="fri_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="fri_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="fri_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>

                                            <!-- Closed Days -->
                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="sat">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Saturday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="sat_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="sat_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="sat_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="sun">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    Sunday
                                                </td>
                                                <td style="display:inline-flex;">
                                                    <input type="time" class="input-text" name="sun_open" value="08:00">
                                                    <span> — </span>
                                                    <input type="time" class="input-text" name="sun_close" value="21:00">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="number" name="sun_nos" min="0" max="4" placeholder="No. of Sessions" style="width:15vh;" value="0"  required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                    <input type="submit" value="Save" class="login-btn btn-primary btn" name="shedulesubmit">
                                </td>
                
                            </tr>
                           
                            </form>
                            </tr>
                        </table>
                        </div>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>

            <style>
            
            .business-hours-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .business-hours-table td {
                padding: 10px;
                font-size: 16px;
            }

            .business-hours-table input[type="time"] {
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 14px;
                width: 100px;
                text-align: center;
            }

            .closed-text {
                color: gray;
                font-weight: bold;
            }
            </style>
            <script>
                $(document).ready(function() {
                    $(".doctor").on("change" , function() {
                        $(".sessionName").val($(this).find(":selected").text());
                    });
                    $(".sessionType").on("change" , function() {
                        $(".sessionName").val($(".doctor").find(":selected").text()+" - "+$(this).find(":selected").text());
                    });
                });
            </script>
            ';
    }elseif($action=='session-added'){
        $titleget=$_GET["title"];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Session Placed.</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        '.substr($titleget,0,40).' was scheduled.<br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
    }elseif($action=='drop'){
        $nameget=$_GET["name"];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>('.substr($nameget,0,40).').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-session.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
    }elseif ($action == 'view') {
        $sqlmain = "SELECT ss.*, CONCAT(p.pname, ' , ' , CASE 
            WHEN p.gender = 'Male' THEN 'M' 
            WHEN p.gender = 'Female' THEN 'F' 
            ELSE p.gender 
            END , ' , ' , CONCAT(
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, p.pdob, CURDATE()) > 0 
                    THEN CONCAT(TIMESTAMPDIFF(YEAR, p.pdob, CURDATE()), 'Y')
                WHEN TIMESTAMPDIFF(MONTH, p.pdob, CURDATE()) > 0 
                    THEN CONCAT(TIMESTAMPDIFF(MONTH, p.pdob, CURDATE()), 'M')
                ELSE 
                    CONCAT(TIMESTAMPDIFF(DAY, p.pdob, CURDATE()), 'D')
            END
            ), ' , ' , p.ptel) as patientname , p.mrn as mrn  FROM schedule_slots ss left join patient p on ss.patient_id = p.pid WHERE ss.schedule_id=$id";
$result = $database->query($sqlmain);

$schedule = "SELECT mon_fromtime, mon_totime, tue_fromtime, tue_totime, wed_fromtime, wed_totime, thu_fromtime, thu_totime, fri_fromtime, fri_totime, sat_fromtime, sat_totime, sun_fromtime, sun_totime FROM schedule WHERE scheduleid=$id";
$result2 = $database->query($schedule);
$record = $result2->fetch_assoc();

// Get the times for each weekday
$weekdayTimes = [
    'Monday' => ['from' => $record['mon_fromtime'], 'to' => $record['mon_totime']],
    'Tuesday' => ['from' => $record['tue_fromtime'], 'to' => $record['tue_totime']],
    'Wednesday' => ['from' => $record['wed_fromtime'], 'to' => $record['wed_totime']],
    'Thursday' => ['from' => $record['thu_fromtime'], 'to' => $record['thu_totime']],
    'Friday' => ['from' => $record['fri_fromtime'], 'to' => $record['fri_totime']],
    'Saturday' => ['from' => $record['sat_fromtime'], 'to' => $record['sat_totime']],
    'Sunday' => ['from' => $record['sun_fromtime'], 'to' => $record['sun_totime']],
];

$events = [];
while ($row = $result->fetch_assoc()) {
    $slots[] = $row;
}

$groupedSlots = [];
foreach ($slots as $slot) {
    $groupedSlots[$slot['appointment_date']][] = $slot;
}

foreach ($groupedSlots as $date => $dailySlots) {
    $totalSessions = count($dailySlots); // Number of sessions on this day

    // Determine the day of the week for the current date
    $dayOfWeek = date('l', strtotime($date));

    // Get the from and to time for this specific day
    $startTime = $weekdayTimes[$dayOfWeek]['from'];
    $endTime = $weekdayTimes[$dayOfWeek]['to'];

    $startTimeMinutes = (int)substr($startTime, 0, 2) * 60 + (int)substr($startTime, 3, 2);
    $endTimeMinutes = (int)substr($endTime, 0, 2) * 60 + (int)substr($endTime, 3, 2);
    $totalAvailableMinutes = $endTimeMinutes - $startTimeMinutes;
    $sessionDuration = ($totalSessions > 0) ? floor($totalAvailableMinutes / $totalSessions) : 60;

    $sessionStartMinutes = $startTimeMinutes; // Start from the day's session start time

    foreach ($dailySlots as $slot) {
        // Convert minutes to HH:MM format
        $sessionStartTime = sprintf('%02d:%02d:00', floor($sessionStartMinutes / 60), $sessionStartMinutes % 60);
        $sessionEndMinutes = $sessionStartMinutes + $sessionDuration;
        $sessionEndTime = sprintf('%02d:%02d:00', floor($sessionEndMinutes / 60), $sessionEndMinutes % 60);

        // Format datetime for FullCalendar
        $startDateTime = $date . 'T' . $sessionStartTime;
        $endDateTime = $date . 'T' . $sessionEndTime;

        // Store the event in the array
        $events[] = [
            'title' => !empty($slot['patientname']) ? $slot['patientname'] : "Available Session",
            'start' => $startDateTime,
            'end' => $endDateTime,
            'allDay' => false,
            'extendedProps' => [
                'patient' => $slot['patientname'] ?? '',
                'id' => $slot['id'],
                'mrn' => $slot['mrn'],
                'updated_by' => $slot['updated_by'],
                'created_at' => $slot['created_at'],
            ]
        ];

        // Update the start time for the next session
        $sessionStartMinutes = $sessionEndMinutes;
    }
    }

    echo '
    <div id="popup1" class="overlay">
        <div class="popup" style="width: 70%;">
        <button id="showPopupButton" class="btn-primary btn"  style="float:right;margin-top:50px;">+ Add Patient</button>
        <div id="patientPopup" class="overlay" style="display:none;">
        <div class="popup2">
            <center>
                <h2 style="font-family: Arial, sans-serif; color: #333;">Enter Patient MRN</h2>
                <a class="close" href="javascript:void(0)" onclick="closePopup()" style="color: #888; font-size: 30px; text-decoration: none;">&times;</a>
                <div class="content" style="margin-top: 20px; padding: 20px; width: 80%; max-width: 400px; border-radius: 10px; background-color: #f4f4f9;">
                    <label for="patientDetails" style="font-size: 16px; font-weight: bold; color: #444;">Patient Name:</label>
                    <input type="text" id="patientDetails" placeholder="Enter patient details" required
                        style="width: 100%; padding: 10px; margin-top: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
                    <br><br>
                    <button id="submitPatientDetails" style="padding: 10px 20px; background-color: #4CAF50; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                        Submit
                    </button>
                </div>
            </center>
        </div>
    </div>
    <center>
        <h2></h2>
        <a class="close" href="schedule.php">&times;</a>
        <div class="content"></div>
        <input type="hidden" id="sessionid" value='.$id.'>
        <div class="abc scroll" style="display: flex; justify-content: center;">
            <div id="calendar" style="width: 100%; margin: 50px auto;"></div>
            <!-- Calendar loaded dynamically -->
        </div>
    </center>
    <br><br>
    </div>
    </div>
    <script>
    document.getElementById("showPopupButton").addEventListener("click", function() {
        document.getElementById("patientPopup").style.display = "block";
    });
    function closePopup() {
        document.getElementById("patientPopup").style.display = "none";
    }
    document.getElementById("submitPatientDetails").addEventListener("click", function() {
        var patientDetails = document.getElementById("patientDetails").value;
        if (patientDetails.trim() === "") {
            alert("Please Enter Proper MRN.");
            return;
        }

        var sessionId = document.getElementById("sessionid").value; // Assuming session ID is already available
        $.ajax({
            url: "fetch-patient-appointment.php", 
            type: "POST",
            data: { 
                patient: patientDetails, 
                id: sessionId
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    alert("Appointment Scheduled Successfully!");
                    window.location.reload(); // Optionally reload the page to reflect changes
                } else {
                    alert("Something went wrong, please try again.");
                }
                closePopup(); // Close the popup after submission
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
                closePopup(); // Close the popup in case of an error
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var calendarEl = document.getElementById("calendar");
        var session = document.getElementById("sessionid").value;
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "listWeek",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
            },
            events: ' . json_encode($events) . ',
            eventDrop: function(info) {
                var newStart = info.event.start;
                var newEnd = info.event.end;
                var oldStart = moment(newStart).subtract(info.delta);
                var oldEnd = newEnd ? moment(newEnd).subtract(info.delta) : null;

                function formatDate(date) {
                    var year = date.getFullYear();
                    var month = (date.getMonth() + 1).toString().padStart(2,0);
                    var day = date.getDate().toString().padStart(2,0);
                    return `${year}-${month}-${day}`;
                }

                var newDate = formatDate(newStart);

                $.ajax({
                    url: "update-appointment.php", 
                    type: "POST",
                    data: { 
                        id: info.event.extendedProps.id,
                        newDate: newDate
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response) {
                            alert("Appointment Re-Scheduled Successfully!");
                        } else {
                            alert("Something went wrong, please try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error);
                        closePopup(); // Close the popup in case of an error
                    }
                });
            },
            eventContent: function (info) {
                if (info.view.type.startsWith("list")) {
                    return {
                        html: `<div style="display:flex; justify-content: space-between;">
                                    <span><strong>${info.event.extendedProps.patient}</strong></span>
                                    <span>${info.event.extendedProps.mrn == null ? "Available" : info.event.extendedProps.mrn}</span>
                                    <span>${info.event.extendedProps.mrn == null ? "" : info.event.extendedProps.updated_by}</span>
                                    <span>${info.event.extendedProps.mrn == null ? "" : info.event.extendedProps.created_at}</span>
                            </div>`
                    };
                }
            },
            editable: true,
            slotMinTime: "00:00:00",
            slotMaxTime: "23:59:00",
        });

        calendar.render();
    });
    </script>
    ';
    }
}

?>
</div>

</body>
</html>