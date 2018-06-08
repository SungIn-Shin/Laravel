<?php
$exd = date_create_from_format('Ymd', '20180612');
//$exd = date_create('01 Dec, 2015');
$exd = date_format($exd, 'Y-m-d 00:00:00');
echo $exd;