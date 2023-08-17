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
		move_uploaded_file($upload['tmp_name'],"f_konsumen/".$upload['name']);
	}
  $updateSQL = sprintf("UPDATE konsumen SET NIK=%s, NIK_Pemilik=%s, Nama_Konsumen=%s, Nama_Pemilik=%s, Agama=%s, Jenis_Kelamin=%s, No_HP=%s, Alamat_Lengkap=%s, Foto=%s WHERE Id_Konsumen=%s",
                       GetSQLValueString($_POST['NIK'], "int"),
                       GetSQLValueString($_POST['NIK_Pemilik'], "int"),
                       GetSQLValueString($_POST['Nama_Konsumen'], "text"),
                       GetSQLValueString($_POST['Nama_Pemilik'], "text"),
                       GetSQLValueString($_POST['Agama'], "text"),
                       GetSQLValueString($_POST['Jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['No_Hp'], "text"),
                       GetSQLValueString($_POST['Alamat_Lengkap'], "text"),
                       GetSQLValueString($upload['name'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "konsumen.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=konsumen" />
<?php
}

$colname_eknsm = "-1";
if (isset($_GET['Id_Konsumen'])) {
  $colname_eknsm = $_GET['Id_Konsumen'];
}
mysql_select_db($database_konek, $konek);
$query_eknsm = sprintf("SELECT * FROM konsumen WHERE Id_Konsumen = %s", GetSQLValueString($colname_eknsm, "text"));
$eknsm = mysql_query($query_eknsm, $konek) or die(mysql_error());
$row_eknsm = mysql_fetch_assoc($eknsm);
$totalRows_eknsm = mysql_num_rows($eknsm);
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
    <h4> Edit Data Konsumen</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0">
    <tr>
      <td width="18%" height="31">Id Konsumen</td>
      <td width="1%">:</td>
      <td width="81%"><label for="Id_Konsumen"></label>
      <input name="Id_Konsumen" type="text" placeholder="Id Konsumen" class="form-control" id="Id_Konsumen" value="<?php echo $row_eknsm['Id_Konsumen']; ?>" /></td>
    </tr>
    <tr>
      <td height="32">NIK</td>
      <td>:</td>
      <td><label for="NIK"></label>
      <input name="NIK" type="text" placeholder="NIK" class="form-control" id="NIK" value="<?php echo $row_eknsm['NIK']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="32">NIK Pemilik</td>
      <td>:</td>
      <td><label for="NIK_Pemilik"></label>
      <input name="NIK_Pemilik" type="text" placeholder="NIK Pemilik" class="form-control" id="NIK_Pemilik" value="<?php echo $row_eknsm['NIK_Pemilik']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="35">Nama Konsumen</td>
      <td>:</td>
      <td><label for="Nama_Konsumen"></label>
      <input name="Nama_Konsumen" type="text" placeholder="Nama Konsumen" class="form-control" id="Nama_Konsumen" value="<?php echo $row_eknsm['Nama_Konsumen']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="35">Nama Pemilik</td>
      <td>:</td>
      <td><label for="Nama_Pemilik"></label>
      <input name="Nama_Pemilik" type="text" placeholder="Nama Pemilik" class="form-control" id="Nama_Pemilik" value="<?php echo $row_eknsm['Nama_Pemilik']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="36">Agama</td>
      <td>:</td>
      <td><select name="Agama" placeholder="Agama" class="form-control" id="Agama" title="<?php echo $row_eknsm['Agama']; ?>">
        <option value="Islam" selected="selected">Islam</option>
        <option value="Katolik">Katolik</option>
        <option value="Kristen">Kristen</option>
        <option value="Hindu">Hindu</option>
        <option value="Buddha">Buddha</option>
      </select></td>
    </tr>
    <tr>
      <td height="31">Jenis Kelamin</td>
      <td>:</td>
      <td><select name="Jenis_kelamin" placeholder="Jenis Kelamin" class="form-control" id="Jenis_kelamin" title="<?php echo $row_eknsm['Jenis_Kelamin']; ?>">
        <option value="Pria">Pria</option>
        <option value="Wanita">Wanita</option>
      </select></td>
    </tr>
    <tr>
      <td height="35">No.Hp</td>
      <td>:</td>
      <td><label for="No_Hp"></label>
      <input name="No_Hp" type="text" placeholder="No Hp" class="form-control" id="No_Hp" value="<?php echo $row_eknsm['No_HP']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="93">Alamat Lengkap</td>
      <td>:</td>
      <td><label for="Alamat_Lengkap"></label>
      <textarea name="Alamat_Lengkap" placeholder="Alamat Lengkap" class="form-control" id="Alamat_Lengkap" cols="45" rows="5"><?php echo $row_eknsm['Alamat_Lengkap']; ?></textarea></td>
    </tr>
    <tr>
      <td height="39">Foto Konsumen</td>
      <td>:</td>
      <td><label for="Foto"></label>
     <p><img src="f_konsumen/<?php echo $row_eknsm['Foto']; ?>"width="30"/></p>
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
mysql_free_result($eknsm);
?>
