<?php
include ('connexion/test_connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email already exists in the database
    $check_query = "SELECT * FROM email_subscribers WHERE email = '$email'";
    $result = $connexion->query($check_query);

    if ($result->num_rows > 0) {
        // If email already exists in the subscription list
        $response = array("message" => "Your email address is already subscribed.", "icon" => 2);
        echo json_encode($response);
    } else {
        // Prepare SQL query to add the email
        $sql = "INSERT INTO email_subscribers (email) VALUES ('$email')";

        // Execute the query
        if ($connexion->query($sql) === TRUE) {
            // Insertion success
            $response = array("message" => "You have been added to the subscription list.", "icon" => 1);
            echo json_encode($response);
        } else {
            // Insertion error
            $response = array("message" => "Error adding to subscription list: " . $connexion->error, "icon" => 2);
            echo json_encode($response);
        }
    }

    // Close the connection
    $connexion->close();
}