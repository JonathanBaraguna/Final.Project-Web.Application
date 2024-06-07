<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$bookDetails = "";
$bookList = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (isset($_POST['view_details'])) {
        // Proses form untuk melihat detail buku
        $book_id = $_POST['book_id'];
        $sql = "SELECT judul, penulis, sampul_buku FROM books WHERE id='$book_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $bookDetails = "Judul Buku: " . htmlspecialchars($row['judul']) . "<br>Penulis: " . htmlspecialchars($row['penulis']) . "<br><img src='" . htmlspecialchars($row['sampul_buku']) . "' alt='Sampul Buku' style='width:100px;height:auto;'>";
        } else {
            $bookDetails = "Buku tidak ditemukan.";
        }
    }

    if (isset($_POST['delete_book'])) {
        // Proses form penghapusan buku
        $book_id = $_POST['book_id'];

        // Hapus file sampul buku dari server
        $sql = "SELECT sampul_buku FROM books WHERE id='$book_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sampul_buku_path = $row['sampul_buku'];
            if (file_exists($sampul_buku_path)) {
                unlink($sampul_buku_path);
            }
        }

        // Hapus data dari database
        $sql = "DELETE FROM books WHERE id='$book_id'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Buku berhasil dihapus.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}

// Mendapatkan daftar semua buku
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

$sql = "SELECT id, judul, penulis, sampul_buku FROM books";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bookList[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Buku</title>
    <link rel="stylesheet" href="code-css/delete_book.css">
    
</head>
<body>
    <h2>Hapus Buku</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="book_id">ID Buku:</label><br>
        <input type="number" id="book_id" name="book_id" required><br><br>
        <input type="submit" name="view_details" value="Lihat Detail Buku">
    </form>
    



    <div class="informasi">
    <?php
    if (!empty($bookDetails)) {
        echo "<h3>Detail Buku</h3>";
        echo "<p>$bookDetails</p>";
    }
    ?>

    <?php
    if (!empty($bookDetails) && strpos($bookDetails, 'Judul Buku') !== false) {
        echo '
        <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
            <input type="hidden" name="book_id" value="'.htmlspecialchars($_POST['book_id']).'">
            <input type="submit" name="delete_book" value="Hapus">
        </form>
        ';
    }
    ?>
    </div>




    <h2>Daftar Buku Tersedia</h2>
    <div class="search-box">
        <input type="text" id="searchTerm" placeholder="Cari buku..." onkeyup="searchBooks()">
    </div>
    <div class="scroll-box">
        <table id="bookTable">
            <thead>
                <tr>
                    <th>ID Buku</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Sampul Buku</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($bookList)) {
                    foreach ($bookList as $book) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($book['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($book['judul']) . "</td>";
                        echo "<td>" . htmlspecialchars($book['penulis']) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($book['sampul_buku']) . "' alt='Sampul Buku' style='width:100px;height:auto;'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada buku yang tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="kembali">
    <button onclick="location.href='admin_dashboard.php'">Kembali</button>
    </div>
    <script src="code-js/delete_book.js"></script>
</body>
</html>