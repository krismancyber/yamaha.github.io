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
$query_ptgs = "SELECT * FROM petugas";
$ptgs = mysql_query($query_ptgs, $konek) or die(mysql_error());
$row_ptgs = mysql_fetch_assoc($ptgs);
$totalRows_ptgs = mysql_num_rows($ptgs);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(isset($_FILES['Foto']['name'])){
		$upload=$_FILES['Foto'];
		move_uploaded_file($upload['tmp_name'],"f_pegawai/".$upload['name']);
		$Foto=$upload['name'];
	}else{
		$Foto=Null;
	}
  $insertSQL = sprintf("INSERT INTO petugas (NIK_Petugas, Nama_Petugas, Jabatan, No_Telp, Agama, Jenkel, Alamat, Foto) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Nama_Petugas'], "text"),
                       GetSQLValueString($_POST['Jabatan'], "text"),
                       GetSQLValueString($_POST['No_Telp'], "text"),
                       GetSQLValueString($_POST['Agama'], "text"),
                       GetSQLValueString($_POST['Jenkel'], "text"),
                       GetSQLValueString($_POST['Alamat'], "text"),
                       GetSQLValueString($Foto, "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "petugas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=petugas" />
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
    <h4> Input Data Petugas</h4>
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
      <input name="NIK_Petugas" type="text" placeholder="NIK Petugas" class="form-control" id="NIK_Petugas" size="30" /></td>
    </tr>
    <tr>
      <td height="38">Nama Petugas</td>
      <td>:</td>
      <td><label for="Nama_Petugas"></label>
      <input name="Nama_Petugas" type="text" placeholder="Nama Petugas" class="form-control" id="Nama_Petugas" size="30" /></td>
    </tr>
    <tr>
      <td height="35">Jabatan</td>
      <td>:</td>
      <td><label for="Jabatan"></label>
      <input name="Jabatan" type="text" placeholder="Jabatan" class="form-control" id="Jabatan" size="30" /></td>
    </tr>
    <tr>
      <td height="37">No.Telp</td>
      <td>:</td>
      <td><label for="No_Telp"></label>
      <input type="text" name="No_Telp" placeholder="No Telp" class="form-control" id="No_Telp" /></td>
    </tr>
    <tr>
      <td height="35">Agama</td>
      <td>:</td>
      <td><select name="Agama" placeholder="Agama" class="form-control"id="Agama">
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
      <textarea name="Alamat" placeholder="Alamat" class="form-control" id="Alamat" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td height="45">Foto</td>
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
    <td width="9%" align="center" bgcolor="#FF0000">NIK Petugas</td>
    <td width="12%" align="center" bgcolor="#FF0000">Nama Petugas</td>
    <td width="11%" align="center" bgcolor="#FF0000">Jabatan</td>
    <td width="11%" align="center" bgcolor="#FF0000">No.Telp</td>
    <td width="9%" align="center" bgcolor="#FF0000">Agama</td>
    <td width="9%" align="center" bgcolor="#FF0000">Jenis Kelamin</td>
    <td width="16%" align="center" bgcolor="#FF0000">Alamat</td>
    <td width="10%" align="center" bgcolor="#FF0000">Foto</td>
    <td width="10%" align="center" bgcolor="#FF0000">Aksi</td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_ptgs['NIK_Petugas']; ?></td>
      <td><?php echo $row_ptgs['Nama_Petugas']; ?></td>
      <td><?php echo $row_ptgs['Jabatan']; ?></td>
      <td><?php echo $row_ptgs['No_Telp']; ?></td>
      <td><?php echo $row_ptgs['Agama']; ?></td>
      <td><?php echo $row_ptgs['Jenkel']; ?></td>
      <td><?php echo $row_ptgs['Alamat']; ?></td>
      <td><img src="f_pegawai/<?php echo $row_ptgs['Foto']; ?>"width="100" height="100" alt=""/></td>
      <td><a href="index.php?page=edit_petugas&NIK_Petugas=<?php echo $row_ptgs['NIK_Petugas']; ?>" class="btn btn-primary" >Edit</a> - <a href="index.php?page=hapus_petugas&NIK_Petugas=<?php echo $row_ptgs['NIK_Petugas']; ?>" class="btn btn-danger" >Hapus</a></td>
    </tr>
    <?php } while ($row_ptgs = mysql_fetch_assoc($ptgs)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ptgs);
?>
