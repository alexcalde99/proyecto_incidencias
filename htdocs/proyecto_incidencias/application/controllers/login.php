<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    /**
     * @param mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->load->model('Users_model');
        $this->load->library('session');
        date_default_timezone_set('Europe/Madrid');
    }
    public function index(){
        $this->load->view('login');
    }

    /******************************************************************************
     * funcion validar usuarios
     *****************************************************************************/
    public function validate_user(){

        //echo "<script>alert('Acceso incorrecto.');</script>";

        $user = $this->input->post('username');
        $password = $this->input->post('password');

        //cargamos el modelo users
        $this->load->model('users_model');
        //llamamos a la funcion validate_user que esta en user_model.....si es correcto nos envia al home
        if($this->users_model->validate_user($user, $password)){
            redirect('backoffice/crud_usuarios');
        }else {

            $this->load->view('home/login');
        }

    }


    public function logout(){
        $this->session->set_userdata('usuario', "");
        $this->session->sess_destroy();
        redirect('Front_controller/index');
    }
}