<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "showroom";

// Create a connection to the MySQL database
$conn = mysqli_connect($server, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$fullname = $phonenumber = $email = $subject = $message = "";
$fullnameErr = $phonenumberErr = $emailErr = $subjectErr = $messageErr = "";
$successMessage = "";

// Function to sanitize user input
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate and sanitize each field
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fullname"])) {
        $fullnameErr = "Full Name is required";
    } else {
        $fullname = sanitize_input($_POST["fullname"]);
    }

    if (empty($_POST["phonenumber"])) {
        $phonenumberErr = "Phone Number is required";
    } else {
        // Validate phone number format
        if (!preg_match("/^[0-9]{10}$/", $_POST["phonenumber"])) {
            $phonenumberErr = "Invalid phone number format";
        } else {
            $phonenumber = sanitize_input($_POST["phonenumber"]);
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        // Validate email address
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $email = sanitize_input($_POST["email"]);
        }
    }

    if (empty($_POST["subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $subject = sanitize_input($_POST["subject"]);
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = sanitize_input($_POST["message"]);
    }

    // If no errors, insert data into database and send email notification
    if (empty($fullnameErr) && empty($phonenumberErr) && empty($emailErr) && empty($subjectErr) && empty($messageErr)) {
        $sql = "INSERT INTO contact_form (fullname, phonenumber, email, subject, message, ip_address) 
                VALUES ('$fullname', '$phonenumber', '$email', '$subject', '$message', '{$_SERVER['REMOTE_ADDR']}')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Form submitted successfully";

            // Send email notification to site owner
            $to = "owner@example.com"; // Change this to the actual email address of the site owner
            $subject = "New Form Submission";
            $message = "A new form submission has been received.\n\n";
            $message .= "Name: $fullname\n";
            $message .= "Phone Number: $phonenumber\n";
            $message .= "Email: $email\n";
            $message .= "Subject: $subject\n";
            $message .= "Message: $message\n";

        
            $headers = "From: webmaster@example.com" . "\r\n" .
                "Reply-To: $email" . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

            
            mail($to, $subject, $message, $headers);

            
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close database connection
$conn->close();
?>