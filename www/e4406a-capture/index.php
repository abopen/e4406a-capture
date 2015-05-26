<html>

<LINK href="index.css" rel="stylesheet" type="text/css">

<head>
<title>Agilent E4406A Screen Capture</title>
</head>

<body bgcolor="white" text="black">
<center><h1>Agilent E4406A Screen Capture</h1></center>

<center>
<form action="grabftp.php" method="get">
Notes<br><textarea name="notes" rows=5 cols=128 align="top"></textarea>
<p>
<input type="submit" name="submit" value="Fetch Only New">
<input type="submit" name="submit" value="Fetch All">
</form>
</center>

<?php
$readlink = exec("readlink files/current");
if ($handle = opendir("files/$readlink")) {
        $files = array();        
        while (false !== ($files[] = readdir($handle)));
        sort($files);
        closedir($handle);

        echo "<br><br>";
        echo "<center><h1>Current - $readlink</h1></center>";
        echo "<center>";
        foreach ($files as $entry) {
            if (substr($entry, -4, 4) === ".gif") {
                echo "<a href=\"files/$readlink/$entry\"><img src=\"files/$readlink/$entry\" width=320 height=240></a>";
            }
        }

	if ($handle = fopen("files/$readlink/notes.txt", 'r')) {
		echo "<br><p>";
		echo fgets($handle);
		echo "<br><p>";
		fclose($handle);
	}
	echo "</center>";

	echo "<br><center>";
	echo "<form action=\"downloadftp.php\" method=\"get\">";
	echo "	<input type=\"submit\" name=\"submit\" value=\"Download zip\">";
	echo "	<input type=\"submit\" name=\"submit\" value=\"Download tgz\">";
	echo "</form>";
	echo "</center>";
}
?>

</body>
</html>
