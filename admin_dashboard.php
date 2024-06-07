
<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
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
    <link rel="stylesheet" href="code-css/admin_dashboard.css">
    <title>Admin Dashboard</title>
    

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
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="admin_dashboard.php">Halaman Utama</a>
        <a onclick="toggleProfile()">Profil</button>
        <div id="profileDetails" class="profile-details">
            <p>Admin :</p>
            <p><?php echo htmlspecialchars($username); ?></p>
        </div>
        <a href="dashboard.php">Logout</a>
    </div>

    <div class="main">
        <div class="search-bar">
            <input type="text" id="search" placeholder="Cari buku...">
        </div>


        <div class="admin-controls">
            <button onclick="addBook()">Tambah Buku</button>
            <button onclick="deleteBook()">Hapus Buku</button>
        </div>
        
        <div class="books-container" id="books-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="book-card">
                    <img src="<?php echo htmlspecialchars($row['sampul_buku']); ?>" alt="Sampul Buku">
                    <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                    <p><?php echo htmlspecialchars($row['penulis']); ?> (<?php echo htmlspecialchars($row['tahun_terbit']); ?>)</p>
                    <a href="<?php echo htmlspecialchars($row['tautan_resmi']); ?>" download>Lihat Selengkapnya ></a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script src="code-js/admin_dashboard.js"></script>
</body>
</html>

<?php
$conn->close();
?>