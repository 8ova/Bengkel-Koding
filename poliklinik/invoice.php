<?php
include_once("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, 
        initial-scale=1.0">

        <!-- Bootstrap offline -->

        <link rel="stylesheet" href="assets/css/bootstrap.css"> 

        <!-- Bootstrap Online -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">   
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        <title>Poliklinik</title>   <!--Judul Halaman-->
        <style>
            .container {
                max-width: 600px;
            }
        </style>
    </head>
    <body>
    <?php
        $query = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'nama_dokter', d.alamat as dalamat, d.no_hp as dhp, p.nama as 'nama_pasien', p.alamat as palamat, p.no_hp as php FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) WHERE pr.id = ".$_GET['id']);
        $result = $query->fetch_assoc();
        $obats = mysqli_query($mysqli, "SELECT detail_periksa.*, obat.nama_obat as obats, obat.harga as harga FROM detail_periksa LEFT JOIN obat ON (obat.id = detail_periksa.id_obat) WHERE detail_periksa.id_periksa = ". $_GET['id']);
        $total_obat = 0;
    ?>
        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nota Pembayaran</h5>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>No. Periksa:</strong> #<?php echo $result['id'] ?></p>
                            <p><strong>Tanggal Periksa:</strong> <?php echo $result['tgl_periksa'] ?> </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Pasien:</strong> <?php echo $result['nama_pasien'] ?></p>
                            <p><?php echo $result['palamat'] ?></p>
                            <p><?php echo $result['php'] ?></p>
                        </div>
                        <div class="col-6">
                            <p><strong>Dokter:</strong> <?php echo $result['nama_dokter'] ?></p>
                            <p><?php echo $result['dalamat'] ?></p>
                            <p><?php echo $result['dhp'] ?></p>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($obats as $obat) {
                                    echo "
                                        <tr>
                                            <td> ". $obat['obats'] ." </td>
                                            <td> Rp ". number_format($obat['harga'], 0, ',', '.') .",00 </td>
                                        </tr>
                                    ";
                                }
                            ?>
                            <tr>
                                <td class="fw-bold">Jasa Dokter:</td>
                                <td class="fw-bold">Rp <?php echo number_format($jasa_doker, 0, ',', '.') ?>,00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="fw-bold">Subtotal Obat:</td>
                                <?php
                                    foreach ($obats as $obat) {
                                         $total_obat += $obat['harga'];
                                    }

                                    echo "<td>Rp ". number_format($total_obat, 0, ',', '.') .",00 </td>";
                                ?>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total:</td>
                                <td class="fw-bold">Rp <?php echo number_format($total_obat + $jasa_doker, 0, ',', '.') ?>,00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-MrcW6ZMFy8AnYj1LrwtP7aHsjmd5lZ5iZT6bYfgEFL9KJLXTtPkk+fNsi6Jp4p2y" 
                crossorigin="anonymous"></script>
    </body>
</html>