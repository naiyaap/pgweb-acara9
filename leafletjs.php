<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> WebGIS Kabupaten Sleman </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        body {
            background-color: #FFF8D4;
        }

        #map {
            width: 100%;
            height: 60vh; 
        }

        #informasi{
            text-align: right;
        }

        #title{
            margin-top: 40px;
            margin-bottom: 20px;
            text-align: center;
            background: linear-gradient(90deg, #F0E491, #31694E, #007bff);
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.8rem;
            letter-spacing: 1px;
        }

        table {
            text-align: center;
        }

        thead {
            background-color: #31694E;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #F5F5DC; 
        }

        tbody tr:hover {
            background-color: #E2F0CB; 
        }

    </style>
</head>
<body>
<h2 id="title">WebGIS Kabupaten Sleman</h2>

    <!-- Konten Utama -->
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" style="color: #31694E;">
                <h5>Informasi Kabupaten Sleman</h5>
                <p style="font-size: 0.9rem; text-align: justify;">
                    Kabupaten Sleman adalah salah satu kabupaten yang terletak di Daerah Istimewa Yogyakarta, Indonesia. Ibu kotanya berada di Kapanewon Sleman.
                    Secara geografis, Kabupaten Sleman terletak di antara 110° 13′ 00″ hingga 110° 33′ 00″ Bujur Timur dan 7° 34′ 51″ hingga 7° 47′ 30″ Lintang Selatan.
                    Bagian utara kabupaten ini merupakan kawasan pegunungan dengan puncak Gunung Merapi.
                    Pada tahun 2022, jumlah penduduk Kabupaten Sleman mencapai 1.147.562 jiwa dengan luas wilayah 574,82 km².
                    Sleman merupakan daerah dengan pertumbuhan ekonomi terbesar di Daerah Istimewa Yogyakarta dan memiliki banyak destinasi wisata menarik seperti Candi Prambanan dan Lava Tour Merapi.
                </p>
                <p style="font-size: 0.9rem; text-align: justify;">
                    Sleman dikenal sebagai "Kota Seribu Candi" karena banyaknya candi yang ditemukan di wilayah ini, baik yang besar maupun kecil. Selain itu, Sleman juga merupakan pusat pendidikan di Yogyakarta dengan banyaknya perguruan tinggi ternama. Wilayah ini memiliki potensi wisata yang beragam, mulai dari wisata alam di lereng Gunung Merapi, wisata budaya dengan berbagai candi, hingga wisata kuliner yang kaya rasa.
                </p>
            </div>
        </div>

        <!-- Tabel Data Kecamatan -->
        <div class="card shadow">
            <div class="card-header text-white" style="background-color:#31694E;">
                <h5 class="mb-0 text-center">Data Kecamatan Kabupaten Sleman</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kecamatan</th>
                                <th>Luas (km²)</th>
                                <th>Jumlah Penduduk</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Koneksi ke database
                            $conn = new mysqli("localhost", "root", "", "pgweb_acara8");
                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            $sql = "SELECT * FROM data_kecamatan";
                            $result = $conn->query($sql);
                            $no = 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>{$row['kecamatan']}</td>
                                            <td>{$row['luas']}</td>
                                            <td>{$row['jumlah_penduduk']}</td>
                                            <td>{$row['latitude']}</td>
                                            <td>{$row['longitude']}</td>
                                        </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada data kecamatan</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Kecamatan -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalLabel">Detail Kecamatan</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><strong>Kecamatan:</strong> <span id="namaKec"></span></p>
            <p><strong>Luas:</strong> <span id="luasKec"></span> km²</p>
            <p><strong>Jumlah Penduduk:</strong> <span id="pendudukKec"></span></p>
        </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Script Peta -->
    <script>
        var map = L.map('map').setView([-7.716, 110.355], 11);

        // Tambahkan basemap (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
        })
        .addTo(map);

        function showModal(nama, luas, penduduk) {
            document.getElementById("namaKec").textContent = nama;
            document.getElementById("luasKec").textContent = luas;
            document.getElementById("pendudukKec").textContent = penduduk;
            var modal = new bootstrap.Modal(document.getElementById('infoModal'));
            modal.show();
        }

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

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $kec = addslashes($row["kecamatan"]);
                $lat = $row["latitude"];
                $lon = $row["longitude"];
                $luas = $row["luas"];
                $pend = $row["jumlah_penduduk"];

                echo "L.marker([$lat, $lon])
                    .addTo(map)
                    .on('click', function() {
                            showModal('$kec', '$luas', '$pend');});\n";
            }
        }

        $conn->close();
        ?>

    </script>
</body>
</html>