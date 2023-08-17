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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO verifikasi_prospek (Id_Prospek, Tanggal_Prospek, NIK_Petugas, Id_Konsumen, Id_Produk, Id_Berkas, Keterangan_Prospek) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id_Prospek'], "text"),
                       GetSQLValueString($_POST['Tanggal_Prospek'], "date"),
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($_POST['Id_Produk'], "text"),
                       GetSQLValueString($_POST['Id_Berkas'], "text"),
                       GetSQLValueString($_POST['Keterangan_Prospek'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "verifikasi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=verifikasi" />
<?php
}

mysql_select_db($database_konek, $konek);
$query_verfi = "SELECT * FROM verifikasi_prospek";
$verfi = mysql_query($query_verfi, $konek) or die(mysql_error());
$row_verfi = mysql_fetch_assoc($verfi);
$totalRows_verfi = mysql_num_rows($verfi);
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
    <h4> Input Data Verifikasi Deal</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr>
      <td width="21%" height="44">Id Verifikasi</td>
      <td width="1%">:</td>
      <td width="78%"><label for="Id_Prospek"></label>
      <input name="Id_Prospek" type="text" placeholder="Id Verifikasi" class="form-control" id="Id_Prospek" size="20" /></td>
    </tr>
    <tr>
      <td height="39">Tanggal Verifikasi</td>
      <td>:</td>
      <td><label for="Tanggal_Prospek"></label>
      <input name="Tanggal_Prospek" type="date" placeholder="Tanggal" class="form-control" id="Tanggal_Prospek" size="30" /></td>
    </tr>
    <tr>
      <td height="45">Nama Petugas</td>
      <td>:</td>
      <td><select placeholder="Nama Petugas" class="form-control" name="NIK_Petugas">
        <option>-- Pilih Salah Satu --</option>
        <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM petugas ORDER BY Nama_Petugas");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
        <option value="<?php echo $dt_mhs['NIK_Petugas']; ?> : <?php echo $dt_mhs['Nama_Petugas']; ?>"><?php echo $dt_mhs['NIK_Petugas']; ?> : <?php echo $dt_mhs['Nama_Petugas']; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="47">Nama Konsumen</td>
      <td>:</td>
      <td><label for="Id_Konsumen"></label>
        <select  placeholder="Nama Konsumen" class="form-control" name="Id_Konsumen">
        <option>-- Pilih Salah Satu --</option>
        <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM konsumen ORDER BY Nama_Konsumen");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
        <option value="<?php echo $dt_mhs['Id_Konsumen']; ?> : <?php echo $dt_mhs['Nama_Konsumen']; ?>"><?php echo $dt_mhs['Id_Konsumen']; ?> : <?php echo $dt_mhs['Nama_Konsumen']; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="58">Type Produk</td>
      <td>:</td>
      <td><label for="Id_Produk"></label>
        <select  placeholder="Type Produk" class="form-control" name="Id_Produk">
        <option>-- Pilih Salah Satu --</option>
        <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM produk ORDER BY Type");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
        <option value="<?php echo $dt_mhs['Id_Produk']; ?> : <?php echo $dt_mhs['Type']; ?>"><?php echo $dt_mhs['Id_Produk']; ?> : <?php echo $dt_mhs['Type']; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="39">Status Berkas</td>
      <td>:</td>
      <td><label for="Id_Berkas"></label>
        <select  placeholder="Status Berkas" class="form-control" name="Id_Berkas">
        <option>-- Pilih Salah Satu --</option>
        <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM berkas ORDER BY Status_Berkas");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
        <option value="<?php echo $dt_mhs['Id_Berkas']; ?> : <?php echo $dt_mhs['Status_Berkas']; ?>"><?php echo $dt_mhs['Id_Berkas']; ?> : <?php echo $dt_mhs['Status_Berkas']; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="149">Keterangan </td>
      <td>:</td>
      <td><label for="Keterangan_Prospek"></label>
      <textarea placeholder="Keterangan" class="form-control" name="Keterangan_Prospek" id="Keterangan_Prospek" cols="45" rows="5"></textarea></td>
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
    <td width="3%" align="center" bgcolor="#FF0000">No</td>
    <td width="10%" align="center" bgcolor="#FF0000">Id Verifikasi</td>
    <td width="13%" align="center" bgcolor="#FF0000">Tanggal Verifikasi</td>
    <td width="13%" align="center" bgcolor="#FF0000">Nama Petugas</td>
    <td width="14%" align="center" bgcolor="#FF0000">Nama Konsumen</td>
    <td width="12%" align="center" bgcolor="#FF0000">Type Produk</td>
    <td width="12%" align="center" bgcolor="#FF0000">Status Berkas</td>
    <td width="13%" align="center" bgcolor="#FF0000">Keterangan</td>
    <td width="10%" align="center" bgcolor="#FF0000">Aksi</td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_verfi['Id_Prospek']; ?></td>
      <td><?php echo $row_verfi['Tanggal_Prospek']; ?></td>
      <td><?php echo $row_verfi['NIK_Petugas']; ?></td>
      <td><?php echo $row_verfi['Id_Konsumen']; ?></td>
      <td><?php echo $row_verfi['Id_Produk']; ?></td>
      <td><?php echo $row_verfi['Id_Berkas']; ?></td>
      <td><?php echo $row_verfi['Keterangan_Prospek']; ?></td>
      <td><a href="index.php?page=edit_verifikasi&Id_Prospek=<?php echo $row_verfi['Id_Prospek']; ?>" class="btn btn-primary" >Edit</a> - <a href="index.php?page=hapus_verifikasi&Id_Prospek=<?php echo $row_verfi['Id_Prospek']; ?>" class="btn btn-danger" >Hapus</a></td>
    </tr>
    <?php } while ($row_verfi = mysql_fetch_assoc($verfi)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($verfi);
?>
