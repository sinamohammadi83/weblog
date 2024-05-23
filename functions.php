<?php
function token($len)
{
    $token = "";
    $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
    for($i = 0 ; $i < $len ;$i++)
    {
        $token.=$str[random_int(0,strlen($str)-1)];
    }
    return $token;
}