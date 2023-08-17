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

if ((isset($_GET['Id_Prospek'])) && ($_GET['Id_Prospek'] != "")) {
  $deleteSQL = sprintf("DELETE FROM prospek WHERE Id_Prospek=%s",
                       GetSQLValueString($_GET['Id_Prospek'], "text"));

  mysql_select_db($database_konek, $konek);
  $Result1 = mysql_query($deleteSQL, $konek) or die(mysql_error());

  $deleteGoTo = "prospek.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Di Hapus');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=prospek" />
<?php
}

$colname_hpros = "-1";
if (isset($_GET['Id_Prospek'])) {
  $colname_hpros = $_GET['Id_Prospek'];
}
mysql_select_db($database_konek, $konek);
$query_hpros = sprintf("SELECT * FROM prospek WHERE Id_Prospek = %s", GetSQLValueString($colname_hpros, "text"));
$hpros = mysql_query($query_hpros, $konek) or die(mysql_error());
$row_hpros = mysql_fetch_assoc($hpros);
$totalRows_hpros = mysql_num_rows($hpros);
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
mysql_free_result($hpros);
?>
