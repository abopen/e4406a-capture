<?php

$fetch_all = 1;
if (isset($_GET["submit"])) {
        if ($_GET["submit"] !== "Fetch All") {
                $fetch_all = 0;
        }
}

if ($handle = fopen("files/md5list", "r")) {
        while (($line = fgets($handle)) !== false) {
                $md5list = preg_split("/[\s]+/", $line);
                $md5array[$md5list[0]] = $md5list[1];
        }
        fclose($handle);
}

if (isset($_GET["submit"])) {
	$mktemp = exec("mktemp -d");

        exec("wget --no-directories -r -P $mktemp ftp://10.0.10.26/pub/*.gif");

	if ($handle = opendir($mktemp)) {
		$nowtime = date("Ymd-Hi", time());
		exec("mkdir -p files/".$nowtime);

		$count = 0;
      		while (false !== ($entry = readdir($handle))) {
			if (substr($entry, -4, 4) === ".gif") {
			        $md5 = md5_file($mktemp."/".$entry);
			        if (! isset($md5array[$entry])) {
			                $md5array[$entry]="";
                                }
                                if ($md5array[$entry] !== $md5 || $fetch_all === 1) {
        				exec("mv -v ".$mktemp."/".$entry." files/".$nowtime);
        				$md5array[$entry] = $md5;
        				$count = $count + 1;
				}
			}
		}
		closedir($handle);

		if ($count === 0) {
		        exec("rmdir files/".$nowtime);
                } else {
                        if ($handle = fopen("files/".$nowtime."/notes.txt", "w")) {
                                if (isset($_GET["notes"])) {
                                        fputs($handle, $_GET["notes"]);
                                }
                                fclose($handle);
                        }
                        exec("rm -f files/current");
                        exec("ln -s ".$nowtime." files/current");
                }

		exec("rm -rf $mktemp");

		if ($handle = fopen("files/md5list", "w")) {
        		foreach ($md5array as $key => $value) {
        		        fputs($handle, $key." ".$value."\n");
                        }
                        fclose($handle);
                }
	}
}

# Redirect
header('Location: ./', true, 303);
die();

?>
