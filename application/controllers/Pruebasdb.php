<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebasdb extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->database();
        $this->load->helper('utilidades');
    }

    public function eliminar($id){
        
        $this->db->where('id', $id);
        $this->db->delete('test');

        echo 'registro eleminado';
    }

    public function actualizar($id){

        $data = array(
            'nombre'=>'Patricia',
            'apellido'=>'Badillo'
        );

        $data = capitalizar_todo($data);

        $this->db->where_in('id',$id);
        $this->db->update('test',$data);

        echo 'Todo bien !';
    }

    public function insertar(){

        $data = array(
            'nombre'    => 'juanMa',
            'apellido'  => 'sanchezGr'
        );

        //$data =  capitalizar( $data, array(), TRUE);
        $data = capitalizar_todo( $data);

        $this->db->insert('test', $data);

        $respuesta = array(
            'err'          => FALSE,
            'id_insertado' => $this->db->insert_id()
        );

        echo json_encode( $respuesta);
    }

    public function tabla($id){

       //$query = $this->db->query('select * from Clientes');
       //$query = $this->db->query('call spS_Clientes');
       $query = $this->db->query('call spS_Clientes('.$id.')');

        echo json_encode( $query->result());

        //$query = $this->db->get('clientes',5,5);
        //foreach ($query->result() as $fila) {
        //    echo $fila->nombre . '<br>';
        //}
        //echo json_encode( $query->result());

        //$this->db->select('id,nombre,correo, ( select count(*) from clientes ) as conteo');
        //$query = $this->db->get_where('clientes',array('id'=> 1));
        //echo json_encode($query->row());

        //$this->db->select('id,nombre,correo');
        //$this->db->from('clientes');
        //$query = $this->db->get();
        //echo json_encode( $query->result());

        //$this->db->select('id,nombre,correo');
        //$this->db->from('clientes');
        //$this->db->where('id',3);
        //$query = $this->db->get();
        //echo json_encode( $query->result());
    }

    public function usuarios(){

        $this->load->database();

        $query = $this->db->query('SELECT * FROM sec_users');
        /*
        foreach ($query->result() as $row) {
            echo $row->id;
            echo $row->nombre;
            echo $row->correo;
        }
        echo 'Total de registros: ' . $query->num_rows();
        */
        $respuesta = array(
            'err'=>FALSE,
            'mensaje'=>'Carga correcta',
            'registros'=>$query->num_rows(),
            'clientes'=>$query->result()
        );

        echo json_encode( $respuesta );
    }

    public function cliente($id){

        $query = $this->db->query('SELECT * FROM clientes WHERE id = ' . $id);
        
        $fila = $query->row();
        //      echo json_encode( $fila);

        if (isset($fila)) {
            // EXISTE FILA
            $respuesta = array(
                'err'=>FALSE,
                'mensaje'=>'Cliente encontrado',
                'total_registros'=>1,
                'cliente'=> $fila
            );
        }else{
            // NO EXISTE FILA
            $respuesta = array(
                'err'=>TRUE,
                'mensaje'=>'Cliente no registrado del id ' . $id,
                'total_registros'=>0,
                'cliente'=> null
            );

        }

        echo json_encode ( $respuesta );

    
  
    }

}