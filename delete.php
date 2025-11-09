<?php
$id = $_GET['id']; 

  //Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pgweb_acara8";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    //Cek koneksi
    if($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    //DELETE FROM table_name WHERE condition; 
    $sql = "DELETE FROM data_kecamatan WHERE id = $id"; 

    if ($conn->query($sql) === TRUE) { 
    echo "Record with id = $id deleted successfully"; 
    } else { 
    echo "Error: " . $sql . "<br>" . $conn->error; 
    } 
    $conn->close();

    header("Location: index.php"); 
    exit; 
  
?>