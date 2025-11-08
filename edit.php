<?php
$id = $_POST['id']; 
$kecamatan = $_POST['kecamatan']; 
$lat = $_POST['latitude']; 
$long = $_POST['longitude']; 
$luas = $_POST['luas']; 
$jumlah_penduduk = $_POST['jumlah_penduduk']; 

// Sesuaikan dengan setting MySQL 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "pgweb_acara8"; 

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection 
if ($conn->connect_error) { 
die("Connection failed: " . $conn->connect_error); 
} 

$sql = "UPDATE data_kecamatan SET kecamatan='$kecamatan', longitude=$long, 
latitude=$lat, luas=$luas, jumlah_penduduk=$jumlah_penduduk WHERE id=$id"; 

if ($conn->query($sql) === TRUE) { 
echo "Record edited successfully"; 
} else { 
echo "Error: " . $sql . "<br>" . $conn->error; 
} 
$conn->close(); 

header("Location: ... /index.php"); 
exit; 
?>