<?php
include('class.upload.php');

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

    public static function uploadFile ($FileImagen, $options=array()){
        $archivos = new Upload($FileImagen);
        if ($archivos->uploaded){
            $nameFinal = $archivos->file_new_name_body = date('H-M-s')."-".$archivos->file_src_name_body;

            if (empty($options)){
                $archivos->Process("../Uploads");
            }else{
                $archivos->Process($options["Ruta"]);
            }

            if($archivos->processed){
                $archivos->Clean();
                return array("Result" => true, "Ruta" => $nameFinal);
            }else{
                $error = $archivos->error;
                $archivos->Clean();
                return array("Result" => false, "Error" => "Archivo No Subido, Error en la carpeta..".$error);
            }
        }else{
            return array("Result" => false, "Error" =>  "Error al subir el archivo...".$archivos->error);
        }
    }

}