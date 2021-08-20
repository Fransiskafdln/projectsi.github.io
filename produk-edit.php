<?php
    session_start();
    include 'db.php';
    $produk = mysqli_query($conn, "SELECT * FROM d_produk WHERE produk_id = '".$_GET['id']."' ");
    $p = mysqli_fetch_object($produk);

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Quicksand:wght@300;400&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>


	<title> Edit Produk</title>
</head>

<body>
 <!-- Header -->
 <Header>
     <div class="container">
     <h1>
         <a href="">Admin SKM Adv</a>
        </h1>
        <ul>
            <li> <a href="dashboard.php">Dashboard</a></li>
            <li> <a href="pesanan.php">Pesanan</a></li>
            <li> <a href="kategori-data.php">Data Kategori</a></li>
            <li> <a href="produk-data.php">Data Produk</a></li>
            <li> <a href="keluar.php">Logout</a></li>
        </ul>
     </div>
 </Header>

 <!-- Konten -->

 <div class="section">
     <div class="container">
         <h3> Edit Produk </h3>
         <div class="box">
            <form action="" method="POST" enctype="multipart/form-data">
               <select class="input-control" name="kategori" required>
                   <option value=""> -- Pilih --</option>
                   <?php
                   include 'db.php';
                     $kategori = mysqli_query($conn, "SELECT * FROM d_kategori ORDER BY kategori_id DESC");
                     while($r = mysqli_fetch_array($kategori)) {


                   ?>
                   <option value=" <?php echo $r['kategori_id'] ?>" <?php echo($r['kategori_id'] == $p->kategori_id)?'
                   selected' :'';?>> <?php echo $r['kategori_name'] ?> </option>
                   <?php }?>

               </select>

                <input type="text" name="nama" class="input-control" placeholder="Nama Produk" value="<?php echo $p->produk_nama ?>" required>
                <input type="text" name="harga" class="input-control" placeholder="Harga"value="<?php echo $p->produk_harga ?>" required>

                <img src="produk/<?php echo $p->produk_img?>" alt="" width="250px">
                <input type="hidden" name="foto" value="<?php echo $p->produk_img ?>">
                <input type="file" name="gambar" class="input-control">
                <textarea class="input-control" name="deskripsi" placeholder="Deskripsi" ><?php echo $p->produk_deskripsi ?> </textarea><br>
                <select class="input-control" name="status">
                    <option value=""> -- Pilih --</option>
                    <option value="1" <?php echo($p->produk_status == 1)? 'selected': ''; ?>>Aktif</option>
                    <option value="0" <?php echo($p->produk_status == 0)? 'selected': ''; ?>> Tidak Aktif</option>
                </select>
                
                <input type="submit" name="submit" value="ADD" class="btn"> 
            </form>
            <?php
            include 'db.php';
            $produk = mysqli_query($conn, "SELECT * FROM d_produk WHERE produk_id = '".$_GET['id']."' ");
            $p = mysqli_fetch_object($produk);
                if(isset($_POST['submit'])) {
                // data inputan dari form
                $kategori   = $_POST['kategori'];
                $nama       = $_POST['nama'];
                $harga      = $_POST['harga'];
                $deskripsi  = $_POST['deskripsi'];
                $status     = $_POST['status'];
                $foto       = $_POST['foto'];

                // data gambar yang baru
                $filename = $_FILES['gambar'] ['name'];
                $tmp_name = $_FILES['gambar'] ['tmp_name'];

                

                // jika admin ganti gambar
                if($filename != ''){
                    $type1 = explode('.', $filename);
                    $type2 =$type1[1];

                    $newname = 'produk' .time(). '.' .$type2;

                    // menampung data format file yang diizinkan
                    $tipe_diizinkan = array('jpg','jpeg','png','gif');

                    // validasi format file

                    if(!in_array($type2, $tipe_diizinkan)){
                    
                    // jika format file tidak ada di dallam tipe diizinkan
                    echo '<script> alert("FORMAT FILE TIDAK DIIZINKAN")</script>';

                    }else{
                        unlink('./produk/'.$foto);
                        move_uploaded_file($tmp_name, './produk/' .$newname); 
                        $namagambar = $newname;
                    }
          
                }else{
                    // jika admin tidak ganti gambar
                    $namagambar = $foto;
                   
                }

                // query update data produk
                $update = mysqli_query($conn, "UPDATE d_produk SET 
                                        kategori_id = '".$kategori."',
                                        produk_nama = '".$nama."',
                                        produk_harga = '".$harga."',
                                        produk_deskripsi = '".$deskripsi."',
                                        produk_img = '".$namagambar."',
                                        produk_status = '".$status."'
                                        WHERE produk_id = '".$p->produk_id."' ");
                 if ($update) {
                    echo '<script>alert("Ubah Data Berhasil")</script>';
                    echo'<script> window.location="produk-data.php"</script>';
                } else {
                    echo 'gagal' .mysqli_error($conn);
                }

            }
        ?>
       
     </div>
 </div>
</div>


 <!-- Footer -->
 <footer>
    <div class="container">
        <small> Copyright &copy 2021 Saka Karya Maju Advertising </small>
    </div>
 </footer>


<html>
        <head>
                <meta charset="utf-8">
                <title>CKEditor</title>
                <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
        </head>
        <body>
                <textarea name="editor1"></textarea>
                <script>
                        CKEDITOR.replace( 'deskripsi' );
                </script>
        </body>
</html>

</body>
</html>