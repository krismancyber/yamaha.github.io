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
  $updateSQL = sprintf("UPDATE jenis_produk SET Nama_Jenis_Produk=%s, Keterangan=%s WHERE Id_Jenis_Produk=%s",
                       GetSQLValueString($_POST['Nama_Jenis_Produk'], "text"),
                       GetSQLValueString($_POST['Keterangan'], "text"),
                       GetSQLValueString($_POST['Id_Jenis_Produk'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "jenis_produk.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=jenis_produk" />
<?php
}

$colname_ejenis = "-1";
if (isset($_GET['Id_Jenis_Produk'])) {
  $colname_ejenis = $_GET['Id_Jenis_Produk'];
}
mysql_select_db($database_konek, $konek);
$query_ejenis = sprintf("SELECT * FROM jenis_produk WHERE Id_Jenis_Produk = %s", GetSQLValueString($colname_ejenis, "text"));
$ejenis = mysql_query($query_ejenis, $konek) or die(mysql_error());
$row_ejenis = mysql_fetch_assoc($ejenis);
$totalRows_ejenis = mysql_num_rows($ejenis);
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
    <h4> Edit Data Jenis Produk</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%">
    <tr>
      <td width="18%">Id Jenis Produk</td>
      <td width="2%">:</td>
      <td width="80%"><label for="Id_Jenis_Produk"></label>
      <input name="Id_Jenis_Produk" type="text" placeholder="Id Jenis Produk" class="form-control" id="Id_Jenis_Produk" value="<?php echo $row_ejenis['Id_Jenis_Produk']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td>Nama Jenis Produk</td>
      <td>:</td>
      <td><label for="Nama_Jenis_Produk"></label>
      <input name="Nama_Jenis_Produk" type="text" placeholder="Nama Jenis Produk" class="form-control" id="Nama_Jenis_Produk" value="<?php echo $row_ejenis['Nama_Jenis_Produk']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td><label for="Keterangan"></label>
      <textarea name="Keterangan" placeholder="Keterangan" class="form-control" id="Keterangan" cols="45" rows="5"><?php echo $row_ejenis['Keterangan']; ?></textarea></td>
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
mysql_free_result($ejenis);
?>
