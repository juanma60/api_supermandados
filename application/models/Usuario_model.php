<?php
defined( 'BASEPATH' ) OR exit( 'Petición directa no permitida' );

class Usuario_model extends CI_model {
    public $id_user;
    public $login;
    public $pswd;
    public $name;
    public $email;
    public $active;
    public $activation_code;
    public $priv_admin;


    /* Default CRUD */
    public function put_add( $data ) {
        /*$data = array('usuario'    => 'juanManu');*/

        $this->db->insert( 'sec_users', $data );

        $respuesta = array(
            'err'     => FALSE,
            'mensaje' => $this->db->insert_id()
        );

        $sql = "INSERT INTO sec_users_groups (login, group_id) VALUES ('". $data['login']."',2)";
        $query = $this->db->query( $sql );
        
        return $respuesta;
    }

    public function get_all() {

        $sql = 'call spS_usuario(null)'; //'SELECT * FROM sec_users'
        $query = $this->db->query( $sql );

        $respuesta = array(
            'err'=>FALSE,
            'mensaje'=>'',
            'registros'=>$query->num_rows(),
            'usuarios'=>$query->result()
        );

        return $respuesta;
    }

    public function get_id( $id ) {

        // validar parametro recibido
        if ( $id == '' OR !is_numeric( $id ) OR  $id < 1 ) {

            $respuesta = array(
                'err'=> TRUE,
                'codigo'=>400,
                'mensaje'=>'Se requiere un Id válido (numérico mayor a 0).'
            );

            return $respuesta;
        }

        //$query = $this->db->query( 'SELECT * FROM sec_users WHERE id_user = ' .$id );
        $sql = 'call spS_usuario('.$id.')';
        $query = $this->db->query( $sql );

        $row = $query->custom_row_object( 0, 'Usuario_model' );

        if ( isset( $row->error ) ) {

            $respuesta = array(
                'err'=>TRUE,
                'mensaje'=>$row->error,
                'registros'=>0,
                'usuario'=>null
            );

            return $respuesta;
        }

        if ( $query->num_rows() > 0 ) {

            $respuesta = array(
                'err'=>FALSE,
                'mensaje'=>'',
                'registros'=>$query->num_rows(),
                'usuario'=>$row
            );

        } else {

            $respuesta = array(
                'err'=>TRUE,
                'mensaje'=>'No existe registro del id '.$id,
                'registros'=>$query->num_rows(),
                'usuario'=>$row
            );

        }

        return $respuesta;

    }

    public function post_upd( $id, $data){
    }

    public function post_del( $id ){
        // validar parametro recibido
        if ( $id == '' OR !is_numeric( $id ) OR  $id < 1 ) {

            $respuesta = array(
                'err'=> TRUE,
                'codigo'=>400,
                'mensaje'=>'Se requiere un Id válido (numérico mayor a 0).'
            );

            return $respuesta;
        }

        $sql = "DELETE FROM sec_users WHERE id_user = " . $id;
        $query = $this->db->query( $sql );

        $respuesta = array(
            'err'=>TRUE,
            'mensaje'=>'Registro eliminado'.$id,
            'registros'=>0,
            'usuario'=>null
        );

        return $respuesta;
    }

    /* Especiales */
    public function get_login( $usuario, $password ) {

        //$sql = "SELECT * FROM sec_users WHERE login = '" .$usuario."' AND pswd ='".$password."'";
        $sql = "call spS_usuario_login('".$usuario."','".$password."')";
        $query = $this->db->query( $sql );

        $row = $query->custom_row_object( 0, 'Usuario_model' );

        if ( $query->num_rows() > 0 ) {

            $respuesta = array(
                'err'=>FALSE,
                'mensaje'=>'',
                'registros'=>$query->num_rows(),
                'usuario'=>$row
            );

        } else {

            $respuesta = array(
                'err'=>TRUE,
                'mensaje'=>'Usuario/Password invalido(s).',
                'registros'=>0,
                'usuario'=>null
            );

        }

        return $respuesta;

    }

    public function post_upd_cliente( $id, $data ){

        $this->db->update( 'clientes', $data, "id_user = ".$id );

        $respuesta = array(
            'err'     => FALSE,
            'mensaje' => 'Registro actualizado desde servicio',
            'data' => $data,
            'id' => $id
        );

        return $respuesta;
    }


}