<?php

class Base_Datos_Modelo extends  CI_Model
{


    public function __construct(){

        $this->load->database();


    }

    public function devolverEmail($id){


        $sql = "SELECT email FROM usuarios WHERE id=?";

        $query = $this->db->query($sql, array($id));

        $result=$query->row();

        $email = $result->email;


        return $email;

    }



    public function emailTecnicos($idTipoIncidencia){

        $sql = "SELECT * FROM tipos_incidencias WHERE idtipo=?";

        $query = $this->db->query($sql, array($idTipoIncidencia));

        $arrayEmail=array();

        $result=$query->row();

        //metemos en la posicion 0 del array el email que nos delvueve el id que le pasamos
        $arrayEmail[0]=$this->devolverEmail($result->idusuario);
        $arrayEmail[1]=$this->devolverEmail($result->idusuario2);
        $arrayEmail[2]=$this->devolverEmail($result->idusuario3);



        return $arrayEmail;

    }




}