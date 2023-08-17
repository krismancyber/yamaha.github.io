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

$colname_hlapor = "-1";
if (isset($_GET['Id_Prospek'])) {
  $colname_hlapor = $_GET['Id_Prospek'];
}
mysql_select_db($database_konek, $konek);
$query_hlapor = sprintf("SELECT * FROM verifikasi_prospek WHERE Id_Prospek = %s", GetSQLValueString($colname_hlapor, "text"));
$hlapor = mysql_query($query_hlapor, $konek) or die(mysql_error());
$row_hlapor = mysql_fetch_assoc($hlapor);
$totalRows_hlapor = mysql_num_rows($hlapor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hasil Laporan</title>
</head>

<body onload="print()">
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
  <table width="107%" height="149" border="0" align="center" dir="ltr">
    <tr>
      <td width="13%"><input type="image" name="imageField" id="imageField" src="alfa.png" /></td>
      <td width="87%" align="center" valign="middle"><h1>Laporan Data Prospek Konsumen Pada </h1>
        <h1>PT. ALFA SCORPII Yamaha</h1>
      <h1>Pematangsiantar</h1></td>
    </tr>
  </table>
</form>
<hr/>
<p>&nbsp;</p>
<table width="100%" border="3">
  <tr>
    <td width="4%" align="center" bgcolor="#FF0000">No</td>
    <td width="10%" align="center" bgcolor="#FF0000">Id Verifikasi</td>
    <td width="13%" align="center" bgcolor="#FF0000">Tanggal Verifikasi</td>
    <td width="15%" align="center" bgcolor="#FF0000">Nama Petugas</td>
    <td width="17%" align="center" bgcolor="#FF0000">Nama Konsumen</td>
    <td width="14%" align="center" bgcolor="#FF0000">Type Produk</td>
    <td width="14%" align="center" bgcolor="#FF0000">Status Berkas</td>
    <td width="13%" align="center" bgcolor="#FF0000">Keterangan</td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_hlapor['Id_Prospek']; ?></td>
      <td><?php echo $row_hlapor['Tanggal_Prospek']; ?></td>
      <td><?php echo $row_hlapor['NIK_Petugas']; ?></td>
      <td><?php echo $row_hlapor['Id_Konsumen']; ?></td>
      <td><?php echo $row_hlapor['Id_Produk']; ?></td>
      <td><?php echo $row_hlapor['Id_Berkas']; ?></td>
      <td><?php echo $row_hlapor['Keterangan_Prospek']; ?></td>
    </tr>
    <?php } while ($row_hlapor = mysql_fetch_assoc($hlapor)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" height="201" border="0">
  <tr>
    <td width="69%">&nbsp;</td>
    <td width="31%" valign="top"><p>Pematangsiantar, <?php echo date ('d M Y'); ?><br />
      Diketahui Oleh : <br />
      Direktur</p>
      <p>&nbsp;</p>
      <p>........................<br />
        NIP. ................ </p></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($hlapor);
?>
