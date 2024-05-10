<!-- Файл submit_review.php -->
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish connection to MySQL
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $database = "autoservice";
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters
    $sql = "INSERT INTO Reviews (CarID, UserID, Rating, Comment, ReviewDate) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $car_id, $user_id, $rating, $comment);

    // Set parameters and execute
    $car_id = $_POST["car_id"];
    $user_id = $_POST["user_id"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();


}
?>
