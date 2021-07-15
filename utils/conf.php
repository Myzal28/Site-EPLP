<?php

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'eplp');

$headers ="From: EPLP Lloret<eplp.lloret@gmail.com>"."\n";
$headers .='Reply-To: eplp.lloret@gmail.com'."\n"; 
$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';
define('HEADERS',$headers);
?>
