<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// required headers

header("Access-Control-Allow-Origin: *");
/*
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
*/
require APPPATH.'/libraries/REST_Controller.php';


class Clientes extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Cliente_model');
    }

    // Default 
    public function index_get(){

        $this->load->helper('utilidades');

        $data = array(
            'nombre'=>'juan manuel',
            'contacto'=>'patricia',
            'direccion'=>'alcatraces villa de las flores'
        );

        //$data['nombre'] = strtoupper($data['nombre']);
        $campos = array('nombre','contacto','direccion');
        $data = capitalizar( $data, $campos);

        echo json_encode( $data );

    }    

    // Insertar registros 
    public function cliente_put(){

        $data = $this->put();
        // Cargar la libreria de validacion
        $this->load->library('form_validation');
        // Asignar lo que se va a validar
        $this->form_validation->set_data( $data );
        // Resultado de la validacion, True->bien False-algo no cumplio
        if( $this->form_validation->run('cliente_put') ){
            // Todo bien
            $respuesta = $this->Cliente_model->insert( $data);

            if ( $respuesta['err']){
                $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );

            }else{
                $this->response( $respuesta );

            }

        }else{

            $respuesta = array(
                'err'=> TRUE,
                'codigo'=> 400,
                'mensajes'=>'errores encontrados.',
                'errores'=> $this->form_validation->get_errores_arreglo()
            );

            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        }
        //---- Validacion fin.

        $this->response( $data );
    }

    // Obtener registro
    public function cliente_get(){


        $cliente_id = $this->uri->segment(3);
        //Validar parametro
        if ( !isset($cliente_id)){

            $respuesta = array(
                'err'=> TRUE,
                'codigo'=>400,
                'mensaje'=>'Se requiere el Id del cliente'
            );

            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
            return;
        }

        $cliente = $this->Cliente_model->get_cliente($cliente_id);
        //$this->response($cliente);

        // Validar el resultado
        if(isset($cliente)){
            //quitar campos en la espuesta json
            //unset($cliente->telefono1,$cliente->telefono2);

            $respuesta = array(
                'err'=>FALSE,
                'codigo'=>200,
                'mensaje'=>'Registro cargado..',
                'cliente'=>$cliente
            );

            $this->response($respuesta,REST_Controller::HTTP_OK );

        }else{

            $respuesta = array(
                'err'=>TRUE,
                'codigo'=>404,
                'mensaje'=>'El registro con el id ->'.$cliente_id.' no existe..',
                'cliente'=> $cliente
            );


            $this->response($respuesta,REST_Controller::HTTP_NOT_FOUND );
            //$this->db->error() , $this->db->_error_message() y $this->db->_error_number().
        }


        //echo $id." - ".$cliente_id;
    }

    // Actualizar registro
    public function cliente_post(){

        $data = $this->post();
        
        //echo $data;

        $data['id'] = $this->uri->segment(3);

        /*
        // Cargar la libreria de validacion
        $this->load->library('form_validation');
        // Asignar lo que se va a validar
        $this->form_validation->set_data( $data );
         // Resultado de la validacion, True->bien False-algo no cumplio
        if( $this->form_validation->run('cliente_post') ){
            // Todo bien
            $respuesta = $this->Cliente_model->update( $data);

            if ( $respuesta['err']){

                $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );

            }else{

                $this->response( $respuesta );
            }

        }else{

            $respuesta = array(
                'err'=> TRUE,
                'codigo'=> 400,
                'mensajes'=>'errores encontrados.',
                'errores'=> $this->form_validation->get_errores_arreglo()
            );

            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        }
        //---- Validacion fin.
        */

        $respuesta = $this->Cliente_model->update( $data);
        $this->response( $data );
    }
 
    // Borrar registro
    public function cliente_delete(){

        $cliente_id = $this->uri->segment(3);

        $respuesta = $this->Cliente_model->delete($cliente_id);

        $this->response( $respuesta);
    }

    // Paginar registros
    public function paginar_get(){

        $this->load->helper('paginacion');
        
        $pagina = $this->uri->segment(3);
        $por_pagina = $this->uri->segment(4);

        $campos = array('id', 'nombre', 'telefono1', 'telefono2');
        $respuesta = paginado('clientes', $pagina, $por_pagina, $campos);

        $this->response($respuesta);
    }

    // PRUEBAS HISTORICO

    // Insertar registros controlador con todo el codigo. el cual se va a pasar al modelo
    public function xcliente_put(){

        $data = $this->put();

        //--- Validacion

        // Cargar la libreria de validacion
        $this->load->library('form_validation');
        // Asignar lo que se va a validar
        $this->form_validation->set_data( $data );
        // Definir reglas de validacion campo,etiqueta,reglas
        //$this->form_validation->set_rules('correo','correo electronico','required|valid_email');
        //$this->form_validation->set_rules('nombre','nombre','required|min_length[3]');
        //$this->form_validation->set_rules('zip','zip','required');

        // Resultado de la validacion, True->bien False-algo no cumplio
        if( $this->form_validation->run('cliente_put') ){
            //$this->response( 'Validacion OK ');

            // Cada cliente tiene un correo unico, validar el correo.
            $query = $this->db->get_where('clientes',array('correo'=> $data['correo']));
            $cliente_correo = $query->row();

            if(isset($cliente_correo)){
                // Si existe el correo
                $respuesta = array(
                    'err'=> TRUE,
                    'mensaje'=>'El correo electronico ya esta registrado'
                );

                $this->response( $respuesta,REST_Controller::HTTP_BAD_REQUEST);
                return;
            }

            $resultado = $this->db->insert( 'clientes', $data );
            /*
            var_dump($resultado);
            if (is_array($resultado)){
                echo 'es un arreglo -> '.$resultado[0];
            }else{
                echo 'no arreglo';
            }
            */
            if(isset($resultado) && !is_array($resultado)){
                // Si fue insertado
                $respuesta = array(
                    'err'=>FALSE,
                    'codigo'=>200,
                    'id'=> $this->db->insert_id(),
                    'mensaje'=>'Registro insertado correctamente con id -> '.$this->db->insert_id()
                );
    
                $this->response( $respuesta );
    
            }else{
                // No logro la insercion
                $respuesta = array(
                    'err'=>TRUE,
                    'codigo'=>500,
                    'mensaje'=>'Error al realizar la insercion'

                    //-- ir a DB_driver.php linea 692 -> return  array($error['code'], $error['message'], $sql);
                    //'db_error_codigo'=> $resultado[0], //$this->db->_error_message(),
                    //'db_error_mensaje'=> $resultado[1], //$this->db->_error_number()
                    //'db_error_sql'=> $resultado[2] //$this->db->_error_number()
                );

                $this->response( $respuesta,REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }


        }else{
            //$this->response( 'algo esta mal');

            $respuesta = array(
                'err'=> TRUE,
                'codigo'=> 400,
                'mensajes'=>'errores encontrados.',
                'errores'=> $this->form_validation->get_errores_arreglo()
            );

            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        }
        //---- Validacion fin.

        $this->response( $data );
    }

}

