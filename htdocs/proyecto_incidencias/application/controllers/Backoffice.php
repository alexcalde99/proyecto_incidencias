<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Backoffice extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
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
        //para mostra la contrase�a encriptada en ******* el cam�po clave que sea de tipo password..pa ocultarlo
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

        //ocultar numero de incidencias xq se pondra automaticamente
        $crud->field_type('numero', 'hidden');
        $crud->display_as("idtipo", "Tipo de Incidencia");
        $crud->field_type('fecha_alta','hidden');
        $crud->field_type('fecha_fin','hidden');
        $crud->field_type('idusuario','hidden');

        //menu despegable para tipo de inciencia
        $crud -> field_type ( 'idtipo' , 'dropdown' ,
            array ( '1' => 'INF','2' => 'MOBIL' , '3' => 'OBR' , '4' => 'FERR',
                '5'=> 'FUS' , '6'=>'ELECT','7'=>'CRIS','8'=>'PERS','9'=>'PINT',
                '10'=>'CONS','11'=>'FONT','12'=>'COMPR') ) ;


        //this xq esta en el mimso documento
        $crud->callback_before_insert(array($this,'insertCallbackIncidencias'));

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

        //menu despegable...dentro de field_type va la fila que se desea selecionar(nivel) y el tipo que va ser y un array con las opcioness
        $crud -> field_type ( 'nivel' , 'dropdown' ,
            array ( '0' => '0','1' => '1' , '2' => '2' , '3' => '3' ) ) ;
        //obtener la info de la tabla en un array, para despues mostrar
        $output = $crud->render();

        //a la vista-backoffice le pasamos el output(array)
        $this->load->view('home/index', $output);


    }

    /******************************************************************************
     * funcion CRUD tipo de incidencias
     *****************************************************************************/
    function crud_tipo_incidencias(){
        //creamos objeto crud
        $crud = new grocery_CRUD();
        //Seleccionar la tabla TIPOS INCIDENCIAS
        $crud->set_table('tipos_incidencias');

        //cambiamos la forma de visualizar en la vista
        $crud->display_as("codigo_tipo", "Codigo Incidencia");
        $crud->display_as("descripcion", "Descripcion Incidencia");
        $crud->display_as("idusuario", "ID Tecnico 1");

        //menu despegable para tecnico 1...dentro de field_type
        $crud -> field_type ( 'idusuario' , 'dropdown' ,
            array ( '0' => 'alexcalde999@gmail.com', '1' => 'email@email.com' ,
                '2' => 'alejandro_calderon99@gmail.com' , '3' => 'edgarshurtado@gmail.com' ) ) ;

        $crud->display_as("idusuario2", "ID Tecnico 2");
        //menu despegable para tecnico 3...dentro de field_type
        $crud -> field_type ( 'idusuario2' , 'dropdown' ,
            array ( '0' => 'alexcalde999@gmail.com', '1' => 'email@email.com' ,
                '2' => 'alejandro_calderon99@gmail.com' , '3' => 'edgarshurtado@gmail.com' ) ) ;

        $crud->display_as("idusuario3", "ID Tecnico 3");
        //menu despegable para tecnico 3...dentro de field_type
        $crud -> field_type ( 'idusuario3' , 'dropdown' ,
            array ( '0' => 'alexcalde999@gmail.com', '1' => 'email@email.com' ,
                '2' => 'alejandro_calderon99@gmail.com' , '3' => 'edgarshurtado@gmail.com' ) ) ;

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
        //quitar las opciones de a�adir
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

        $this->session->sess_destroy();
        $this->session->unset_userdata('');
        redirect('home/index');

        }


    /******************************************************************************
     * funcion CALLBACK       *
     *****************************************************************************/



    public function insertCallbackIncidencias($post_array){

        //convierte la fecha en un entero
        $post_array['numero']=date("YmdHi");

        $post_array['fecha_alta'] = date('Y-m-d H:i:s');
        $post_array['fecha_fin'] = "0000-00-00 00:00:00";
        $post_array['idusuario'] = $_SESSION['user_id'];



        $this->load->model('Email_Modelo');
        $this->load->model('Base_Datos_Modelo');


        $to = $this->Base_Datos_Modelo->emailTecnicos($post_array['idtipo']);
        //contrumos el sujeto del email, concatenamos el numero de incidecnias con el texto
        $subject = $post_array['numero'];
        $subject = 'Nueva incidencia Registrada N�:' . $subject;

        //contrumos el cupero del email
        $message = $post_array['descripcion'];
        $message = $message . "\n";
        $message = $message . "Numero de incidencia: " . $post_array['numero'] . "\n";
        $message = $message . "Fecha de alta: " . $post_array['fecha_alta'] .  "\n";


        $this->Email_Modelo->enviarEmail($to,$subject,$message);


        return $post_array;


    }

}