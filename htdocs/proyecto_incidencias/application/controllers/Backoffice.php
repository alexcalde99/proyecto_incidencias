<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Backoffice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
        date_default_timezone_set('Europe/Madrid');
    }

    public function index(){

        $this->load->view('login.php');
    }






    /******************************************************************************
     * funcion CRUD usuarios
     *****************************************************************************/
    function crud_usuarios(){

        $this->load->model('Users_model');
        $crud = new grocery_CRUD();
        $crud->set_table('usuarios');
        //para mostra la contraseña encriptada en ******* el camñpo clave que sea de tipo password..pa ocultarlo
        $crud->field_type('clave','password');
        $crud->callback_before_insert(array($this->Users_model,'encriptar_usuario'));

        $output = $crud->render();

        $this->load->view('home/index', $output);


    }


    /******************************************************************************
     * funcion CRUD incidencias
     *****************************************************************************/


    function crud_incidencias(){
        //creamos objeto crud
        $crud = new grocery_CRUD();
        //Seleccionar la tabla incidencias
        $crud->set_table('incidencias');
        //objetener la info de la tabla en un array, para despues mostrar
        $output = $crud->render();

        //a la vista-backofffice le paso el output(array)
        $this->load->view('home/index', $output);


    }

    /******************************************************************************
     * funcion CRUD ROLES
     *****************************************************************************/

    function crud_roles(){
        //creamos objeto crud
        $crud = new grocery_CRUD();
        //Seleccionar la tabla ROLES
        $crud->set_table('roles');
        //obtener la info de la tabla en un array, para despues mostrar
        $output = $crud->render();

        //a la vista-backoffice le pasamos el output(array)
        $this->load->view('home/index', $output);


    }

    /******************************************************************************
     * funcion CRUD ROLES
     *****************************************************************************/

    function crud_tipo_incidencias(){
        //creamos objeto crud
        $crud = new grocery_CRUD();
        //Seleccionar la tabla TIPOS INCIDENCIAS
        $crud->set_table('tipos_incidencias');
        //obtener la info de la tabla en un array, para despues mostrar
        $output = $crud->render();

        //a la vista-backoffice le pasamos el output(array)
        $this->load->view('home/index', $output);

    }

    /*/******************************************************************************
     * funcion CRUD HISTORICO INCIDENCIAS
     *****************************************************************************/

    function crud_historico_incidencias(){
        //creamos objeto crud
        $crud = new grocery_CRUD();
        //selecionamos la tabla incidencias
        $crud->set_table('incidencias');
        //para quitar las opcinesd e editar
        $crud->unset_edit();
        //quitar las opciones de añadir
        $crud->unset_add();
        //quitar las opciones de borrar
        $crud->unset_delete();
        $crud->like("estado", "CERRADA");
        $output=$crud->render();

        //a la vista-backoffice le pasamos el output(array)
        $this->load->view('home/index', $output);

    }











    /******************************************************************************
     * funcion logout       *
     *****************************************************************************/

    function logout(){

    }


}