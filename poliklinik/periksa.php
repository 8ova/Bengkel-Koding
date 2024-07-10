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
 
</head>

<body>
<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
<div class="form-group mx-sm-3 mb-2">
    <label for="inputPasien" class="sr-only">Pasien</label>
    <select class="form-control" name="id_pasien">
        <?php
        $selected = '';
        $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
        while ($data = mysqli_fetch_array($pasien)) {
            if ($data['id'] == $id_pasien) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $data['id'] ?>" 
            <?php echo $selected ?>><?php echo $data['nama'] ?>
        </option>
        <?php
        }
        ?>
    </select>
</div>

<div class="form-group mx-sm-3 mb-2">
    <label for="inputdokter" class="sr-only">dokter</label>
    <select class="form-control" name="id_dokter">
        <?php
        $selected = '';
        $pasien = mysqli_query($mysqli, "SELECT * FROM dokter");
        while ($data = mysqli_fetch_array($pasien)) {
            if ($data['id'] == $id_pasien) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $data['id'] ?>" 
            <?php echo $selected ?>><?php echo $data['nama'] ?>
        </option>
        <?php
        }
        ?>
    </select>
</div>


    <?php
        $tgl_periksa = '';
        $catatan = '';
        $obat = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, 
            "SELECT * FROM periksa 
            WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $tgl_periksa = $row['tgl_periksa'];
                $catatan = $row['catatan'];
                $obat = $row['obat'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo
            $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="col-12">
            <label for="inputTanggalperiksa" class="form-label fw-bold">
            Tanggal periksa
            </label>
            <input type="date" class="form-control" name="tgl_periksa" id="inputTanggalperiksa" placeholder="Tanggal Periksa" value="<?php echo $tgl_periksa ?>">
        </div>
        <div class="col-12">
            <label for="inputCatatan" class="form-label fw-bold">
                Catatan
            </label>
            <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan" value="<?php echo $catatan ?>">
        </div>
        <div class="col-12">
            <label for="inputObat" class="form-label fw-bold">
                obat
            </label>

            <div class="dropdown-content">
                <select class="form-select" id="obat" name="obats[]" multiple="multiple" aria-label="Select Obat">
                    <?php
                        $selected = '';
                        $detail_obat = [];
                        if (isset($_GET['id'])) {
                            $details = mysqli_query($mysqli, "SELECT id_obat FROM detail_periksa WHERE id_periksa='" . $_GET['id'] . "'");
                            if ($details->num_rows > 0) {
                                while($row = $details->fetch_assoc()) {
                                    $detail_obat[] = (int) $row["id_obat"];
                                }
                            }
                        }

                        $obats = mysqli_query($mysqli, "SELECT * FROM obat");
                        foreach ($obats as $obat) {
                            if (in_array($obat['id'], $detail_obat)) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            echo "<option ".$selected." value=". $obat['id'] .">" . ucfirst($obat['nama_obat']) . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-12">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
</form>

<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Nama Dokter</th>
            <th scope="col">Tanggal periksa</th>
            <th scope="col">Catatan</th>
            <th scope="col">Obat</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>

<?php
$result = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
$no = 1;
while ($data = mysqli_fetch_array($result)) {
?>
    <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $data['nama_pasien'] ?></td>
        <td><?php echo $data['nama_dokter'] ?></td>
        <td><?php echo $data['tgl_periksa'] ?></td>
        <td><?php echo $data['catatan'] ?></td>
        <td><?php 
            $query = mysqli_query($mysqli, "SELECT COUNT(id) as data FROM detail_periksa WHERE id_periksa = ". $data['id'] );
            $last = mysqli_fetch_assoc($query);
            $obats = mysqli_query($mysqli, "SELECT detail_periksa.*, obat.nama_obat as obats  FROM detail_periksa LEFT JOIN obat ON (obat.id = detail_periksa.id_obat) WHERE detail_periksa.id_periksa = ". $data['id']);
            $i = 1;
            foreach ($obats as $obat) {
                if ($i < $last['data']) {
                    echo $obat['obats']."/ ";
                }else{
                    echo $obat['obats'];
                }
                $i++;
            }
        ?></td>
        <td>
            <a class="btn btn-success rounded-pill px-3" 
            href="index.php?page=periksa&id=<?php echo $data['id'] ?>">
            Ubah</a>
            <a class="btn btn-danger rounded-pill px-3" 
            href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
            <a class="btn btn-warning rounded-pill px-3" 
            href="index.php?page=invoice&id=<?php echo $data['id'] ?>">Nota</a>
        </td>
    </tr>
<?php
}
?>
    </tbody>
</table>
<?php
            if (isset($_POST['simpan'])) {
                if (isset($_POST['id'])) {
                    $ubah = mysqli_query($mysqli, "UPDATE periksa SET 
                                                id_pasien = '" . $_POST['id_pasien'] . "',
                                                id_dokter = '" . $_POST['id_dokter'] . "',
                                                tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                                catatan = '" . $_POST['catatan'] . "'
                                                WHERE
                                                id = '" . $_POST['id'] . "'");
                    if ($ubah){
                        $last_id = $_POST['id'];
                        $hapus = mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id_periksa = '" . $_POST['id'] . "'");
                        foreach ($_POST['obats'] as $value) {
                            $insert_detail = mysqli_query($mysqli, " INSERT INTO detail_periksa (id_periksa, id_obat)
                            VALUES(
                                '". $last_id ."',
                                '". $obat ."'
                            )");
                        }
                    }
                } else {
                    $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_pasien,id_dokter,tgl_periksa,catatan) 
                                                VALUES ( 
                                                    '" . $_POST['id_pasien'] . "',
                                                    '" . $_POST['id_dokter'] . "',
                                                    '" . $_POST['tgl_periksa'] . "',
                                                    '" . $_POST['catatan'] . "'
                                                    )");

                    if ($tambah){
                        $last_id = mysqli_insert_id($mysqli);
                        foreach ($_POST['obats'] as $obat) {
                            $insert_detail = mysqli_query($mysqli, " INSERT INTO detail_periksa (id_periksa, id_obat)
                            VALUES(
                                '". $last_id ."',
                                '". $obat ."'
                            )");
                        }
                    }
                }
                
                echo "<script> 
                        document.location='index.php?page=periksa';
                        </script>";
            }
            if (isset($_GET['aksi'])) {
                if ($_GET['aksi'] == 'hapus') {
                    $hapus = mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id_periksa = '" . $_GET['id'] . "'");
                    $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
                }
                echo "<script> 
                        document.location='index.php?page=periksa';
                        </script>";
            }
        ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#obat').select2({
                placeholder: "Select Obat",
                allowClear: true
            });
        });
    </script>
</body>
</html>