<?php require_once('Connections/konek.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_usr = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usr = $_SESSION['MM_Username'];
}
mysql_select_db($database_konek, $konek);
$query_usr = sprintf("SELECT * FROM `login` WHERE Username = %s", GetSQLValueString($colname_usr, "text"));
$usr = mysql_query($query_usr, $konek) or die(mysql_error());
$row_usr = mysql_fetch_assoc($usr);
$totalRows_usr = mysql_num_rows($usr);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Penjualan Motor Cash Dan Kredit Berbasis Web Pada Toko CV.Teknik Kota Pematangsiantar</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
}
a:link {
	color: #FFFF00;
}
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0; font-size: 14px;">
          <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" >CV.Teknik Kota Pematangsiantar</a>
                <form name="form1" method="post" action="">
                </form>
            </div>
			
<div class="header-right">
         Tanggal Akses : <?php echo date('D'.' '.'d-m-Y') ?>  

      </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <div class="user-img-div center">
                            <img src="ahm.png" class="img-thumbnail" />

                            <div class="inner-text">
                                Selamat Datang
                            <br />
                                <small><?php echo $row_usr['Nama']; ?> </small>
                            </div>
                        </div>

                    </li>
                    <li>
                        <a class="active-menu" href="index.php"><i class="fa fa-home "></i>Beranda</a>
                    </li>
                    <li>
                                <a href="?page=petugas"><i class="fa fa-user"></i>Petugas</a>
                  </li>
                            <li>
                                <a href="?page=jenis_produk"><i class="fa fa-list"></i>Jenis Produk</a>
                            </li>
                             <li>
                                <a href="?page=produk"><i class='fa fa-list'></i>Produk</a>
                            </li>
                            <li>
                                <a href="?page=konsumen"><i class="fa fa-user"></i>konsumen</a>
                            </li>
                             <li>
                                <a href="?page=berkas"><i class="fa fa-file"></i>Berkas</a>
                            </li>
                            <li>
                                <a href="?page=prospek"><i class="fa fa-bell"></i>Prospek</a>
                            </li>
                             <li>
                                <a href="?page=verifikasi"><i class="fa fa-edit "></i>Verifikasi Deal</a>
                            </li>   
                     	 	   
                    		<li>
                       			 <a href="?page=laporan"><i class="glyphicon glyphicon-file"></i> Laporan</a>   
                    		</li>
                    		<li>
                       			 <a href="<?php echo $logoutAction ?>"><i class="glyphicon glyphicon-log-out"></i></i>Keluar</a>   
                    		
                    		</li>
              </ul>
            </div>
      </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                      <form name="form2" method="post" action="">
                      </form>
<pre class="page-head-line"> <marquee>Perancangan Sistem Penjualan Motor Cash Dan Kredit Berbasis Web Pada Toko CV.Teknik Kota Pematangsiantar                    </pre></marquee>
                  </div>
                </div>
            <?php
			if(isset($_GET['page']))
			include"$_GET[page].php";
		else
			include"home.php";
		?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
</div>
    <!-- /. WRAPPER  -->

    <div id="footer-sec">
        &copy; 2023 CV.Teknik Kota Pematangsiantar</a>
    </div>
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php
mysql_free_result($usr);
?>
