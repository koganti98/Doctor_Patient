<?php
// Start the session if not already started
session_start();

// Include the server.php file for database connection and other functions
include('C:\xampp\htdocs\Doctor_Patient\datalayer\server.php');

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['UserID'])) {
    header('Location: http://localhost/Doctor_Patient/applicationlayer/Doctorpatient.php');
    exit();
}

// Establish a new database connection
$mysqli = new mysqli("localhost", "root", "", "registration");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch user data from the database
$userId = $_SESSION['UserID'];
$query = "SELECT * FROM patients WHERE UserID = '$userId'";
$result = mysqli_query($mysqli, $query);

// Check if the query is successful and fetch user data
if (!$result) {
    die("Error executing query: " . mysqli_error($mysqli));
}

$col = mysqli_fetch_assoc($result);

// Fetch treatment history data
$treatmentQuery = "SELECT * FROM patients WHERE UserID = '$userId'";
$treatmentResult = mysqli_query($mysqli, $treatmentQuery);

if (!$treatmentResult) {
    die("Error fetching treatment history: " . mysqli_error($mysqli));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Patient</title>
    <link rel="stylesheet" href="style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
</head>

<header>
    <h1>Doctor<span>Patient</span></h1>
    <nav>
        <ul>
            <li><a href="index.php">MyInfo</a></li>
            <li><a href="book.php">Book Appointment</a></li>
            <li><a href="view.php">View Appointment</a></li>
            <li><a href="cancel.php">Cancel Booking</a></li>
            <li><a href="searchdoctor.php">Search Doctor</a></li>
            <li><a href="donate.php">Donate Organ</a></li>
            <li><a href="searchdonor.php">Search Donor</a></li>
            <li><a href="http://localhost/Doctor_Patient/applicationlayer/Doctorpatient.php">Logout</a></li>
        </ul>
    </nav>
</header>

<body>
    <div class="headerP" style="width: 15%; margin-top: 60px; color: white; background: #39ca74; text-align: center; border-radius: 10px 10px 5px 5px; border-bottom: none; border: 1px solid #39ca74; padding: 10px; margin-left: -4px ">
        <h2>My Information</h2>
    </div>

    <form method="post" action="index.php" class="infoP" style="margin-left: -1px; margin-top: 0px; width: 40%; padding: 20px; border: 3px solid #39ca74; background: white; border-radius: 10px 10px 10px 10px;">

        <div class="contentP" style="font-weight: bold;">
            <label>ID: <?php echo isset($col['UserID']) ? $col['UserID'] : ''; ?></label>
            <br><br>
            <label>Email: <?php echo isset($col['Email']) ? $col['Email'] : ''; ?></label>
            <br><br>
            <label>Name: <?php echo isset($col['Name']) ? $col['Name'] : ''; ?></label>
            <br><br>
            <label>Address: <?php echo isset($col['Address']) ? $col['Address'] : ''; ?></label>
            <br><br>
            <label>Contact Number: <?php echo isset($col['ContactNumber']) ? $col['ContactNumber'] : ''; ?></label>
            <br><br>
            <label>Blood Type: <?php echo isset($col['Bloodtype']) ? $col['Bloodtype'] : ''; ?></label>
            <br><br>
        </div>

        <div class="input-group">
            <button type="submit" name="treatmentHistory" class="btn" style="border-radius: 5px; margin-left: 80%; border: none; padding: 10px 20px 10px 20px">My Treatment History</button>
        </div>

        <div class="input-group">
            <button type="submit" name="feedback" class="btn" style="border-radius: 5px; margin-left: 80%; border: none; padding: 10px 30px 10px 30px">Send Feedback</button>
        </div>

    </form>

    <?php
    if (isset($_POST['treatmentHistory'])) {
        // Display treatment history data
        while ($treatmentRow = mysqli_fetch_assoc($treatmentResult)) {
            ?>
            <div class="infoP" style="margin-left: -1px; margin-top: 10px; width: 20%; padding: 10px; border: 3px solid #39ca74; background: white; border-radius: 10px 10px 10px 10px;">
                <?php
                // Check if keys exist before accessing them
                if (isset($treatmentRow['TreatmentDate'])) {
                    echo '<label>Treatment Date: ' . $treatmentRow['TreatmentDate'] . '</label><br><br>';
                }
                if (isset($treatmentRow['DoctorName'])) {
                    echo '<label>Doctor: ' . $treatmentRow['DoctorName'] . '</label><br><br>';
                }
                if (isset($treatmentRow['Diagnosis'])) {
                    echo '<label>Diagnosis: ' . $treatmentRow['Diagnosis'] . '</label><br><br>';
                }
                if (isset($treatmentRow['Prescription'])) {
                    echo '<label>Prescription: ' . $treatmentRow['Prescription'] . '</label>';
                }
                ?>
            </div>
            <?php
        }
    }
    ?>

    <!-- ... (Remaining HTML code remains unchanged) -->

</body>

</html>
