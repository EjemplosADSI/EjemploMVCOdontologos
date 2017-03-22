<?php

/**
 * Created by PhpStorm.
 * User: CAPACITACION-PC
 * Date: 16/2/2017
 * Time: 22:07
 */
require_once('db_abstract_class.php');

class Paciente extends db_abstract_class
{

    private $idPaciente;
    private $Nombres;
    private $Apellidos;
    private $TipoDocumento;
    private $Documento;
    private $Direccion;
    private $Email;
    private $Genero;
    private $User;
    private $Password;
    private $Foto;
    private $Estado;

    public function __construct($odontologos_data=array())
    {
        parent::__construct();
        if(count($odontologos_data)>1){
            foreach ($odontologos_data as $campo => $valor){
                $this->$campo = $valor;
            }
        }else {
            $this->idPaciente = "";
            $this->Nombres = "";
            $this->Apellidos = "";
            $this->TipoDocumento = "";
            $this->Documento = "";
            $this->Direccion = "";
            $this->Email = "";
            $this->Genero = "";
            $this->User = "";
            $this->Password = "";
            $this->Foto = "";
            $this->Estado = "";
        }
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
        unset($this);
    }

    /**
     * @return mixed
     */
    public function getIdPaciente()
    {
        return $this->idPaciente;
    }

    /**
     * @param mixed $idPaciente
     */
    public function setIdPaciente($idPaciente)
    {
        $this->idPaciente = $idPaciente;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->Nombres;
    }

    /**
     * @param mixed $Nombres
     */
    public function setNombres($Nombres)
    {
        $this->Nombres = $Nombres;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->Apellidos;
    }

    /**
     * @param mixed $Apellidos
     */
    public function setApellidos($Apellidos)
    {
        $this->Apellidos = $Apellidos;
    }

    /**
     * @return mixed
     */
    public function getTipoDocumento()
    {
        return $this->TipoDocumento;
    }

    /**
     * @param mixed $TipoDocumento
     */
    public function setTipoDocumento($TipoDocumento)
    {
        $this->TipoDocumento = $TipoDocumento;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->Documento;
    }

    /**
     * @param mixed $Documento
     */
    public function setDocumento($Documento)
    {
        $this->Documento = $Documento;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->Direccion;
    }

    /**
     * @param mixed $Direccion
     */
    public function setDireccion($Direccion)
    {
        $this->Direccion = $Direccion;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->Genero;
    }

    /**
     * @param mixed $Genero
     */
    public function setGenero($Genero)
    {
        $this->Genero = $Genero;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param string $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @return string
     */
    public function getFoto()
    {
        return $this->Foto;
    }

    /**
     * @param string $Foto
     */
    public function setFoto($Foto)
    {
        $this->Foto = $Foto;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @param mixed $Estado
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    public static function buscarForId($id)
    {
        $pacien = new Paciente();
        if ($id > 0){
            $getrow = $pacien->getRow("SELECT * FROM odontologos.paciente WHERE idPaciente =?", array($id));
            $pacien->idPaciente = $getrow['idPaciente'];
            $pacien->Nombres = $getrow['Nombres'];
            $pacien->Apellidos = $getrow['Apellidos'];
            $pacien->TipoDocumento = $getrow['TipoDocumento'];
            $pacien->Documento = $getrow['Documento'];
            $pacien->Direccion = $getrow['Direccion'];
            $pacien->Email = $getrow['Email'];
            $pacien->Genero = $getrow['Genero'];
            $pacien->User = $getrow['User'];
            $pacien->Password = $getrow['Password'];
            $pacien->Foto = $getrow['Foto'];
            $pacien->Estado = $getrow['Estado'];
            $pacien->Disconnect();
            return $pacien;
        }else{
            return NULL;
        }
    }

    public static function buscar($query)
    {
        $arrPacientes = array();
        $tmp = new Paciente();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $pacien = new Paciente();
            $pacien->idPaciente = $valor['idPaciente'];
            $pacien->Nombres = $valor['Nombres'];
            $pacien->Apellidos = $valor['Apellidos'];
            $pacien->TipoDocumento = $valor['TipoDocumento'];
            $pacien->Documento = $valor['Documento'];
            $pacien->Direccion = $valor['Direccion'];
            $pacien->Email = $valor['Email'];
            $pacien->Genero = $valor['Genero'];
            $pacien->User = $valor['User'];
            $pacien->Password = $valor['Password'];
            $pacien->Foto = $valor['Foto'];
            $pacien->Estado = $valor['Estado'];
            array_push($arrPacientes, $pacien);
        }
        $tmp->Disconnect();
        return $arrPacientes;
    }

    public static function getAll()
    {
        return Paciente::buscar("SELECT * FROM odontologos.paciente");
    }

    public function insertar()
    {
        $this->insertRow("INSERT INTO odontologos.paciente VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->Nombres,
                $this->Apellidos,
                $this->TipoDocumento,
                $this->Documento,
                $this->Direccion,
                $this->Email,
                $this->Genero,
                $this->User,
                $this->Password,
                $this->Foto,
                $this->Estado
            )
        );
        $this->Disconnect();
    }

    public function editar()
    {
        $arrUser = (array) $this;
        $this->updateRow("UPDATE odontologos.paciente SET Nombres = ?, Apellidos = ?, TipoDocumento = ?, Documento = ?, Direccion = ?, Email = ?, Genero = ?, User = ?, Password = ?, Foto = ?, Estado = ? WHERE idPaciente = ?", array(
            $this->Nombres,
            $this->Apellidos,
            $this->TipoDocumento,
            $this->Documento,
            $this->Direccion,
            $this->Email,
            $this->Genero,
            $this->User,
            $this->Password,
            $this->Foto,
            $this->Estado,
            $this->idPaciente
        ));
        $this->Disconnect();

    }

    function getCitas (){
        $arrCitas = Cita::buscar("SELECT * FROM odontologos.cita WHEN idPaciente = ".$this->idPaciente);
        return $arrCitas;
    }

    protected function eliminar($id)
    {
        if ($id > 0){
            return $this->deleteRow("DELETE FROM odontologos.paciente WHERE id = ?", array($id));
        }else{
            return false;
        }
    }



}