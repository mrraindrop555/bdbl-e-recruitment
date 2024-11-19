<?php
phpinfo();
$tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
die($tmp_dir);
?>