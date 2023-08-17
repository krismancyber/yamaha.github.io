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
  $insertSQL = sprintf("INSERT INTO jenis_produk (Id_Jenis_Produk, Nama_Jenis_Produk, Keterangan) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['Id_Jenis_Produk'], "text"),
                       GetSQLValueString($_POST['Nama_Jenis_Produk'], "text"),
                       GetSQLValueString($_POST['Keterangan'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "jenis_produk.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=jenis_produk" />
<?php
}

mysql_select_db($database_konek, $konek);
$query_jns = "SELECT * FROM jenis_produk";
$jns = mysql_query($query_jns, $konek) or die(mysql_error());
$row_jns = mysql_fetch_assoc($jns);
$totalRows_jns = mysql_num_rows($jns);
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
    <h4> Input Data Jenis Produk</h4>
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
      <input name="Id_Jenis_Produk" type="text" placeholder=" Id Jenis Produk" class="form-control" id="Id_Jenis_Produk" size="20" /></td>
    </tr>
    <tr>
      <td>Nama Jenis Produk</td>
      <td>:</td>
      <td><label for="Nama_Jenis_Produk"></label>
      <input name="Nama_Jenis_Produk" type="text" placeholder=" Nama Jenis Produk" class="form-control" id="Nama_Jenis_Produk" size="30" /></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td><label for="Keterangan"></label>
      <textarea name="Keterangan" placeholder="Keterangan" class="form-control" id="Keterangan" cols="45" rows="5"></textarea></td>
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
    <td width="5%" align="center" bgcolor="#FF0000">No</td>
    <td width="25%" align="center" bgcolor="#FF0000">Id Jenis Produk</td>
    <td width="37%" align="center" bgcolor="#FF0000">Nama Jenis Produk</td>
    <td width="21%" align="center" bgcolor="#FF0000">Keterangan</td>
    <td width="12%" align="center" bgcolor="#FF0000">Aksi</td>
    
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_jns['Id_Jenis_Produk']; ?></td>
      <td><?php echo $row_jns['Nama_Jenis_Produk']; ?></td>
      <td><?php echo $row_jns['Keterangan']; ?></td>
      <td bgcolor="#FFFFFF"><a href="index.php?page=edit_jenis&Id_Jenis_Produk=<?php echo $row_jns['Id_Jenis_Produk']; ?>" class="btn btn-primary">Edit</a> - <a href="index.php?page=hapus_jenis&Id_Jenis_Produk=<?php echo $row_jns['Id_Jenis_Produk']; ?>" class="btn btn-danger">Hapus</a></td>
      
    </tr>
    <?php } while ($row_jns = mysql_fetch_assoc($jns)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($jns);
?>
