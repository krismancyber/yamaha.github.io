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
  $updateSQL = sprintf("UPDATE verifikasi_prospek SET Tanggal_Prospek=%s, NIK_Petugas=%s, Id_Konsumen=%s, Id_Produk=%s, Id_Berkas=%s, Keterangan_Prospek=%s WHERE Id_Prospek=%s",
                       GetSQLValueString($_POST['Tanggal_Prospek'], "date"),
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($_POST['Id_Produk'], "text"),
                       GetSQLValueString($_POST['Id_Berkas'], "text"),
                       GetSQLValueString($_POST['Keterangan_Prospek'], "text"),
                       GetSQLValueString($_POST['Id_Prospek'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "verifikasi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=verifikasi" />
<?php
}

$colname_everif = "-1";
if (isset($_GET['Id_Prospek'])) {
  $colname_everif = $_GET['Id_Prospek'];
}
mysql_select_db($database_konek, $konek);
$query_everif = sprintf("SELECT * FROM verifikasi_prospek WHERE Id_Prospek = %s", GetSQLValueString($colname_everif, "text"));
$everif = mysql_query($query_everif, $konek) or die(mysql_error());
$row_everif = mysql_fetch_assoc($everif);
$totalRows_everif = mysql_num_rows($everif);
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
    <h4> Edit Data Verifikasi Deal</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr>
      <td width="21%" height="40">Id Verifikasi</td>
      <td width="1%">:</td>
      <td width="78%"><label for="Id_Prospek"></label>
      <input name="Id_Prospek" type="text" placeholder="Id Verifikasi" class="form-control" id="Id_Prospek" value="<?php echo $row_everif['Id_Prospek']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td height="37">Tanggal Verifikasi</td>
      <td>:</td>
      <td><label for="Tanggal_Prospek"></label>
      <input name="Tanggal_Prospek" type="date" placeholder="Tanggal" class="form-control" id="Tanggal_Prospek" value="<?php echo $row_everif['Tanggal_Prospek']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td height="36">Nama Petugas</td>
      <td>:</td>
      <td><select placeholder="Nama Petugas" class="form-control"  name="NIK_Petugas" title="<?php echo $row_everif['NIK_Petugas']; ?>">
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
      <td height="36">Nama Konsumen</td>
      <td>:</td>
      <td><label for="Id_Konsumen"></label>
        <select placeholder="Nama Konsumen" class="form-control" name="Id_Konsumen" title="<?php echo $row_everif['Id_Konsumen']; ?>">
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
      <td height="39">Type Produk</td>
      <td>:</td>
      <td><label for="Id_Produk"></label>
        <select placeholder="Type Produk" class="form-control" name="Id_Produk" title="<?php echo $row_everif['Id_Produk']; ?>">
        <option>-- Pilih Salah Satu --</option>
        <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM produk ORDER BY Type");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
        <option value="<?php echo $dt_mhs['Id_Produk']; ?> : <?php echo $dt_mhs['Type']; ?>"><?php echo $dt_mhs['Id_Produk']; ?> : <?php echo $dt_mhs['Type']; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="41">Status Berkas</td>
      <td>:</td>
      <td><label for="Id_Berkas"></label>
        <select placeholder="Status Berkas" class="form-control" name="Id_Berkas" title="<?php echo $row_everif['Id_Berkas']; ?>">
        <option>-- Pilih Salah Satu --</option>
        <?php
		include "konek.php";
		$tpl_mhs=mysql_query("SELECT * FROM berkas ORDER BY Status_Berkas");
		while ($dt_mhs=mysql_fetch_array($tpl_mhs)){
		?>
        <option value="<?php echo $dt_mhs['Id_Berkas']; ?> : <?php echo $dt_mhs['Status_Berkas']; ?>"><?php echo $dt_mhs['Id_Berkas']; ?> : <?php echo $dt_mhs['Status_Berkas']; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td height="129">Keterangan </td>
      <td>:</td>
      <td><label for="Keterangan_Prospek"></label>
      <textarea name="Keterangan_Prospek" placeholder="Keterangan" class="form-control" id="Keterangan_Prospek" cols="45" rows="5"><?php echo $row_everif['Keterangan_Prospek']; ?></textarea></td>
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
mysql_free_result($everif);
?>
