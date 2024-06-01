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

function convert_date($get_date,$print_time=false)
{

    $fulldate = strtok($get_date, " ");
    $date = explode('-', $fulldate);
    if ($print_time){
        $time = explode(' ', $get_date);
        $convert = $time[1]." ".gregorian_to_jalali($date[0], $date[1], $date[2] , "-");
    }else{
        $convert =gregorian_to_jalali($date[0], $date[1], $date[2] , "-");
    }
    return $convert;

}