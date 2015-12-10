<?php

Class Home extends CI_Controller{

    public function index(){
        $this->load->view('home/login');
    }


    public function cargarAdministracion(){
        $this->load->view('home/index');
    }

}