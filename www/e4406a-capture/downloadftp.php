<?php

$cmd = "";
if (isset($_GET["submit"])) {
        if ($_GET["submit"] === "Download zip") {
                $cmd = "zip -r";
                $fileext = "zip";
        } elseif ($_GET["submit"] === "Download tgz") {
                $cmd = "tar -cvvzf ";
                $fileext = "tgz";
        }
}

if ($cmd === "") {
        die("wrong type");
}

$readlink = exec("readlink files/current");
if ($readlink === "") {
        die("no current");
}
        
exec($cmd." files/".$readlink.".".$fileext." files/".$readlink);

# Redirect
header('Location: files/'.$readlink.'.'.$fileext, true, 303);
die();

?>
