<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>PIC-MTI</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link href="../css/bootstrap.min.css" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <link href="../css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/app.min.css" id="app-stylesheet" rel="stylesheet" type="text/css" />

        <style>
            html, body {
            height: 100%;
            overflow: hidden;
            }
            #wrapper {
            height: 100%;
            }
            .content-page, .content, .container {
            height: 100%;
            }
            .scrollable-row {
            height: calc(100vh - 300px);
            overflow-y: auto;
            }
            .scrollable-row2 {
            height: calc(100vh - 300px);
            overflow-y: auto;
            }
        </style>
    </head>
    <body>

        <div id="wrapper">
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <div class="sortable">
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <h1>Add New Patient</h1>
                                    </center>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-2">
                                    <label >Search Patient : </label>
                                    <input type="text" class="form-control mrn" />
                                </div>
                                <div class="col-sm-2">
                                    <label style="color:transparent;">.</label>
                                    <button class="form-control btn btn-primary searchPatient">Search Patient</button>
                                </div>
                                
                                <div class="col-sm-3">
                                    <br>
                                    <label>MRN : </label> &nbsp;<label class="mrnlbl"></label>
                                    <br>
                                    <label>Name : </label> &nbsp;<label class="namelbl"></label>
                                </div>
                                <div class="col-sm-2">
                                    <label >Procedure : </label>
                                    <select class="form-control procedure">
                                        <option value="TVCAD">TVCAD</option>
                                        <option value="AVR">AVR</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label style="color:transparent;">.</label>
                                    <button class="form-control btn btn-danger addPatient">Add Patient</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-5">
                                    <center><label for="">Patients Queue</label></center>
                                    <div class="row scrollable-row"></div>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <center><label for="">Surgery Queue</label></center>
                                    <div class="row scrollable-row2"></div>
                                </div>
                            </div>
                            
                        </div><!-- Sortable -->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->
            </div>
        </div>

    </body>
    <script src="../vendor.min.js"></script>
    <script src="../jquery-ui.min.js"></script>
    <script src="../draggable.init.js"></script>
    <script src="../app.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".scrollable-row2").sortable({
                update: function(event, ui) {
                    var updatedCards = [];
                    $(".scrollable-row2 .card").each(function(index) {
                        var originalId = $(this).data("id");
                        updatedCards.push({
                            id: originalId,
                            newPosition: index + 1
                        });
                    });
                    console.log();
                    $.ajax({
                        url: "patient-functions.php",
                        type: "POST",
                        data: {
                            type: "SEQUENCE_CHANGE",
                            data: JSON.stringify(updatedCards)
                        },
                        dataType: "json",
                        success: function(response) {
                            loadPatients()
                        },
                        error: function(xhr, status, error) {
                            loadPatients()
                        }
                    });

                }
            });
            loadPatients();
            let patient;
            $(".searchPatient").on('click' , function() {
                $(this).html(' Please Wait .... ');
                $.ajax({
                    url: "fetch-patient-appointment.php", 
                    type: "POST",
                    data: { 
                        patient: $(".mrn").val(), 
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".searchPatient").html(' Search Patient ');
                        patient = response;
                        $(".mrnlbl").html(patient.mrn);
                        $(".namelbl").html(patient.name +" " +patient.father_name);
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error);
                        $(".searchPatient").html(' Search Patient ');
                    }
                });
            });
            $(".addPatient").on('click' , function() {
                $(this).html(' Please Wait .... ');
                $.ajax({
                    url: "add-patient.php", 
                    type: "POST",
                    data: { 
                        patient: patient,
                        procedure: $(".procedure").val()
                    },
                    dataType: "json",
                    success: function(response) {
                        loadPatients();
                        $(this).html(' Add Patient ');
                        alert("Patient Added Successfully");
                    },
                    error: function(xhr, status, error) {
                        alert("Patient Added Successfully");
                        $(this).html(' Add Patient ');
                    }
                });
            });

            $(".addPatient").on('click' , function() {
                $(this).html(' Please Wait .... ');
                $.ajax({
                    url: "add-patient.php", 
                    type: "POST",
                    data: { 
                        patient: patient,
                        procedure: $(".procedure").val()
                    },
                    dataType: "json",
                    success: function(response) {
                        loadPatients();
                        $(this).html(' Add Patient ');
                        alert("Patient Added Successfully");
                    },
                    error: function(xhr, status, error) {
                        alert("Patient Added Successfully");
                        $(this).html(' Add Patient ');
                    }
                });
            });

            $("body").on('click', '.disablePtn' , function() {
                let id = $(this).attr('data-id');
                let disable = $(this).attr('data-disable');
                $.ajax({
                    url: "patient-functions.php",
                    type: "POST",
                    data: {
                        type: 'DISABLE',
                        id: id,
                        disable: disable,
                    },
                    dataType: "json",
                    success: function(response) {
                        loadPatients()
                    },
                    error: function(xhr, status, error) {
                        loadPatients()
                    }
                });
            });

            $("body").on('click', '.surgeryCall' , function() {
                let id = $(this).attr('data-id');
                $.ajax({
                    url: "patient-functions.php",
                    type: "POST",
                    data: {
                        type: 'SURGERY_CALL',
                        id: id,
                    },
                    dataType: "json",
                    success: function(response) {
                        loadPatients()
                    },
                    error: function(xhr, status, error) {
                        loadPatients()
                    }
                });
            });
        });

        function loadPatients() {
            $(".scrollable-row").empty();
            $(".scrollable-row2").empty();

            $.ajax({
                url: "get-patients.php", 
                type: "GET",
                dataType: "json",
                success: function(response) {
                    response.forEach((value) => {
                        let disabled = value.disable == 1 ? 'disabled' : '';
                        let classs = value.disable == 1 ? 'success' : 'danger';
                        let btn = value.disable == 1 ? 'Enable' : 'Disable';
                        $(".scrollable-row").append(`
                            <div class="col-md-12">
                                <div class="card card-draggable">
                                    <div class="card-body">
                                        <h4 class="card-title">`+value.id+`). `+value.patient_name+` , `+value.age+`Y , `+value.gender+` , `+value.mrn+` </h4>
                                        <p class="card-text">
                                            Procedure : `+value.proced+`<br>
                                            Contact : `+value.contact+`<br>
                                            Address : `+value.address+` `+value.country+`<br>
                                        </p>
                                        <button class='btn btn-success surgeryCall' data-id=`+value.id+` style="float:right;" `+disabled+`>Call for Surgery</button>
                                        <button class='btn btn-`+classs+` disablePtn' data-id=`+value.id+` data-disable=`+(value.disable == 1 ? 0 : 1)+` style="float:left;">`+btn+`</button>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                    var $scrollableDiv = $('.scrollable-row');
                    $scrollableDiv.scrollTop($scrollableDiv.prop("scrollHeight"));
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });

            $.ajax({
                url: "get-surgery-patients.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    response.forEach((value) => {
                        $(".scrollable-row2").append(`
                            <div class="col-md-12">
                                <div class="card card-draggable" data-id=`+value.id+`>
                                    <div class="card-body">
                                        <h4 class="card-title">`+value.updated_sequence+`). `+value.patient_name+` , `+value.age+`Y , `+value.gender+` , `+value.mrn+` </h4>
                                        <p class="card-text">
                                            Procedure : `+value.proced+`<br>
                                            Contact : `+value.contact+`<br>
                                            Address : `+value.address+` `+value.country+`<br>
                                        </p>
                                        <button class='btn btn-success' data-id=`+value.id+` style="float:right;">Completed</button>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                    var $scrollableDiv = $('.scrollable-row2');
                    $scrollableDiv.scrollTop($scrollableDiv.prop("scrollHeight"));
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
    </script>
</html>