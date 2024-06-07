<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses form penambahan buku
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $deskripsi = $_POST['deskripsi'];
    $penerbit = $_POST['penerbit'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $bahasa = $_POST['bahasa'];
    $tautan_resmi = $_POST['tautan_resmi'];
    $sampul_buku = $_FILES['sampul_buku']['name'];
    $sampul_buku_temp = $_FILES['sampul_buku']['tmp_name'];
    
    // Path untuk menyimpan file sampul buku
    $upload_dir = 'sampul/';
    $sampul_buku_path = $upload_dir . basename($sampul_buku);

    if (move_uploaded_file($sampul_buku_temp, $sampul_buku_path)) {
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

        $sql = "INSERT INTO books (judul, penulis, tahun_terbit, deskripsi, penerbit, jumlah_halaman, bahasa, tautan_resmi, sampul_buku) VALUES ('$judul', '$penulis', '$tahun_terbit', '$deskripsi', '$penerbit', '$jumlah_halaman', '$bahasa', '$tautan_resmi', '$sampul_buku_path')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Buku berhasil ditambahkan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buku</title>
    <link rel="stylesheet" href="code-css/add_book.css">
</head>
<body>
    <h2>Tambah Data Buku</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="judul">Judul:</label><br>
        <input type="text" id="judul" name="judul" required><br>
        <label for="penulis">Penulis:</label><br>
        <input type="text" id="penulis" name="penulis" required><br>
        <label for="tahun_terbit">Tahun Terbit:</label><br>
        <input type="number" id="tahun_terbit" name="tahun_terbit" required><br>
        <label for="deskripsi">Deskripsi:</label><br>
        <textarea id="deskripsi" name="deskripsi" rows="4" cols="50"></textarea><br>
        <label for="penerbit">Penerbit:</label><br>
        <input type="text" id="penerbit" name="penerbit"><br>
        <label for="jumlah_halaman">Jumlah Halaman:</label><br>
        <input type="number" id="jumlah_halaman" name="jumlah_halaman"><br>
        <label for="bahasa">Bahasa:</label><br>
        <input type="text" id="bahasa" name="bahasa"><br>
        <label for="tautan_resmi">Tautan Resmi:</label><br>
        <input type="url" id="tautan_resmi" name="tautan_resmi"><br>
        <label for="sampul_buku">Sampul Buku:</label><br>
        <input type="file" id="sampul_buku" name="sampul_buku" accept="image/*" required><br><br>
        <input type="submit" value="Tambah">
    </form>
    
    <div class="kembali">
    <button onclick="location.href='admin_dashboard.php'">Kembali</button>
    </div>
</body>
</html>