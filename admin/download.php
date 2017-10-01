<?php
//pobieranie za³¹czników


$name = $_GET['name'];
clearstatcache();

$contenttype = "application/force-download";
header("Content-Type: " . $contenttype);
header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\";");
readfile("attachments/".$filename);
exit();
   

?>