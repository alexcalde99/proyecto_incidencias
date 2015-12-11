<?php
class Email extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index(){
        $this->load->view('home/index.php');
    }

    public function enviarEmail($to,$subject,$message){

        //Cargamos la librer�a email
        $this->load->library('email');

        /*
         * Configuramos los par�metros para enviar el email,
         */
        //Indicamos el protocolo a utilizar
        $config['protocol'] = 'smtp';

        //El servidor de correo que utilizaremos
        $config["smtp_host"] = 'smtp.gmail.com';

        //Nuestro usuario
        $config["smtp_user"] = 'alexcalde999@gmail.com';

        //Nuestra contrase�a
        $config["smtp_pass"] = 'Sailer9a+';

        //El puerto que utilizar� el servidor smtp
        $config["smtp_port"] = '587';

        //El juego de caracteres a utilizar
        $config['charset'] = 'utf-8';

        //Permitimos que se puedan cortar palabras
        $config['wordwrap'] = TRUE;

        //El email debe ser valido
        $config['validate'] = true;


        //Establecemos esta configuraci�n
        $this->email->initialize($config);

        //Ponemos la direcci�n de correo que enviar� el email y un nombre
        $this->email->from('alexcalde999@gmail.com', 'Alejandro Calderon');

        /*
         * Ponemos el o los destinatarios para los que va el email
         * en este caso al ser un formulario de contacto te lo enviar�s a ti
         * mismo
         */
        $this->email->to($to);

        //Definimos el asunto del mensaje
        $this->email->subject($subject);

        //Definimos el mensaje a enviar
        $this->email->message($message);


        //Enviamos el email y si se produce bien o mal que avise con una flasdata
        if($this->email->send()){
            return $this->session->set_flashdata('envio', 'Email enviado correctamente');
        }else{
            return $this->session->set_flashdata('envio', 'No se a enviado el email');
        }

        redirect(base_url("home/index"));
    }
}
