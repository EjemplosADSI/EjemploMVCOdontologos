<?php
session_start();

if (basename($_SERVER['REQUEST_URI']) == "login.php"){
    if (!empty($_SESSION["DataPaciente"])){
        header("Location: index.php");
    }
}else{
    if (empty($_SESSION["DataPaciente"])){
        header("Location: login.php");
    }
}