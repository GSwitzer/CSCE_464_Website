<?php
// Handle the request submission logic if needed (moon runes but it works?)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mediaTitle = htmlspecialchars(trim($_POST['title']));
    $mediaDescription = htmlspecialchars(trim($_POST['description']));
    $userEmail = htmlspecialchars(trim($_POST['email']));
    
    // Input validation
    if (empty($mediaTitle) || empty($mediaDescription) || empty($userEmail)) {
        $errorMessage = "Please fill in all fields (Title, Description, and Email).";
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    } else {
        // Check for image upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Image validation
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $imageType = $_FILES['image']['type'];

            if (!in_array($imageType, $allowedTypes)) {
                $errorMessage = "Please upload a valid image file (JPEG, PNG, or GIF).";
            } else {
                // Generate a unique filename to avoid overwriting
                $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
                $targetDir = "uploads/"; // Folder where images will be saved
                $imagePath = $targetDir . $imageName;

                // Move the uploaded image to the target directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    // Successfully uploaded the image
                    $imageMessage = "Image uploaded successfully.";
                } else {
                    $errorMessage = "There was an issue uploading the image.";
                }
            }
        }

        // email content
        $to = "youremail@example.com";  // Change this email when ready
        $subject = "New Media Request: $mediaTitle";
        $message = "A new media request has been made.\n\nTitle: $mediaTitle\nDescription: $mediaDescription\nUser Email: $userEmail\n";

        if ($imagePath) {
            $message .= "Image Path: $imagePath\n";
        }

        $headers = "From: no-reply@mediasite.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8";

        // Send email
        if (mail($to, $subject, $message, $headers)) {
            $successMessage = "Your request for '$mediaTitle' has been submitted successfully!";
        } else {
            $errorMessage = "There was an issue submitting your request. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request New Media</title>
    <link rel="stylesheet" href="PageFiles/request/request.css">
</head>
<body>

 <div class="header">
        <a href="index.php"><h1>MediaShare</h1></a>
        <nav class="main-nav">
            <a href="search.php">Search</a> | 
            <a href="request.php">Request</a>
        </nav>
        <nav class="profile-nav">
            <a href="profile.php">Profile</a>
        </nav>
    </div>

<div class="container">
   

    <!-- Display success or error message -->
    <?php if (isset($successMessage)): ?>
        <p class="success-message"><?= $successMessage ?></p>
    <?php elseif (isset($errorMessage)): ?>
        <p class="error-message"><?= $errorMessage ?></p>
    <?php endif; ?>

    <form method="POST" class="request-form" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required></textarea>

    <label for="email">Your Email:</label>
    <input type="email" id="email" name="email" required>

    <!-- Image upload input -->
    <label for="image">Optional Image Upload:</label>
    <input type="file" id="image" name="image" accept="image/*">

    <button type="submit">Submit Request</button>
</form>

    <p><a href="index.php">Go back to the home page</a></p>
</div>

</body>
</html>
