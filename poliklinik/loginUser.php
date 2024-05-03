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
 
        <div class="row">
            <h2>login</h2>
                <label for="inputnama" class="form-label fw-bold">Name:</label><br>
                <input type="text" id="inputnama" name="nama"><br>
                <label for="pasword"class="form-label fw-bold">Password:</label><br>
                <input type="password" id="pasword" name="password"><br>
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="login">login islam</button>
        </div>
    

</form>
</div>

    

<script src="js/bootstrap.min.js"></script> 
</body>
</html>