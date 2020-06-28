<?php
defined( 'BASEPATH' ) OR exit( 'Petición directa no permitida' );

// required headers
header( 'Access-Control-Allow-Origin: *' );

require APPPATH.'/libraries/REST_Controller.php';

class Usuarios extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $test = $this->load->database();
        $this->load->model( 'Usuario_model' );

        /*
        $respuesta = array(
            'err'=>FALSE,
            'mensaje'=>'Constructor OK'
        );
        // echo json_encode( $respuesta );
        */
        
        //$data = json_decode(file_get_contents("php://input"));
        //var_dump( $data);
        /*
        $data = array(
            'nombre'=>$this->input->post('nombre'),
            'apellido'=>$this->input->post('apellido')
              );*/
        //echo json_encode($_POST);
              /*
        $datos = array(
            'nombre'=>$data['nombre'],
            'apellido'=>$data['apellido'],
              );*/
        //echo json_encode( $data);

        

        /*
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
            'err'=>FALSE,
            'mensaje'=>'Index Correcto'
        );
       // echo json_encode( $respuesta );
    }

    public function usuarioLogin_get() {

        $usuario_login = $this->uri->segment( 3 );
        $usuario_password = $this->uri->segment( 4 );

        $usuario = $this->Usuario_model->get_usuarioLogin( $usuario_login, $usuario_password );
        $this->response( $usuario, REST_Controller::HTTP_OK );
    }

    public function usuarios_get() {
        $usuarios = $this->Usuario_model->get_usuarios();
        $this->response( $usuarios, REST_Controller::HTTP_OK );
    }

    public function usuario_get() {

        $usuario_id = $this->uri->segment( 3 );

        $usuarios = $this->Usuario_model->get_usuario( $usuario_id );
        $this->response( $usuarios, REST_Controller::HTTP_OK );

    }

    public function insertarX_post() {
        var_dump($_POST);

        $data = array(
            'nombre'=>$_POST('nombre'),
            'apellido'=>$this->input->post('apellido')
              );
         var_dump($data);
        //echo json_encode($_POST);
        //$respuesta = $this->Usuario_model->post_insertar( $_POST );
        //$this->response( $respuesta, REST_Controller::HTTP_OK );

        //$data = $this->uri->segment( 3 );
        //$data = json_decode(file_get_contents("php://input"));
        /*
        $data = array(
            'nombre'=>$this->input->post('nombre'),
            'apellido'=>$this->input->post('apellido')
              );
        */
        /*
        $nombre=$this->input->post('nombre');
        $apellido=$this->input->post('apellido');
        $data = array(
            'nombre'=>$nombre,
            'apellido'=>$apellido
        );
        */
        /*
        if (isset($_POST[''])){
            $data = array('nombre'=>$_POST['nombre'],
                        'apellido'=>$_POST['apellido']);

        }
        else{
            $data = array(
                'err'          => TRUE,
                'mensaje' => 'No capte el POST'
            );
        }
        */
        //echo json_encode( $data);  
        /*
        $respuesta = $this->Usuario_model->post_insertar( $data );
        $this->response( $respuesta, REST_Controller::HTTP_OK );
        */
        
        
        /*
        $data = array(
            'nombre'    => 'juanMa',
            'apellido'  => 'sanchezGr'
        );

        $this->db->insert( 'test', $data );

        $respuesta = array(
            'err'          => FALSE,
            'id_insertado' => $this->db->insert_id()
        );

        // echo json_encode( $respuesta );
        */
    }

    public function insertar_put(){
        $data = $this->put();
        $respuesta = $this->Usuario_model->post_insertar( $data );
        $this->response( $respuesta, REST_Controller::HTTP_OK );
        
        //echo json_encode($data);
        //$this->response($data);

    }
}