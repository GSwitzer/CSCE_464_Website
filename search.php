<?php
// Database connection
$host = 'localhost';
$port = '8889';  // MAMP default MySQL port
$dbname = 'media_lib'; // Your database name
$username = 'root';  // MAMP default username
$password = 'root';  // MAMP default password

try {
    // Create a PDO instance for MySQL connection with the correct port
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error handling
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Search functionality
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = htmlspecialchars($_POST['search']);
}

// Prepare SQL query to search the 'movies' table by title
$sql = "SELECT * FROM movies WHERE title LIKE :searchTerm";
$stmt = $pdo->prepare($sql);
$stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
$mediaItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="PageFiles/search/search.css">
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
   

    <!-- Search Form -->
    <form method="POST" class="search-bar">
        <input type="text" name="search" placeholder="Search for movies..." value="<?php echo $searchTerm; ?>" required>
        <button type="submit">Search</button>
    </form>

    <!-- Display Search Results -->
    <div class="media-list">
        <?php if (empty($mediaItems)): ?>
            <p>No media found. <a href="request.php" class="request-link">Click here to request an addition.</a></p>
        <?php else: ?>
            <?php foreach ($mediaItems as $media): ?>
                <div class="media-item">
                    <img src="<?php echo $media['thumbnail']; ?>" alt="Thumbnail">
                    <div class="details">
                        <a href="media.php?id=<?php echo $media['id']; ?>"><?php echo $media['title']; ?></a>
                        <p><?php echo $media['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>&copy; 2025 Media Sharing Website. All Rights Reserved.</p>
</footer>

<script src="PageFiles/search/search.js"></script>

</body>
</html>
