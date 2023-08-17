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
	if ($_FILES['KTP']['error'] == 0) {
		$upload1 = $_FILES['KTP'];
		move_uploaded_file($upload1['tmp_name'],"f_ktp/".$upload1['name']);
	}
	if ($_FILES['KK']['error'] == 0) {
		$upload2 = $_FILES['KK'];
		move_uploaded_file($upload2['tmp_name'],"f_kk/".$upload2['name']);
	}
	if ($_FILES['Foto_Rumah']['error'] == 0) {
		$upload3 = $_FILES['Foto_Rumah'];
		move_uploaded_file($upload3['tmp_name'],"f_rumah/".$upload3['name']);
	}
	if ($_FILES['Foto_Usaha']['error'] == 0) {
		$upload4 = $_FILES['Foto_Usaha'];
		move_uploaded_file($upload4['tmp_name'],"f_usaha/".$upload4['name']);
	}
  $updateSQL = sprintf("UPDATE berkas SET Tanggal_Input=%s, NIK_Petugas=%s, Id_Konsumen=%s, KTP=%s, KK=%s, Foto_Rumah=%s, Foto_Usaha=%s, Alamat_Rumah=%s, Status_Berkas=%s WHERE Id_Berkas=%s",
                       GetSQLValueString($_POST['Tanggal_Input'], "date"),
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($upload1['name'], "text"),
                       GetSQLValueString($upload2['name'], "text"),
                       GetSQLValueString($upload3['name'], "text"),
                       GetSQLValueString($upload4['name'], "text"),
                       GetSQLValueString($_POST['Alamat_Rumah'], "text"),
                       GetSQLValueString($_POST['Status_Berkas'], "text"),
                       GetSQLValueString($_POST['Id_Berkas'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($updateSQL, $konek) or die(mysql_error());

  $updateGoTo = "berkas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Ubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=berkas" />
<?php
}

$colname_ebrks = "-1";
if (isset($_GET['Id_Berkas'])) {
  $colname_ebrks = $_GET['Id_Berkas'];
}
mysql_select_db($database_konek, $konek);
$query_ebrks = sprintf("SELECT * FROM berkas WHERE Id_Berkas = %s", GetSQLValueString($colname_ebrks, "text"));
$ebrks = mysql_query($query_ebrks, $konek) or die(mysql_error());
$row_ebrks = mysql_fetch_assoc($ebrks);
$totalRows_ebrks = mysql_num_rows($ebrks);
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
    <h4> Edit Data Berkas</h4>
    <hr />
  </div>
</form>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0">
    <tr>
      <td width="17%">Id Berkas</td>
      <td width="1%">:</td>
      <td width="82%"><label for="Id_Berkas"></label>
      <input name="Id_Berkas" type="text" placeholder="Id Berkas" class="form-control" id="Id_Berkas" value="<?php echo $row_ebrks['Id_Berkas']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td>Tanggal Input</td>
      <td>:</td>
      <td><label for="Tanggal_Input"></label>
      <input name="Tanggal_Input" type="date" placeholder="Tanggal" class="form-control" id="Tanggal_Input" value="<?php echo $row_ebrks['Tanggal_Input']; ?>" /></td>
    </tr>
    <tr>
      <td>Nama Petugas </td>
      <td>:</td>
      <td><label for="NIK_Petugas"></label>
       <select  placeholder="Nama Petugas" class="form-control" name="NIK_Petugas" title="<?php echo $row_ebrks['NIK_Petugas']; ?>">
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
      <td>Nama Konsumen</td>
      <td>:</td>
      <td><label for="Id_Konsumen"></label>
       <select  placeholder="Nama Konsumen" class="form-control" name="Id_Konsumen" title="<?php echo $row_ebrks['Id_Konsumen']; ?>">
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
      <td>KTP</td>
      <td>:</td>
      <td><label for="KTP"></label>
      <p><img src="f_ktp/<?php echo $row_ebrks['KTP']; ?>"width="30"/></p>
      <input type="file" name="KTP" placeholder="Foto KTP" class="form-control" id="KTP" /></td>
    </tr>
    <tr>
      <td>Kartu Keluarga</td>
      <td>:</td>
      <td><label for="KK"></label>
      <p><img src="f_kk/<?php echo $row_ebrks['KK']; ?>"width="30"/></p>
      <input type="file" name="KK" placeholder="Foto KK" class="form-control" id="KK" /></td>
    </tr>
    <tr>
      <td>Foto Rumah</td>
      <td>:</td>
      <td><label for="Foto_Rumah"></label>
      <p><img src="f_rumah/<?php echo $row_ebrks['Foto_Rumah']; ?>"width="30"/></p>
      <input type="file" name="Foto_Rumah" placeholder="Foto Rumah" class="form-control" id="Foto_Rumah" /></td>
    </tr>
    <tr>
      <td>Foto Usaha</td>
      <td>:</td>
      <td><label for="Foto_Usaha"></label>
      <p><img src="f_usaha/<?php echo $row_ebrks['Foto_Usaha']; ?>"width="30"/></p>
      <input type="file" name="Foto_Usaha" placeholder="Foto Usaha" class="form-control" id="Foto_Usaha" /></td>
    </tr>
    <tr>
      <td>Alamat Rumah</td>
      <td>:</td>
      <td><label for="Alamat_Rumah"></label>
      <textarea name="Alamat_Rumah" placeholder="Alamat Rumah" class="form-control" id="Alamat_Rumah" cols="45" rows="5"><?php echo $row_ebrks['Alamat_Rumah']; ?></textarea></td>
    </tr>
    <tr>
      <td>Status Berkas</td>
      <td>:</td>
      <td><label for="Status_Berkas"></label>
      <input name="Status_Berkas" type="text" placeholder="Status Berkas" class="form-control" id="Status_Berkas" value="<?php echo $row_ebrks['Status_Berkas']; ?>" size="30" /></td>
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
mysql_free_result($ebrks);
?>
