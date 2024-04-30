<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Showroom</title>
</head>
<body>
    <h2>Contact Us</h2>
    <form method="POST" action="process_form.php">
        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phonenumber" name="phonenumber" pattern="[0-9]{10}" maxlength="10" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" maxlength="100" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" maxlength="500" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
    
    if (!empty($successMessage)) {
        echo "<p>$successMessage</p>";
    }
    ?>
</body>
</html>