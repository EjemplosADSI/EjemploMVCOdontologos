<?php
session_start();
require_once (__DIR__.'/../Modelo/Paciente.php');
require_once (__DIR__.'/../Modelo/General.php');

if(!empty($_GET['action'])){
    pacienteController::main($_GET['action']);
}else{
    echo "No se encontro ninguna accion...";
}

class pacienteController{

    static function main($action){
        if ($action == "crear"){
            pacienteController::crear();
        }else if ($action == "editar"){
            pacienteController::editar();
        }else if ($action == "selectPacientes"){
            pacienteController::selectPacientes();
        }else if ($action == "adminTablePacientes"){
            pacienteController::adminTablePacientes();
        }else if ($action == "InactivarPaciente"){
            pacienteController::CambiarEstado("Inactivo");
        }else if ($action == "ActivarPaciente"){
            pacienteController::CambiarEstado("Activo");
        }else if($action == "Login"){
            pacienteController::Login();
        }else if($action == "CerrarSession"){
            pacienteController::CerrarSession();
        }

    }

    static public function crear (){
        try {
            $arrayPaciente = array();
            $arrayPaciente['Nombres'] = $_POST['Nombres'];
            $arrayPaciente['Apellidos'] = $_POST['Apellidos'];
            $arrayPaciente['TipoDocumento'] = $_POST['TipoDocumento'];
            $arrayPaciente['Documento'] = $_POST['Documento'];
            $arrayPaciente['Direccion'] = $_POST['Direccion'];
            $arrayPaciente['Email'] = $_POST['Email'];
            $arrayPaciente['Genero'] = $_POST['Genero'];
            $arrayPaciente['User'] = $_POST['User'];
            $arrayPaciente['Password'] = General::codificar($_POST['Password']);
            $arrayPaciente['Foto'] = "Ruta";
            $arrayPaciente['Estado'] = "Activo";
            $paciente = new Paciente ($arrayPaciente);
            $paciente->insertar();
            header("Location: ../Vista/pages/registroPaciente.php?respuesta=correcto");
        } catch (Exception $e) {
            //var_dump($e);
            $txtMensaje = $e->getMessage();
            header("Location: ../Vista/pages/registroPaciente.php?respuesta=error&Mensaje=".$txtMensaje);
        }
    }

    static public function editar (){
        try {
            $TmpObject = Paciente::buscarForId($_SESSION["IdPaciente"]);
            $Estado = $TmpObject->getEstado();
            $User = $TmpObject->getUser();
            $arrayPaciente = array();
            $arrayPaciente['Nombres'] = $_POST['Nombres'];
            $arrayPaciente['Apellidos'] = $_POST['Apellidos'];
            $arrayPaciente['TipoDocumento'] = $_POST['TipoDocumento'];
            $arrayPaciente['Documento'] = $_POST['Documento'];
            $arrayPaciente['Direccion'] = $_POST['Direccion'];
            $arrayPaciente['Email'] = $_POST['Email'];
            $arrayPaciente['Genero'] = $_POST['Genero'];
            $arrayPaciente['User'] = $User;
            $arrayPaciente['Password'] = General::codificar($_POST['Password']);
            $arrayPaciente['Estado'] = $Estado;
            $arrayPaciente['Foto'] = "Ruta";
            $arrayPaciente['idPaciente'] = $_SESSION["IdPaciente"];
            $paciente = new Paciente ($arrayPaciente);
            $paciente->editar();
            unset($_SESSION["IdPaciente"]);
            header("Location: ../Vista/pages/actualizarPaciente.php?respuesta=correcto&IdPaciente=".$arrayPaciente['idPaciente']);
        } catch (Exception $e) {
            unset($_SESSION["IdPaciente"]);
            $txtMensaje = $e->getMessage();
            header("Location: ../Vista/pages/actualizarPaciente.php?respuesta=error&Mensaje=".$txtMensaje);
        }
    }

    static public function CambiarEstado ($Estado){
        try {
            $idPaciente = $_GET["IdPaciente"];
            $ObjPaciente = Paciente::buscarForId($idPaciente);
            $ObjPaciente->setEstado($Estado);
            var_dump($ObjPaciente);
            $ObjPaciente->editar();
            header("Location: ../Vista/pages/adminPacientes.php?respuesta=correcto");
        }catch (Exception $e){
            $txtMensaje = $e->getMessage();
            header("Location: ../Vista/pages/adminPacientes.php?respuesta=error&Mensaje=".$txtMensaje);
        }
    }

