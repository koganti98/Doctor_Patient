<?php
session_start();
include '../../datalayer/bookserver.php';

$mysqli = new mysqli("localhost", "root", "", "registration");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$doctorprofile = isset($_SESSION['DoctorID']) ? $_SESSION['DoctorID'] : null;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor</title>
    <link rel="stylesheet" href="style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
</head>

<header>
    <h1>Doctor<span>Patient</span></h1>
    <nav>
        <ul>
            <li><a href="index2.php">My Info</a></li>
            <li><a href="doctorapp.php">My Appointments</a></li>
            <li><a href="searchpatient.php">Search Patient</a></li>
            <li><a href="add.php">Add Description</a></li>
            <li><a href="../../applicationlayer/Doctorpatient.php">Logout</a></li>
        </ul>
    </nav>
</header>

<body>
    <h1 class="my1">My<span class="mys">Appointments</span></h1>

    <table class="table2">
        <tr>
            <th>Appointment ID</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>PatientID</th>
            <th>PatientName</th>
            <th>PatientAddress</th>
            <th>PatientEmail</th>
            <th>PatientContactNumber</th>
            <th>BloodGroup</th>
        </tr>

        <?php
        $sqldoc = "SELECT * FROM bookapp, patients WHERE docID = ('$doctorprofile') AND patientID = UserID";
        
        $resultdoc = $mysqli->query($sqldoc);

        if ($resultdoc && mysqli_num_rows($resultdoc) >= 1) {
            while ($rowdoc = $resultdoc->fetch_assoc()) {
                echo "<tr><td>" . $rowdoc["AppoID"] . "</td><td>" . $rowdoc["Date"] . "</td><td>" . $rowdoc["Time"] . "</td><td>" . $rowdoc["UserID"] . "</td><td>" . $rowdoc['Name'] . "</td><td>" . $rowdoc['Address'] . "</td><td>" . $rowdoc['Email'] . "</td><td>" . $rowdoc["ContactNumber"] . "</td><td>" . $rowdoc["Bloodtype"] . "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "No appointments found.";
        }
        ?>

    </table>
</body>
</html>

