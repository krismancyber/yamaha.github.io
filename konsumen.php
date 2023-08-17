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
$query_knsm = "SELECT * FROM konsumen";
$knsm = mysql_query($query_knsm, $konek) or die(mysql_error());
$row_knsm = mysql_fetch_assoc($knsm);
$totalRows_knsm = mysql_num_rows($knsm);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(isset($_FILES['Foto']['name'])){
		$upload=$_FILES['Foto'];
		move_uploaded_file($upload['tmp_name'],"f_konsumen/".$upload['name']);
		$Foto=$upload['name'];
	}else{
		$Foto=Null;
	}
  $insertSQL = sprintf("INSERT INTO konsumen (Id_Konsumen, NIK, NIK_Pemilik, Nama_Konsumen, Nama_Pemilik, Agama, Jenis_Kelamin, No_HP, Alamat_Lengkap, Foto) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($_POST['NIK'], "int"),
                       GetSQLValueString($_POST['NIK_Pemilik'], "int"),
                       GetSQLValueString($_POST['Nama_Konsumen'], "text"),
                       GetSQLValueString($_POST['Nama_Pemilik'], "text"),
                       GetSQLValueString($_POST['Agama'], "text"),
                       GetSQLValueString($_POST['Jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['No_Hp'], "text"),
                       GetSQLValueString($_POST['Alamat_Lengkap'], "text"),
                       GetSQLValueString($Foto, "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "konsumen.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=konsumen" />
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
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="">
  <div class="col-sm-9">
    <h4> Inpu Data Konsumen</h4>
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
      <input type="text" name="Id_Konsumen" placeholder="Id Konsumen" class="form-control" id="Id_Konsumen" /></td>
    </tr>
    <tr>
      <td height="32">NIK</td>
      <td>:</td>
      <td><label for="NIK"></label>
      <input name="NIK" type="text" placeholder="NIK" class="form-control" id="NIK" size="30" /></td>
    </tr>
    <tr>
      <td height="32">NIK Pemilik</td>
      <td>:</td>
      <td><label for="NIK_Pemilik"></label>
      <input name="NIK_Pemilik" type="text" placeholder="NIK Pemilik" class="form-control" id="NIK_Pemilik" size="30" /></td>
    </tr>
    <tr>
      <td height="35">Nama Konsumen</td>
      <td>:</td>
      <td><label for="Nama_Konsumen"></label>
      <input name="Nama_Konsumen" type="text" placeholder="Nama Konsumen" class="form-control" id="Nama_Konsumen" size="30" /></td>
    </tr>
    <tr>
      <td height="35">Nama Pemilik</td>
      <td>:</td>
      <td><label for="Nama_Pemilik"></label>
      <input name="Nama_Pemilik" type="text" placeholder="Nama Pemilik" class="form-control" id="Nama_Pemilik" size="30" /></td>
    </tr>
    <tr>
      <td height="36">Agama</td>
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
      <td height="31">Jenis Kelamin</td>
      <td>:</td>
      <td><select name="Jenis_kelamin" placeholder="Jenis Kelamin" class="form-control" id="Jenis_kelamin">
        <option value="Pria">Pria</option>
        <option value="Wanita">Wanita</option>
      </select></td>
    </tr>
    <tr>
      <td height="35">No.Hp</td>
      <td>:</td>
      <td><label for="No_Hp"></label>
      <input name="No_Hp" type="text" placeholder="No Hp" class="form-control" id="No_Hp" size="30" /></td>
    </tr>
    <tr>
      <td height="95">Alamat Lengkap</td>
      <td>:</td>
      <td><label for="Alamat_Lengkap"></label>
      <textarea name="Alamat_Lengkap" placeholder="Alamat Lengkap" class="form-control" id="Alamat_Lengkap" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td height="39">Foto Konsumen</td>
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
    <td width="3%" align="center" bgcolor="#FF0000">No</td>
    <td width="10%" align="center" bgcolor="#FF0000">Id Konsumen</td>
    <td width="9%" align="center" bgcolor="#FF0000">NIK</td>
    <td width="9%" align="center" bgcolor="#FF0000">NIK Pemilik</td>
    <td width="13%" align="center" bgcolor="#FF0000">Nama Konsumen</td>
    <td width="9%" align="center" bgcolor="#FF0000">Nama Pemilik</td>
    <td width="9%" align="center" bgcolor="#FF0000">Agama</td>
    <td width="10%" align="center" bgcolor="#FF0000">Jenis Kelamin</td>
    <td width="11%" align="center" bgcolor="#FF0000">No.Hp</td>
    <td width="15%" align="center" bgcolor="#FF0000">Alamat Lengkap</td>
    <td width="11%" align="center" bgcolor="#FF0000">Foto</td>
    <td width="9%" align="center" bgcolor="#FF0000">Aksi</td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_knsm['Id_Konsumen']; ?></td>
      <td><?php echo $row_knsm['NIK']; ?></td>
      <td><?php echo $row_knsm['NIK_Pemilik']; ?></td>
      <td><?php echo $row_knsm['Nama_Konsumen']; ?></td>
      <td><?php echo $row_knsm['Nama_Pemilik']; ?></td>
      <td><?php echo $row_knsm['Agama']; ?></td>
      <td><?php echo $row_knsm['Jenis_Kelamin']; ?></td>
      <td><?php echo $row_knsm['No_HP']; ?></td>
      <td><?php echo $row_knsm['Alamat_Lengkap']; ?></td>
      <td><img src="f_konsumen/<?php echo $row_knsm['Foto']; ?>" width="100" height="100" alt=""/></td>
      <td><a href="index.php?page=edit_konsumen&Id_Konsumen=<?php echo $row_knsm['Id_Konsumen']; ?>" class="btn btn-primary">Edit </a>- <a href="index.php?page=hapus_konsumen&Id_Konsumen=<?php echo $row_knsm['Id_Konsumen']; ?>" class="btn btn-danger">Hapus</a></td>
    </tr>
    <?php } while ($row_knsm = mysql_fetch_assoc($knsm)); ?>
</table>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($knsm);
?>
