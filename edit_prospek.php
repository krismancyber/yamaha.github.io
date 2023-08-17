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
		move_uploaded_file($upload['tmp_name'],"f_prospek/".$upload['name']);
	}
  $updateSQL = sprintf("UPDATE prospek SET NIK_Petugas=%s, Id_Konsumen=%s, No_Hp=%s, Alamat_Konsumen=%s, Persetujuan=%s, Foto=%s WHERE Id_Prospek=%s",
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($_POST['No_Hp'], "text"),
                       GetSQLValueString($_POST['Alamat_Konsumen'], "text"),
                       GetSQLValueString($_POST['Persetujuan'], "text"),
                       GetSQLValueString($upload['name'], "text"),
                       GetSQLValueString($_POST['Id_Prospek'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "prospek.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=prospek" />
<?php
}

$colname_epros = "-1";
if (isset($_GET['Id_Prospek'])) {
  $colname_epros = $_GET['Id_Prospek'];
}
mysql_select_db($database_konek, $konek);
$query_epros = sprintf("SELECT * FROM prospek WHERE Id_Prospek = %s", GetSQLValueString($colname_epros, "text"));
$epros = mysql_query($query_epros, $konek) or die(mysql_error());
$row_epros = mysql_fetch_assoc($epros);
$totalRows_epros = mysql_num_rows($epros);
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
    <h4> Edit Data Prospek</h4>
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
      <input name="Id_Prospek" type="text" placeholder="Id Prospek" class="form-control" id="Id_Prospek" value="<?php echo $row_epros['Id_Prospek']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td height="39">Nama Petugas</td>
      <td>&nbsp;</td>
      <td><label for="NIK_Petugas"></label>
        
        <select placeholder="Nama Petugas" class="form-control" name="NIK_Petugas" title="<?php echo $row_epros['NIK_Petugas']; ?>">
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
        <select  placeholder="Nama Konsumen" class="form-control" name="Id_Konsumen" title="<?php echo $row_epros['Id_Konsumen']; ?>">
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
      <input name="No_Hp" type="text" placeholder="No Hp" class="form-control" id="No_Hp" value="<?php echo $row_epros['No_Hp']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="100">Alamat Konsumen</td>
      <td>&nbsp;</td>
      <td><label for="Alamat_Konsumen"></label>
      <textarea name="Alamat_Konsumen" placeholder="Alamat Konsumen" class="form-control" id="Alamat_Konsumen" cols="45" rows="5"><?php echo $row_epros['Alamat_Konsumen']; ?></textarea></td>
    </tr>
    <tr>
      <td height="37">Persetujuan</td>
      <td>&nbsp;</td>
      <td><label for="Persetujuan"></label>
      <input name="Persetujuan" type="text" placeholder="Persetujuan" class="form-control" id="Persetujuan" value="<?php echo $row_epros['Persetujuan']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="43">Foto TTD</td>
      <td>&nbsp;</td>
      <td><label for="Foto"></label>
      <p><img src="f_prospek/<?php echo $row_epros['Foto']; ?>"width="30"/></p>
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
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($epros);
?>
