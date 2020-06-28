<?php

function capitalizar_todo($data){
    
    return capitalizar( $data,array(),TRUE);
}

function capitalizar( $data, $campos = array(),$todos = FALSE){

    $data_lista = $data;

    foreach ($data as $nombre_campo => $valor_campo) {
        
        if ( in_array( $nombre_campo,array_values($campos)) OR $todos ){

            $data_lista[ $nombre_campo] = strtoupper( $valor_campo);
        }
    }

    return $data_lista;
}

function obtener_mes( $mes ){

    $mes -= 1;

    $meses = array(
        'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','dciembre'
    );

    return $meses[ $mes ];
}

?>