    static public function selectPacientes ($isRequired=true, $id="idPaciente", $nombres="idPaciente", $class=""){
        $arrPacientes = Paciente::getAll(); /*  */
        $htmlSelect = "<select ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombres."' class='".$class."'>";
        $htmlSelect .= "<option >Seleccione</option>";
        if(count($arrPacientes) > 0){
            foreach ($arrPacientes as $paciente)
                $htmlSelect .= "<option value='".$paciente->getIdPaciente()."'>".$paciente->getNombres()." ".$paciente->getApellidos()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    static public function adminTablePacientes (){
        $arrPacientes = Paciente::getAll(); /*  */
        $tmpPaciente = new Paciente();
        $arrColumnas = [/*"idPaciente",*/"Nombres","Apellidos",/*"TipoDocumento",*/"Documento","Direccion","Email","Genero","Estado"];
        $htmlTable = "<thead>";
            $htmlTable .= "<tr>";
                foreach ($arrColumnas as $NameColumna){
                    $htmlTable .= "<th>".$NameColumna."</th>";
                }
            $htmlTable .= "<th>Acciones</th>";
            $htmlTable .= "</tr>";
        $htmlTable .= "</thead>";

        $htmlTable .= "<tbody>";
        foreach ($arrPacientes as $ObjPaciente){
            $htmlTable .= "<tr>";
                //$htmlTable .= "<td>".$ObjPaciente->getIdPaciente()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getNombres()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getApellidos()."</td>";
                //$htmlTable .= "<td>".$ObjPaciente->getTipoDocumento()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getDocumento()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getDireccion()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getEmail()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getGenero()."</td>";
                $htmlTable .= "<td>".$ObjPaciente->getEstado()."</td>";

                $icons = "";
                if($ObjPaciente->getEstado() == "Activo"){
                    $icons .= "<a data-toggle='tooltip' title='Inactivar Usuario' data-placement='top' class='btn btn-social-icon btn-danger newTooltip' href='../../Controlador/pacienteController.php?action=InactivarPaciente&IdPaciente=".$ObjPaciente->getIdPaciente()."'><i class='fa fa-times'></i></a>";
                }else{
                    $icons .= "<a data-toggle='tooltip' title='Activar Usuario' data-placement='top' class='btn btn-social-icon btn-success newTooltip' href='../../Controlador/pacienteController.php?action=ActivarPaciente&IdPaciente=".$ObjPaciente->getIdPaciente()."'><i class='fa fa-check'></i></a>";
                }
                $icons .= "<a data-toggle='tooltip' title='Actualizar Usuario' data-placement='top' class='btn btn-social-icon btn-primary newTooltip' href='actualizarPaciente.php?IdPaciente=".$ObjPaciente->getIdPaciente()."'><i class='fa fa-pencil'></i></a>";
                $icons .= "<a data-toggle='tooltip' title='Ver Usuario' data-placement='top' class='btn btn-social-icon btn-warning newTooltip' href='../../Controlador/pacienteController.php?action=InactivarPaciente&IdPaciente=".$ObjPaciente->getIdPaciente()."'><i class='fa fa-eye'></i></a>";

                $htmlTable .= "<td>".$icons."</td>";
            $htmlTable .= "</tr>";
        }
        $htmlTable .= "</tbody>";
        return $htmlTable;
    }

    public function Login (){
        try {
            $User = $_POST['User'];
            $Password = General::codificar($_POST['Password']);
            if(!empty($User) && !empty($Password)){
                $respuesta = pacienteController::validLogin($User, $Password);
                if (is_array($respuesta)) {
                    $_SESSION['DataPaciente'] = $respuesta;
                    echo TRUE;
                }else if($respuesta == "Password Incorrecto"){
                    echo "<div class='alert alert-danger alert-dismissable'>";
                    echo "    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "    <strong>Error!</strong>. La Contraseña No Coincide Con El Usuario.";
                    echo "</div>";
                }else if($respuesta == "No existe el usuario"){
                    echo "<div class='alert alert-danger alert-dismissable'>";
                    echo "    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "    <strong>Error!</strong>. No Existe Un Usuario Con Estos Datos.";
                    echo "</div>";
                }
            }else{
                echo "<div class='alert alert-danger alert-dismissable'>";
                echo "    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "    <strong>Error!</strong>.Datos Vacios.";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger alert-dismissable'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "    <strong>Error!</strong>. "+$e->getMessage();
            echo "</div>";
        }
    }

    public function validLogin ($User, $Password) {

        $arrPacientes = array();
        $tmp = new Paciente();
        $getTempUser = $tmp->getRows("SELECT * FROM Paciente WHERE User = '".$User."'");
        if(count($getTempUser) >= 1){
            $getrows = $tmp->getRows("SELECT * FROM Paciente WHERE User = '".$User."' AND Password = '".$Password."'");
            if(count($getrows) >= 1){
                foreach ($getrows as $valor) {
                    return $valor;
                }
            }else{
                return "Password Incorrecto";
            }
        }else{
            return "No existe el usuario";
        }
        $tmp->Disconnect();
        return $arrPacientes;
    }

    public function CerrarSession (){
        session_destroy();
        header("Location: ../Vista/pages/login.php");
    }

    /*
    static public function buscarID ($id){
        try {
            return Odontologos::buscarForId($id);
        } catch (Exception $e) {
            header("Location: ../buscarOdontologos.php?respuesta=error");
        }
    }

    public function buscarAll (){
        try {
            return Odontologos::getAll();
        } catch (Exception $e) {
            header("Location: ../buscarOdontologos.php?respuesta=error");
        }
    }

    public function buscar ($campo, $parametro){
        try {
            return Odontologos::getAll();
        } catch (Exception $e) {
            header("Location: ../buscarOdontologos.php?respuesta=error");
        }
    }*/

}
?>