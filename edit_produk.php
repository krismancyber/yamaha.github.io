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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if ($_FILES['Foto']['error'] == 0) {
		$upload = $_FILES['Foto'];
		move_uploaded_file($upload['tmp_name'],"f_produk/".$upload['name']);
	}
  $updateSQL = sprintf("UPDATE produk SET Id_Jenis_Produk=%s, Type=%s, Satuan_Produk=%s, Harga_Lesing=%s, Tenor_Bulan=%s, Metode_Bayar=%s, Foto=%s WHERE Id_Produk=%s",
                       GetSQLValueString($_POST['Id_Jenis_Produk'], "text"),
                       GetSQLValueString($_POST['Type'], "text"),
                       GetSQLValueString($_POST['Satuan_Produk'], "text"),
                       GetSQLValueString($_POST['Harga_Lesing'], "int"),
                       GetSQLValueString($_POST['Tenor_Bulan'], "text"),
                       GetSQLValueString($_POST['Metode_Bayar'], "text"),
                       GetSQLValueString($upload['name'], "text"),
                       GetSQLValueString($_POST['Id_Produk'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "produk.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=produk" />
<?php
}

$colname_eprd = "-1";
if (isset($_GET['Id_Produk'])) {
  $colname_eprd = $_GET['Id_Produk'];
}
mysql_select_db($database_konek, $konek);
$query_eprd = sprintf("SELECT * FROM produk WHERE Id_Produk = %s", GetSQLValueString($colname_eprd, "text"));
$eprd = mysql_query($query_eprd, $konek) or die(mysql_error());
$row_eprd = mysql_fetch_assoc($eprd);
$totalRows_eprd = mysql_num_rows($eprd);
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
    <h4> Edit Data Produk</h4>
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
      <input name="Id_Produk" type="text" placeholder="No Mesin" class="form-control" id="Id_Produk" value="<?php echo $row_eprd['Id_Produk']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td height="35">Jenis Produk</td>
      <td>:</td>
      <td><label for="Id_Jenis_Produk"></label>
        <select placeholder="Jenis Produk" class="form-control" name="Id_Jenis_Produk" title="<?php echo $row_eprd['Id_Jenis_Produk']; ?>">
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
      <input name="Type" type="text" placeholder="Type" class="form-control" id="Type" value="<?php echo $row_eprd['Type']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="37">Satuan Produk</td>
      <td>:</td>
      <td><label for="Satuan_Produk"></label>
      <input name="Satuan_Produk" type="text" placeholder="Satuan Produk" class="form-control" id="Satuan_Produk" value="<?php echo $row_eprd['Satuan_Produk']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="33">Harga Lesing</td>
      <td>:</td>
      <td><label for="Harga_Lesing"></label>
      <input name="Harga_Lesing" type="text" placeholder="Harga Lesing" class="form-control" id="Harga_Lesing" value="<?php echo $row_eprd['Harga_Lesing']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="33">Tenor Bulan</td>
      <td>:</td>
      <td><label for="Tenor_Bulan"></label>
      <input name="Tenor_Bulan" type="text" placeholder="Bulan" class="form-control" id="Tenor_Bulan" value="<?php echo $row_eprd['Tenor_Bulan']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="33">Metode Bayar</td>
      <td>:</td>
      <td><label for="Metode_Bayar"></label>
        <select placeholder="Metode Bayar" class="form-control" name="Metode_Bayar" id="Metode_Bayar">
          <option value="Cash">Cash</option>
          <option value="Cicilan">Cicilan</option>
      </select></td>
    </tr>
    <tr>
      <td height="37">Foto Produk</td>
      <td>:</td>
      <td><label for="Foto"></label>
      <p><img src="f_produk/<?php echo $row_eprd['Foto']; ?>"width="30"/></p>
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
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($eprd);
?>
