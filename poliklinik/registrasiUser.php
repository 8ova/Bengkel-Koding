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
    
    <title>poliklinik</title>   <!--Judul Halaman-->
 
</head>
<body>
<div class='container'>
<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <!-- Kode php untuk menghubungkan form dengan database -->
    <?php
    $nama = '';
    $pasword = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, 
        "SELECT * FROM user 
        WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $nama = $row['nama'];
            $pasword = $row['pasword'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo
        $_GET['id'] ?>">
    <?php
    }
    ?>
    
        <div class="row">
            <h2>Sign Up</h2>
                <label for="inputnama" class="form-label fw-bold">Name:</label><br>
                <input type="text" id="inputnama" name="nama"><br>
                <label for="pasword"class="form-label fw-bold">Password:</label><br>
                <input type="password" id="pasword" name="password"><br>
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="Sign Up">sign up</button>
        </div>
    

</form>
</div>

    

<script src="js/bootstrap.min.js"></script> 
</body>
</html>