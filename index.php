<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediaShare - Discover Movies</title>
    <link rel="stylesheet" href="PageFiles/Index/indexstyles.css">
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
    
    <div class="welcome-container">
        <h2>Welcome to MediaShare!</h2>
        <p>A platform for discovering and sharing movies.</p>
        <p>Check out some of our featured titles(WIP) below or use the search to find something specific.</p>
    </div>
    
    <div class="poster-container" id="posterContainer">
        <!-- Posters will be dynamically inserted here -->
    </div>
    
    <div class="footer">
        <div class="footer-section">
            <h3>Popular Categories</h3>
            <ul>
                <li><a href="#">Action</a></li>
                <li><a href="#">Comedy</a></li>
                <li><a href="#">Drama</a></li>
                <li><a href="#">Sci-Fi</a></li>
                <li><a href="#">Horror</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">New Releases</a></li>
                <li><a href="#">Top Rated</a></li>
                <li><a href="#">Coming Soon</a></li>
                <li><a href="#">Staff Picks</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Stay Connected</h3>
            <div class="social-icons">
                <a href="#" class="social-icon">FB</a>
                <a href="#" class="social-icon">TW</a>
                <a href="#" class="social-icon">IG</a>
                <a href="#" class="social-icon">YT</a>
            </div>
            <div class="newsletter">
                <h4>Subscribe to our newsletter</h4>
                <form id="newsletter-form">
                    <input type="email" placeholder="Your email address" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="copyright">
        <p>&copy; 2025 MediaShare. All rights reserved.</p>
        <nav class="footer-nav">
            <a href="#">Privacy Policy</a> | 
            <a href="#">Terms of Service</a> | 
            <a href="#">Contact Us</a>
        </nav>
    </div>
    
    <script src="PageFiles/Index/indexscript.js"></script>
</body>
</html>