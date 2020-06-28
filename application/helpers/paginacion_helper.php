<?php

function paginado($tabla, $pagina , $por_pagina, $campos = array() ){

    // En un helper no se puede utizar el $this, por lo cual hay que instanciar
    $CI =& get_instance();
    $CI->load->database(); 

    if(!isset($pagina)){ $pagina = 1;}
    if(!isset($por_pagina)){ $por_pagina = 10;}

    $cuantos = $CI->db->count_all( $tabla );
    $total_paginas = ceil( $cuantos / $por_pagina);

    $pagina -= 1;
    $desde = $pagina * $por_pagina;

    if($pagina >= $total_paginas -1){
        $pag_siguiente = 1;
    }else{
        $pag_siguiente = $pagina + 2;
    }

    if($pagina < 1){
        $pag_anterior = $total_paginas;
    }else{
        $pag_anterior = $pagina;
    }

    $CI->db->select( $campos );
    $query = $CI->db->get($tabla, $por_pagina, $desde);

    $respuesta = array(
        'err'=>FALSE,
        'mensaje'=>'OK',
        'pagina'=>$pagina,
        'por_pagina'=>$por_pagina,
        'cuantos'=>$cuantos,
        'total_paginas'=>$total_paginas,
        'pag_anterior' => $pag_anterior,
        'pag_actual' => $pagina + 1,
        'pag_siguiente' => $pag_siguiente,
        $tabla=>$query->result()

    );

    return $respuesta;
}

?>
