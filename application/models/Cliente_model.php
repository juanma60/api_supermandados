<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_model{

    public $id;
    public $nombre;
    public $activo;
    public $correo;
    public $zip;
    public $telefono1;
    public $telefono2;
    public $pais;
    public $direccion;
    public $status;
    

    public function get_cliente( $id ){

        $this->db->where( array('id'=> $id));
        $query = $this->db->get('clientes');

        $row = $query->custom_row_object(0,'Cliente_model');   
        
       if($row){
           $row->id = intval($row->id);
           // $row->activo = intval($row->activo);
       }

        return $row;
    }

    public function insert( $data ){
        // Cada cliente tiene un correo unico, validar el correo.
        $query = $this->db->get_where('clientes',array('correo'=> $data['correo']));
        $cliente_correo = $query->row();

        if(isset($cliente_correo)){
            // Si existe el correo
            $respuesta = array(
                'err'=> TRUE,
                'mensaje'=>'El correo electronico ya esta registrado'
            );

                return $respuesta;
        }

        $resultado = $this->db->insert( 'clientes', $data );

        if(isset($resultado) && !is_array($resultado)){
            // Si fue insertado
            $respuesta = array(
                'err'=>FALSE,
                'codigo'=>200,
                'id'=> $this->db->insert_id(),
                'mensaje'=>'Registro insertado correctamente con id -> '.$this->db->insert_id()
            );

        }else{
            // No logro la insercion
            $respuesta = array(
                'err'=>TRUE,
                'codigo'=>500,
                'mensaje'=>'Error al realizar la insercion'
            );

        }

        return $respuesta;
    }

    public function update( $data){

        // Cada cliente tiene un correo unico, omitirse asi mismo.
        $this->db->where ('correo = ',$data['correo']);
        $this->db->where('id !=',$data['id']);
        $query = $this->db->get('clientes');

        $cliente_correo = $query->row();

        if(isset($cliente_correo)){
            // Si existe el correo
            $respuesta = array(
                'err'=> TRUE,
                'mensaje'=>'El correo electronico ya esta registrado por otro usuario'
            );

            return $respuesta;
        }

        //limpiar el where
        $this->db->reset_query();
        $this->db->where('id',$data['id']);

        $resultado = $this->db->update( 'clientes', $data );

        if(isset($resultado) && !is_array($resultado)){
            // Si fue actualizado
            $respuesta = array(
                'err'=>FALSE,
                'codigo'=>200,
                'id'=> $data['id'],
                'mensaje'=>'Registro actualizado correctamente con id -> '.$data['id']
            );

        }else{
            // No logro la actualizacion
            $respuesta = array(
                'err'=>TRUE,
                'codigo'=>500,
                'mensaje'=>'Error al realizar la inactualizacion'
            );

        }

        return $respuesta;
    }

    public function delete( $id ){

        $this->db->set('status','borrado');
        $this->db->where('id', $id);

        $resultado = $this->db->update('clientes');

        if(isset($resultado) ){
            // Si fue borrado
            $respuesta = array(
                'err'=>FALSE,
                'codigo'=>200,
                'id'=> $data['id'],
                'mensaje'=>'Registro borrado correctamente con id -> '.$id
            );

        }else{
            // No logro el borrado
            $respuesta = array(
                'err'=>TRUE,
                'codigo'=>500,
                'mensaje'=>'Error al realizar el borrado'
            );

        }

        return $respuesta;        

    }
}