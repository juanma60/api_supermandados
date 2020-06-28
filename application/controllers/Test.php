<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
        echo 'Hola Crayola';
		//$this->load->view('welcome_message');
    }
    
    public function comentarios(){
        echo 'Algún comentario x....';
    }

    public function comentariosA(){

        $comentarios = array(
            array('id' => 1,'nombre' => 'juan'),
            array('id' => 2,'nombre' => 'manuel'),
            array('id' => 3,'nombre' => 'sanchez')
        );

        echo json_encode( $comentarios);
    }

    public function comentariosId($id){

        $comentarios = array(
            array('id'=>1,'nombre'=>'patricia'),
            array('id'=>2,'nombre'=>'badillo'),
            array('id'=>3,'nombre'=>'barron')
        );

        echo json_encode( $comentarios[$id]);
    }

    public function comentariosIdV($id){
        
        if (!isset($id)){
            $respuesta = array(
                'err'=>true,
                'mensaje'=>'Falta el parametro'
            );

            echo json_encode($respuesta);
            return;
        }

        if (!is_numeric($id)){
            $respuesta = array(
                'err'=>true,'mensaje'=>'El parametro debe ser numerico'
            );

            echo json_encode($respuesta);
            return;
        }

        $comentarios = array(
            array('id'=>1,'nombre'=>'patricia'),
            array('id'=>2,'nombre'=>'badillo'),
            array('id'=>3,'nombre'=>'barron')
        );

        if ( $id >= count($comentarios) OR $id < 0 ){
            $respuesta = array(
                'err'=>true,'mensaje'=>'El parametro no existe'
            );

            echo json_encode($respuesta);
            return;
        }



        echo json_encode( $comentarios[$id]);
    }

}
