<?php
defined( 'BASEPATH' ) OR exit( 'Petición directa no permitida' );

require APPPATH.'/libraries/REST_Controller.php';

class Giros extends REST_Controller {

    public function __construct() {
        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-API-KEY, Origin, Content-Type, X-Auth-Token');
       
        $test = $this->load->database();
        $this->load->model( 'Giro_model' );
    }

    public function index_get() {

        $respuesta = array(
            'err'=>FALSE,
            'mensaje'=>'Giros Index Correcto'
        );
        echo json_encode( $respuesta );
    }

    /* Default CRUD */
    public function add_put(){
        
        $data =  $this->put();
        
        $bandera = true;
        $validacion = '';
       
        // Validar
        if( $data['pswd'] != $data['pswdConfirmar']) {
           $validacion = 'El password y la confirmación son diferentes';
           $bandera = false;
        }
        
        if ($bandera){
            $respuesta = $this->Usuario_model->put_add( $data );
        }else{
            $respuesta = array(
                'err'     => true,
                'mensaje' => $validacion
            );
        }

        $this->response( $respuesta, REST_Controller::HTTP_OK );
    }

    public function all_get() {
        $data = $this->Giro_model->get_all();
        $this->response( $data, REST_Controller::HTTP_OK );
    }

    public function id_get() {

        $_id = $this->uri->segment( 3 );
        $data = $this->Giro_model->get_id( $_id );
        
        $this->response( $data, REST_Controller::HTTP_OK );

    }

    public function upd_post(){
    }
 
    public function del_post() {

        $_id = $this->uri->segment( 3 );

        $data = $this->Giro_model->post_del( $_id );
        $this->response( $data, REST_Controller::HTTP_OK );

    }


    /* Especiales */
    public function tipo_get() {

        $_tipo = $this->uri->segment( 3 );
       
        $data = $this->Giro_model->get_tipo( $_tipo );
        $this->response( $data, REST_Controller::HTTP_OK );
    }

}
