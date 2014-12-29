<?php
$pattern = '/
(         #start of whole regex
    (\d{4})   #year
    -         #dash
    (\d{2})   #month
    -         #dash
    (\d{2})   #day
)
/x';
$string = '2014-12-25';
if (preg_match($pattern, $string, $arr))
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
?>
