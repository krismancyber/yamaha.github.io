<?php require_once('Connections/konek.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_konek, $konek);
$query_prd = "SELECT * FROM produk";
$prd = mysql_query($query_prd, $konek) or die(mysql_error());
$row_prd = mysql_fetch_assoc($prd);
$totalRows_prd = mysql_num_rows($prd);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(isset($_FILES['Foto']['name'])){
		$upload=$_FILES['Foto'];
		move_uploaded_file($upload['tmp_name'],"f_produk/".$upload['name']);
		$Foto=$upload['name'];
	}else{
		$Foto=Null;
	}
  $insertSQL = sprintf("INSERT INTO produk (Id_Produk, Id_Jenis_Produk, Type, Satuan_Produk, Harga_Lesing, Tenor_Bulan, Metode_Bayar, Foto) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id_Produk'], "text"),
                       GetSQLValueString($_POST['Id_Jenis_Produk'], "text"),
                       GetSQLValueString($_POST['Type'], "text"),
                       GetSQLValueString($_POST['Satuan_Produk'], "text"),
                       GetSQLValueString($_POST['Harga_Lesing'], "int"),
                       GetSQLValueString($_POST['Tenor_Bulan'], "text"),
                       GetSQLValueString($_POST['Metode_Bayar'], "text"),
                       GetSQLValueString($Foto, "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "produk.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=produk" />
<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form2" name="form2" method="post" action="">
  <div class="col-sm-9">
    <h4> Input Data Produk</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0">
    <tr>
      <td width="21%">No Mesin</td>
      <td width="1%">:</td>
      <td width="78%"><label for="Id_Produk"></label>
      <input name="Id_Produk" type="text" name="nama" placeholder="No Mesin" class="form-control" id="Id_Produk" size="20" /></td>
    </tr>
    <tr>
      <td height="35">Jenis Produk</td>
      <td>:</td>
      <td><label name="nama" for="Id_Jenis_Produk"></label>
        <select  placeholder="Jenis Produk" class="form-control" name="Id_Jenis_Produk">
        <option>-- Pilih Salah Satu --</option>
          <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM jenis_produk ORDER BY Nama_Jenis_Produk");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
          <option value="<?php echo $dt_mhs['Id_Jenis_Produk']; ?> : <?php echo $dt_mhs['Nama_Jenis_Produk']; ?>"><?php echo $dt_mhs['Id_Jenis_Produk']; ?> : <?php echo $dt_mhs['Nama_Jenis_Produk']; ?></option>
          <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="33">Type</td>
      <td>:</td>
      <td><label for="Type"></label>
      <input name="Type" type="text" placeholder="Type" class="form-control" id="Type" size="30" /></td>
    </tr>
    <tr>
      <td height="37">Satuan Produk</td>
      <td>:</td>
      <td><label for="Satuan_Produk"></label>
      <input name="Satuan_Produk" type="text" placeholder="Satuan Produk" class="form-control" id="Satuan_Produk" size="30" /></td>
    </tr>
    <tr>
      <td height="33">Harga Lesing</td>
      <td>:</td>
      <td><label for="Harga_Lesing"></label>
      <input name="Harga_Lesing" type="text" placeholder="Harga Lesing" class="form-control" id="Harga_Lesing" size="30" /></td>
    </tr>
    <tr>
      <td height="33">Tenor Bulan</td>
      <td>:</td>
      <td><label for="Tenor_Bulan"></label>
      <input name="Tenor_Bulan" type="text" placeholder="Bulan" class="form-control" id="Tenor_Bulan" size="30" /></td>
    </tr>
    <tr>
      <td height="33">Metode Bayar</td>
      <td>:</td>
      <td><label for="Metode_Bayar"></label>
        <select name="Metode_Bayar" placeholder="Metode Pembayaran" class="form-control" id="Metode_Bayar">
          <option value="Cash">Cash</option>
          <option value="Cicilan">Cicilan</option>
      </select></td>
    </tr>
    <tr>
      <td height="37">Foto Produk</td>
      <td>:</td>
      <td><label for="Foto"></label>
      <input type="file" name="Foto" placeholder="Foto" class="form-control" id="Foto" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" class="btn btn-success" id="button" value="Simpan" />
      <input type="reset" name="button2" class="btn btn-warning" id="button2" value="Batal" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td width="6%" align="center" bgcolor="#FF0000">No</td>
    <td width="9%" align="center" bgcolor="#FF0000">No Mesin</td>
    <td width="15%" align="center" bgcolor="#FF0000">Jenis Produk</td>
    <td width="15%" align="center" bgcolor="#FF0000">Type</td>
    <td width="16%" align="center" bgcolor="#FF0000">Satuan Produk</td>
    <td width="14%" align="center" bgcolor="#FF0000">Harga Lesing</td>
     <td width="15%" align="center" bgcolor="#FF0000">Tenor bulan</td>
      <td width="15%" align="center" bgcolor="#FF0000">Metode Bayar</td>
    <td width="12%" align="center" bgcolor="#FF0000">Foto</td>
    <td width="13%" align="center" bgcolor="#FF0000">Aksi </td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_prd['Id_Produk']; ?></td>
      <td><?php echo $row_prd['Id_Jenis_Produk']; ?></td>
      <td><?php echo $row_prd['Type']; ?></td>
      <td><?php echo $row_prd['Satuan_Produk']; ?></td>
      <td><?php echo $row_prd['Harga_Lesing']; ?></td>
      <td><?php echo $row_prd['Tenor_Bulan']; ?></td>
      <td><?php echo $row_prd['Metode_Bayar']; ?></td>
      <td><img src="f_produk/<?php echo $row_prd['Foto']; ?>"width="100" height="100" alt=""/></td>
      <td><a href="index.php?page=edit_produk&Id_Produk=<?php echo $row_prd['Id_Produk']; ?>"class="btn btn-primary" >Edit </a>-<a href="index.php?page=hapus_produk&Id_Produk=<?php echo $row_prd['Id_Produk']; ?>" class="btn btn-danger" >Hapus</a></td>
    </tr>
    <?php } while ($row_prd = mysql_fetch_assoc($prd)); ?>
</table>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($prd);
?>
