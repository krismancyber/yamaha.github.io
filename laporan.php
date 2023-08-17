<?php require_once('Connections/konek.php'); ?>
<?php
error_reporting(0);
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
if ($_POST) {
	$cbocari=$_POST['cbocari'];
	$txtcari=$_POST['txtcari'];
mysql_select_db($database_konek, $konek);
$query_lpverif = "SELECT * FROM verifikasi_prospek where $cbocari LIKE '%$txtcari%'";
$lpverif = mysql_query($query_lpverif, $konek) or die(mysql_error());
$row_lpverif = mysql_fetch_assoc($lpverif);
$totalRows_lpverif = mysql_num_rows($lpverif);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hasil Laporan</title>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
Cari Data Berdasarkan
  <label for="cbocari"></label>
  <select name="cbocari" placeholder="Cari" class="form-control" id="cbocari">
    <option value="Id_Konsumen">Nama Konsumen</option>
  </select>
  <label for="txtcari"></label>
  <input type="text" name="txtcari" placeholder="Cari Data" class="form-control" id="txtcari" />
  <input type="submit" name="button" class="btn btn-success" id="button" value="Cari Data" />
</form>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td width="3%" align="center" bgcolor="#FF0000">No</td>
    <td width="13%" align="center" bgcolor="#FF0000">Id Verifikasi</td>
    <td width="13%" align="center" bgcolor="#FF0000">Tanggal Verifikasi</td>
    <td width="13%" align="center" bgcolor="#FF0000">Nama Petugas</td>
    <td width="13%" align="center" bgcolor="#FF0000">Nama Konsumen</td>
    <td width="14%" align="center" bgcolor="#FF0000">Type Produk</td>
    <td width="10%" align="center" bgcolor="#FF0000">Status Berkas</td>
    <td width="14%" align="center" bgcolor="#FF0000">Keterangan</td>
    <td width="7%" align="center" bgcolor="#FF0000">Aksi</td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_lpverif['Id_Prospek']; ?></td>
      <td><?php echo $row_lpverif['Tanggal_Prospek']; ?></td>
      <td><?php echo $row_lpverif['NIK_Petugas']; ?></td>
      <td><?php echo $row_lpverif['Id_Konsumen']; ?></td>
      <td><?php echo $row_lpverif['Id_Produk']; ?></td>
      <td><?php echo $row_lpverif['Id_Berkas']; ?></td>
      <td><?php echo $row_lpverif['Keterangan_Prospek']; ?></td>
      <td><a href="h_laporan.php?Id_Prospek=<?php echo $row_lpverif['Id_Prospek']; ?>" target="_blank" class="btn btn-primary">Cetak</a></td>
    </tr>
    <?php } while ($row_lpverif = mysql_fetch_assoc($lpverif)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($lpverif);
?>
