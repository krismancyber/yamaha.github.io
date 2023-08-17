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
$query_pros = "SELECT * FROM prospek";
$pros = mysql_query($query_pros, $konek) or die(mysql_error());
$row_pros = mysql_fetch_assoc($pros);
$totalRows_pros = mysql_num_rows($pros);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(isset($_FILES['Foto']['name'])){
		$upload=$_FILES['Foto'];
		move_uploaded_file($upload['tmp_name'],"f_prospek/".$upload['name']);
		$Foto=$upload['name'];
	}else{
		$Foto=Null;
	}
  $insertSQL = sprintf("INSERT INTO prospek (Id_Prospek, NIK_Petugas, Id_Konsumen, No_Hp, Alamat_Konsumen, Persetujuan, Foto) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id_Prospek'], "text"),
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($_POST['No_Hp'], "text"),
                       GetSQLValueString($_POST['Alamat_Konsumen'], "text"),
                       GetSQLValueString($_POST['Persetujuan'], "text"),
                       GetSQLValueString($Foto, "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "prospek.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=prospek" />
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
    <h4> Input Data Prospek</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0">
    <tr>
      <td width="20%" height="38">Id Prospek</td>
      <td width="2%">&nbsp;</td>
      <td width="78%"><label for="Id_Prospek"></label>
      <input name="Id_Prospek" type="text" placeholder="Id Prospek" class="form-control" id="Id_Prospek" size="20" /></td>
    </tr>
    <tr>
      <td height="39">Nama Petugas</td>
      <td>&nbsp;</td>
      <td><label for="NIK_Petugas"></label>
        
        <select  placeholder="Nama Petugas" class="form-control" name="NIK_Petugas">
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
      <td height="39">Nama Konsumen</td>
      <td>&nbsp;</td>
      <td><label for="Id_Konsumen"></label>
        <select placeholder="Nama Konsumen" class="form-control" name="Id_Konsumen">
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
      <td height="41">No Hp</td>
      <td>&nbsp;</td>
      <td><label for="No_Hp"></label>
      <input name="No_Hp" type="text" placeholder="No Hp" class="form-control" id="No_Hp" size="30" /></td>
    </tr>
    <tr>
      <td height="100">Alamat Konsumen</td>
      <td>&nbsp;</td>
      <td><label for="Alamat_Konsumen"></label>
      <textarea name="Alamat_Konsumen" placeholder="Alamat Konsumen" class="form-control" id="Alamat_Konsumen" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td height="37">Persetujuan</td>
      <td>&nbsp;</td>
      <td><label for="Persetujuan"></label>
      <input name="Persetujuan" type="text" placeholder="Persetujuan" class="form-control" id="Persetujuan" size="30" /></td>
    </tr>
    <tr>
      <td height="43">Foto TTD</td>
      <td>&nbsp;</td>
      <td><label for="Foto"></label>
      <input type="file" name="Foto" placeholder="Foto TTD" class="form-control" id="Foto" /></td>
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
    <td width="4%" align="center" bgcolor="#FF0000"><strong>No</strong></td>
    <td width="10%" align="center" bgcolor="#FF0000"><strong>Id Prospek</strong></td>
    <td width="14%" align="center" bgcolor="#FF0000"><strong>Nama  Petugas</strong></td>
    <td width="14%" align="center" bgcolor="#FF0000"><strong>Nama Konsumen</strong></td>
    <td width="10%" align="center" bgcolor="#FF0000"><strong>No Hp</strong></td>
    <td width="14%" align="center" bgcolor="#FF0000"><strong>Alamat Konsumen</strong></td>
    <td width="12%" align="center" bgcolor="#FF0000"><strong>Persetujuan</strong></td>
    <td width="11%" align="center" bgcolor="#FF0000"><strong>Foto TTD</strong></td>
    <td width="11%" align="center" bgcolor="#FF0000"><strong>Aksi</strong></td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_pros['Id_Prospek']; ?></td>
      <td><?php echo $row_pros['NIK_Petugas']; ?></td>
      <td><?php echo $row_pros['Id_Konsumen']; ?></td>
      <td><?php echo $row_pros['No_Hp']; ?></td>
      <td><?php echo $row_pros['Alamat_Konsumen']; ?></td>
      <td><?php echo $row_pros['Persetujuan']; ?></td>
      <td><img src="f_prospek/<?php echo $row_pros['Foto']; ?>" width="100" height="100" alt=""/></td>
      <td><a href="index.php?page=edit_prospek&Id_Prospek=<?php echo $row_pros['Id_Prospek']; ?>" class="btn btn-primary">Edit</a> - <a href="index.php?page=hapus_prospek&Id_Prospek=<?php echo $row_pros['Id_Prospek']; ?>" class="btn btn-danger">Hapus</a></td>
    </tr>
    <?php } while ($row_pros = mysql_fetch_assoc($pros)); ?>
</table>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($pros);
?>
