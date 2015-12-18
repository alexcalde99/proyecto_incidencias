<?php

class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        //FA LA CONEXIO
        $this->load->database(); //Per a poder gastar totes les funcions de la base de dades
        //$this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->model('Users_model');
    }


    /******************************************************************************
     * funcion validar usuario
     *****************************************************************************/
    public function validate_user($user,$password){


        $sql = "SELECT * FROM usuarios WHERE user=?";
        $query = $this->db->query($sql, array($user));

        $result=$query->row();

        $pass=$result->clave;
        $pass=$this->encrypt->decode($pass);
        //pas esta desencriptado

        $data = array(
            'user_id'=>$result->id,
            'user'  => $user,
            'password'     => $password

        );

        if ($pass == $password) {
            $this->session->set_userdata($data);
            return true;
        } else {
            return false;

        }

    }




    /******************************************************************************
     * funcion ENCRIPTAR usuario
     * Le pasamos un pass y nos devuelve un pass encriptado
     *****************************************************************************/
    public function encriptar_usuario($post_array){

        $post_array['clave'] = $this->encrypt->encode($post_array['clave']);
        return $post_array;

    }

    /******************************************************************************
     * funcion DESENCRIPTAR usuario
     *  Le pasamos un pass encriptado y nos devuelve un pass
     *****************************************************************************/















}

