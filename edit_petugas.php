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
		move_uploaded_file($upload['tmp_name'],"f_pegawai/".$upload['name']);
	}
  $updateSQL = sprintf("UPDATE petugas SET Nama_Petugas=%s, Jabatan=%s, No_Telp=%s, Agama=%s, Jenkel=%s, Alamat=%s, Foto=%s WHERE NIK_Petugas=%s",
                       GetSQLValueString($_POST['Nama_Petugas'], "text"),
                       GetSQLValueString($_POST['Jabatan'], "text"),
                       GetSQLValueString($_POST['No_Telp'], "text"),
                       GetSQLValueString($_POST['Agama'], "text"),
                       GetSQLValueString($_POST['Jenkel'], "text"),
                       GetSQLValueString($_POST['Alamat'], "text"),
                       GetSQLValueString($upload['name'], "text"),
                       GetSQLValueString($_POST['NIK_Petugas'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "petugas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=petugas" />
<?php
}

$colname_edt = "-1";
if (isset($_GET['NIK_Petugas'])) {
  $colname_edt = $_GET['NIK_Petugas'];
}
mysql_select_db($database_konek, $konek);
$query_edt = sprintf("SELECT * FROM petugas WHERE NIK_Petugas = %s", GetSQLValueString($colname_edt, "text"));
$edt = mysql_query($query_edt, $konek) or die(mysql_error());
$row_edt = mysql_fetch_assoc($edt);
$totalRows_edt = mysql_num_rows($edt);
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
    <h4> Edit Data Petugas</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%">
    <tr>
      <td width="13%" height="33">NIK Petugas</td>
      <td width="2%">:</td>
      <td width="85%"><label for="NIK_Petugas"></label>
      <input name="NIK_Petugas" type="text" placeholder="NIK Petugas" class="form-control" id="NIK_Petugas" value="<?php echo $row_edt['NIK_Petugas']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="38">Nama Petugas</td>
      <td>:</td>
      <td><label for="Nama_Petugas"></label>
      <input name="Nama_Petugas" type="text" placeholder="Nama Petugas" class="form-control" id="Nama_Petugas" value="<?php echo $row_edt['Nama_Petugas']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="35">Jabatan</td>
      <td>:</td>
      <td><label for="Jabatan"></label>
      <input name="Jabatan" type="text" placeholder="Jabatan" class="form-control" id="Jabatan" value="<?php echo $row_edt['Jabatan']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="37">No.Telp</td>
      <td>:</td>
      <td><label for="No_Telp"></label>
      <input name="No_Telp" type="text" placeholder="No Telp" class="form-control" id="No_Telp" value="<?php echo $row_edt['No_Telp']; ?>" /></td>
    </tr>
    <tr>
      <td height="35">Agama</td>
      <td>:</td>
      <td><select name="Agama" placeholder="Agama" class="form-control" id="Agama">
        <option value="Islam" selected="selected">Islam</option>
        <option value="Katolik">Katolik</option>
        <option value="Kristen">Kristen</option>
        <option value="Hindu">Hindu</option>
        <option value="Buddha">Buddha</option>
      </select></td>
    </tr>
    <tr>
      <td height="33">Jenis Kelamin</td>
      <td>:</td>
      <td><label for="Jenkel"></label>
        <select name="Jenkel" placeholder="Jenis Kelamin" class="form-control" id="Jenkel">
          <option value="Pria">Pria</option>
          <option value="Wanita">Wanita</option>
      </select></td>
    </tr>
    <tr>
      <td height="96">Alamat</td>
      <td>:</td>
      <td><label for="Alamat"></label>
      <textarea name="Alamat" placeholder="Alamat" class="form-control" id="Alamat" cols="45" rows="5"><?php echo $row_edt['Alamat']; ?></textarea></td>
    </tr>
    <tr>
      <td height="45">Foto</td>
      <td>:</td>
      <td><label for="Foto"></label>
      <p><img src="f_pegawai/<?php echo $row_edt['Foto']; ?>"width="30"/></p>
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
mysql_free_result($edt);
?>
