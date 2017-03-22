<?php

/**
 * Created by PhpStorm.
 * User: grani
 * Date: 17/03/2017
 * Time: 9:07 AM
 */
class General
{
    public static function codificar ($str){
        $salt = "rauNcHyfO0T_231";
        $c1 = md5(crypt ($str, $salt));
        return $c1;
    }

}