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
$query_brks = "SELECT * FROM berkas";
$brks = mysql_query($query_brks, $konek) or die(mysql_error());
$row_brks = mysql_fetch_assoc($brks);
$totalRows_brks = mysql_num_rows($brks);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if(isset($_FILES['KTP']['name'])){
		$upload=$_FILES['KTP'];
		move_uploaded_file($upload['tmp_name'],"f_ktp/".$upload['name']);
		$Foto1=$upload['name'];
	}else{
		$Foto1=Null;
	}
	if(isset($_FILES['KK']['name'])){
		$upload=$_FILES['KK'];
		move_uploaded_file($upload['tmp_name'],"f_kk/".$upload['name']);
		$Foto2=$upload['name'];
	}else{
		$Foto2=Null;
	}
	if(isset($_FILES['Foto_Rumah']['name'])){
		$upload=$_FILES['Foto_Rumah'];
		move_uploaded_file($upload['tmp_name'],"f_rumah/".$upload['name']);
		$Foto3=$upload['name'];
	}else{
		$Foto3=Null;
	}
	if(isset($_FILES['Foto_Usaha']['name'])){
		$upload=$_FILES['Foto_Usaha'];
		move_uploaded_file($upload['tmp_name'],"f_usaha/".$upload['name']);
		$Foto4=$upload['name'];
	}else{
		$Foto4=Null;
	}
  $insertSQL = sprintf("INSERT INTO berkas (Id_Berkas, Tanggal_Input, NIK_Petugas, Id_Konsumen, KTP, KK, Foto_Rumah, Foto_Usaha, Alamat_Rumah, Status_Berkas) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id_Berkas'], "text"),
                       GetSQLValueString($_POST['Tanggal_Input'], "date"),
                       GetSQLValueString($_POST['NIK_Petugas'], "text"),
                       GetSQLValueString($_POST['Id_Konsumen'], "text"),
                       GetSQLValueString($Foto1, "text"),
                       GetSQLValueString($Foto2, "text"),
                       GetSQLValueString($Foto3, "text"),
                       GetSQLValueString($Foto4, "text"),
                       GetSQLValueString($_POST['Alamat_Rumah'], "text"),
                       GetSQLValueString($_POST['Status_Berkas'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($insertSQL, $konek) or die(mysql_error());

  $insertGoTo = "berkas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Simpan');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=berkas" />
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
    <h4> Input Data Berkas</h4>
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
      <input name="Id_Berkas" type="text" placeholder="Id Berkas" class="form-control" id="Id_Berkas" size="20" /></td>
    </tr>
    <tr>
      <td>Tanggal Input</td>
      <td>:</td>
      <td><label for="Tanggal_Input"></label>
      <input type="date" name="Tanggal_Input" placeholder="Tanggal" class="form-control" id="Tanggal_Input" /></td>
    </tr>
    <tr>
      <td>Nama Petugas </td>
      <td>:</td>
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
      <td>Nama Konsumen</td>
      <td>:</td>
      <td><label for="Id_Konsumen"></label>
       <select  placeholder="Nama Konsumen" class="form-control" name="Id_Konsumen">
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
      <input type="file" name="KTP" placeholder="Foto KTP" class="form-control" id="KTP" /></td>
    </tr>
    <tr>
      <td>Kartu Keluarga</td>
      <td>:</td>
      <td><label for="KK"></label>
      <input type="file" name="KK" placeholder="Foto KK" class="form-control" id="KK" /></td>
    </tr>
    <tr>
      <td>Foto Rumah</td>
      <td>:</td>
      <td><label for="Foto_Rumah"></label>
      <input type="file" name="Foto_Rumah" placeholder="Foto Rumah" class="form-control" id="Foto_Rumah" /></td>
    </tr>
    <tr>
      <td>Foto Usaha</td>
      <td>:</td>
      <td><label for="Foto_Usaha"></label>
      <input type="file" name="Foto_Usaha" placeholder="Foto Usaha" class="form-control" id="Foto_Usaha" /></td>
    </tr>
    <tr>
      <td>Alamat Rumah</td>
      <td>:</td>
      <td><label for="Alamat_Rumah"></label>
      <textarea name="Alamat_Rumah" placeholder="Alamat Rumah" class="form-control" id="Alamat_Rumah" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>Status Berkas</td>
      <td>:</td>
      <td><label for="Status_Berkas"></label>
      <input name="Status_Berkas" type="text" placeholder="Status Berkas" class="form-control" id="Status_Berkas" size="30" /></td>
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
<table width="100%" border="1" align="center">
  <tr>
    <td width="2%" align="center" bgcolor="#FF0000">No</td>
    <td width="7%" align="center" bgcolor="#FF0000">Id Berkas</td>
    <td width="9%" align="center" bgcolor="#FF0000">Tanggal Input</td>
    <td width="10%" align="center" bgcolor="#FF0000">Nama Petugas</td>
    <td width="12%" align="center" bgcolor="#FF0000">Nama Konsumen</td>
    <td width="8%" align="center" bgcolor="#FF0000">KTP</td>
    <td width="9%" align="center" bgcolor="#FF0000">KK</td>
    <td width="10%" align="center" bgcolor="#FF0000">Foto Rumah</td>
    <td width="8%" align="center" bgcolor="#FF0000">Foto Usaha</td>
    <td width="8%" align="center" bgcolor="#FF0000">Alamat Rumah</td>
    <td width="9%" align="center" bgcolor="#FF0000">Status Berkas</td>
    <td width="8%" align="center" bgcolor="#FF0000">Aksi</td>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_brks['Id_Berkas']; ?></td>
      <td><?php echo $row_brks['Tanggal_Input']; ?></td>
      <td><?php echo $row_brks['NIK_Petugas']; ?></td>
      <td><?php echo $row_brks['Id_Konsumen']; ?></td>
      <td><img src="f_ktp/<?php echo $row_brks['KTP']; ?>"width="50" height="50" alt=""/></td>
      <td><img src="f_kk/<?php echo $row_brks['KK']; ?>"width="50" height="50" alt=""/></td>
      <td><img src="f_rumah/<?php echo $row_brks['Foto_Rumah']; ?>"width="50" height="50" alt=""/></td>
      <td><img src="f_usaha/<?php echo $row_brks['Foto_Usaha']; ?>"width="50" height="50" alt=""/></td>
      <td><?php echo $row_brks['Alamat_Rumah']; ?></td>
      <td><?php echo $row_brks['Status_Berkas']; ?></td>
      <td><a href="index.php?page=edit_berkas&Id_Berkas=<?php echo $row_brks['Id_Berkas']; ?>"class="btn btn-primary" >Edit</a> - <a href="index.php?page=hapus_berkas&Id_Berkas=<?php echo $row_brks['Id_Berkas']; ?>" class="btn btn-danger" >Hapus</a></td>
    </tr>
    <?php } while ($row_brks = mysql_fetch_assoc($brks)); ?>
</table>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($brks);
?>
