<?php
defined( 'BASEPATH' ) OR exit( 'Petición directa no permitida' );

require APPPATH.'/libraries/REST_Controller.php';

class Usuarios extends REST_Controller {

    public function __construct() {
        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, X-Auth-Token");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        /*
        $key_value = $this->input->get_request_header("X-API-KEY");
        $respuesta = array(
            'err'     => false,
            'mensaje' => 'CONSTRUCTOR',
            'key' => $key_value
        );
        $this->response( $respuesta, REST_Controller::HTTP_OK );
        */

        $test = $this->load->database();
        $this->load->model( 'Usuario_model' );

        /*PENDIENTE CACHAR ERROR
        //$db_error = $this->db->error();
        //echo json_encode( $db_error );
        if ( empty( !$test ) ) {
            echo 'ERROR AL CONECTAR';
            //throw new Exception( 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'] );
            //return false;
            // unreachable return statement !!!`enter code here`
        } else {
            echo 'SE CONECTO';
        }
        */
    }

    public function index_get() {

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Usuarios -> Index Correcto'
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
        $usuarios = $this->Usuario_model->get_all();
        $this->response( $usuarios, REST_Controller::HTTP_OK );
    }

    public function id_get() {

        $_id = $this->uri->segment( 3 );
        $usuarios = $this->Usuario_model->get_id( $_id );
        
        $this->response( $usuarios, REST_Controller::HTTP_OK );

    }

    public function upd_post(){
    }
 
    public function del_post() {

        $_id = $this->uri->segment( 3 );

        $usuarios = $this->Usuario_model->post_del( $_id );
        $this->response( $usuarios, REST_Controller::HTTP_OK );

    }


    /* Especiales */
    public function login_get() {

        $_login = $this->uri->segment( 3 );
        $_password = $this->uri->segment( 4 );

        $usuario = $this->Usuario_model->get_login( $_login, $_password );
        $this->response( $usuario, REST_Controller::HTTP_OK );
    }

    public function upd_cliente_post(){
        
        $id = $this->uri->segment( 3 );
        $data =  $this->post();

        $respuesta = $this->Usuario_model->post_upd_cliente( $id, $data );
        
        $this->response( $respuesta, REST_Controller::HTTP_OK );
    }

    public function test_get() {

        $respuesta = array(
            'err'=>FALSE,
            'mensaje'=>'Test'
        );
        echo json_encode( $respuesta );
    }

}