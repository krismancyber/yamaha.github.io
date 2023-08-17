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

if ((isset($_GET['NIK_Petugas'])) && ($_GET['NIK_Petugas'] != "")) {
  $deleteSQL = sprintf("DELETE FROM petugas WHERE NIK_Petugas=%s",
                       GetSQLValueString($_GET['NIK_Petugas'], "int"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($deleteSQL, $konek) or die(mysql_error());

  $deleteGoTo = "petugas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Hapus');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=petugas" />
<?php
}

$colname_hpt = "-1";
if (isset($_GET['NIK_Petugas'])) {
  $colname_hpt = $_GET['NIK_Petugas'];
}
mysql_select_db($database_konek, $konek);
$query_hpt = sprintf("SELECT * FROM petugas WHERE NIK_Petugas = %s", GetSQLValueString($colname_hpt, "int"));
$hpt = mysql_query($query_hpt, $konek) or die(mysql_error());
$row_hpt = mysql_fetch_assoc($hpt);
$totalRows_hpt = mysql_num_rows($hpt);

mysql_select_db($database_konek, $konek);
$query_hpt = "SELECT * FROM petugas";
$hpt = mysql_query($query_hpt, $konek) or die(mysql_error());
$row_hpt = mysql_fetch_assoc($hpt);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($hpt);
?>
