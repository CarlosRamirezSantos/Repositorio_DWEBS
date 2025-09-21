<?php

$tablero = [];
$parametros = explode("/",$_SERVER["REQUEST_URI"]);
//print_r($parametros);
unset($parametros[0]);

if ($_SERVER["REQUEST_METHOD"]==="GET"){

   
    if ($parametros[1] == "iniciar"){

       iniciarTablero($tablero, 10);
        $contador = 2;
        while ($contador>0){

        colocarMinas($tablero);

        $contador --;
        }
        colocarNumeros($tablero, 10);
        echo(toString($tablero));

    }

    if ($parametros[1] == "jugar"){
      
        
        $resultado = jugar($tablero, $parametros[2]);
        $tablero[] = $resultado;
        echo "$tablero"; //revisar esto

    }
}

// foreach ($_SERVER as $key => $value) {
//     echo $key.' -> '.$value.'<br>';
// }



function iniciarTablero(&$tab, $cant){
    for ($i=0; $i < $cant; $i++) { 
        $tab[] = '-';
    }
}

function colocarMinas(&$tab){

$colocada = false;

    do{
    $pos = rand(0, count($tab)-1);
    if ($tab[$pos] != '*'){
    $tab[$pos] = '*';
    $colocada = true;
    }

    }while(!$colocada);
}
function colocarNumeros(&$tab, $cant){

    for ($i = 0; $i < $cant; $i++) {
        if ($tab[$i] == '*') {
            // izquierda
            if ($i - 1 >= 0 && $tab[$i - 1] != '*') {
                if ($tab[$i - 1] === '-') {
                    $tab[$i - 1] = 1;   // estaba vacío
                } else {
                    $tab[$i - 1] += 1;  // ya tenía un número
                }
            }
            // derecha
            if ($i + 1 < $cant && $tab[$i + 1] != '*') {
                if ($tab[$i + 1] === '-') {
                    $tab[$i + 1] = 1;
                } else {
                    $tab[$i + 1] += 1;
                }
            }
        }
    }
}

function toString($tab){

    $cadena = "";
    for ($i=0; $i < count($tab); $i++) { 
        $cadena = $cadena . ' ' . $tab[$i]. ' ';
    }
    return $cadena;
}

/**
 * 1 -> bomba tocada
 * 2 -> Casi le das
 * 0 -> Ni se entera
 */
function jugar($tab, $pos) {
    
    $resultado = 0;

    if ($tab[$pos] == '*') {
        $resultado = 1;  // bomba tocada
    } else {
        // izquierda
        if ($pos > 0 && $tab[$pos - 1] == '*') {
            $resultado = 2;
        }
        // derecha
        if ($pos < count($tab) - 1 && $tab[$pos + 1] == '*') {
            $resultado = 2;
        }
    }

    return $resultado;
}










?>