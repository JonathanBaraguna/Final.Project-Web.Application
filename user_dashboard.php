
<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "login_user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from the database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="code-css/user_dashboard.css">
</head>

<body>

    <div class="navbar">
        <div class="menu-toggle" onclick="openNav()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="navbar-brand">BookVerse</div>
    </div>


    <div id="mySidebar" class="sidebar">
        <a href="#" class="closebtn" onclick="closeNav()">x</a>
        <a href="user_dashboard.php">Halaman Utama</a>
        <a onclick="toggleProfile()">Profil</a>
        <div id="profileDetails" class="profile-details">
            <p>Username :</p>
            <p><?php echo htmlspecialchars($username); ?></p>
        </div>
        <a href="dashboard.php">Logout</a>
        
    </div>


    <div class="main">
        <div class="search-bar">
            <input type="text" id="search" placeholder="Cari buku...">
        </div>
        
        <div class="books-container" id="books-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="book-card">
                    <img src="<?php echo $row['sampul_buku']; ?>" alt="Sampul Buku">
                    <h3><?php echo $row['judul']; ?></h3>
                    <p><?php echo $row['penulis']; ?> (<?php echo $row['tahun_terbit']; ?>)</p>
                    <a href="<?php echo $row['tautan_resmi']; ?>" download>Lihat Selengkapnya</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="code-js/user_dashboard.js"></script>

</body>
</html>

<?php
$conn->close();
?>