<?php

class Meses extends CI_Controller {

    public function mez( $mes ){

        $meses = array(
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',            
            'septiembre',            
            'octubre',            
            'noviembre',            
            'diciembre'
        );

        echo json_encode( $meses[$mes-1] );
    }

    public function mes( $mes ){

        $this->load->helper('utilidades');

        echo json_encode( obtener_mes( $mes ));
    }

}