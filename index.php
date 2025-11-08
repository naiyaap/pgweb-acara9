<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
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

    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        echo "<table border='1px'>
                <tr>
                <th>ID</th>
                <th>Nama Kecamatan</th>
                <th>Luas</th>
                <th>Jumlah Penduduk</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th colspan='2'>Aksi</th>
                </tr>";

        //output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['kecamatan'] . "</td>
                    <td>" . $row['luas'] . "</td>
                    <td>" . $row['jumlah_penduduk'] . "</td>
                    <td>" . $row['longitude'] . "</td>
                    <td>" . $row['latitude'] . "</td>
                    <td><a href='delete.php?id=" . $row['id'] . "'>hapus</a></td>
                    <td><a href='index2.php?id=" . $row['id'] . "'>edit</a></td>
                    </tr>";
        }
        echo "</table>";
    } 
    
    else {
        echo "0 hasil";
    }

    $conn->close();
    ?>
</body>
</html>