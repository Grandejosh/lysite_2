<?php
function cctom($string)
{
    //Reemplazamos la A y a
    $string = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $string
    );

    //Reemplazamos la E y e
    $string = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $string
    );

    //Reemplazamos la I y i
    $string = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $string
    );

    //Reemplazamos la O y o
    $string = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $string
    );

    //Reemplazamos la U y u
    $string = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $string
    );

    //Reemplazamos la N, n, C y c
    $string = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $string
    );
    return strtolower(preg_replace('([^A-Za-z0-9])', '', $string));
}
function rlang($string)
{
    return \Illuminate\Support\Facades\Lang::get($string);
}
function ui_avatars_url($name, $size = 50, $background = 'random', $rounded = true)
{
    if ($background == 'none') {
        $url = 'https://ui-avatars.com/api/?name=' . $name . '&size=' . $size . '&rounded=' . $rounded;
    } else {
        $url = 'https://ui-avatars.com/api/?name=' . $name . '&size=' . $size . '&background=' . $background . '&rounded=' . $rounded;
    }

    return $url;
}

function nameNumerDay($date)
{

    $fechats = strtotime($date); //a timestamp
    $array_date = explode('-', $date);
    $string = '';
    //el parametro w en la funcion date indica que queremos el dia de la semana
    //lo devuelve en numero 0 domingo, 1 lunes,....
    switch (date('w', $fechats)) {
        case 0:
            $string = "Domingo " . $array_date[2];
            break;
        case 1:
            $string = "Lunes " . $array_date[2];
            break;
        case 2:
            $string = "Martes " . $array_date[2];
            break;
        case 3:
            $string = "Miercoles " . $array_date[2];
            break;
        case 4:
            $string = "Jueves " . $array_date[2];
            break;
        case 5:
            $string = "Viernes " . $array_date[2];
            break;
        case 6:
            $string = "Sabado " . $array_date[2];
            break;
    }

    return $string;
}

function nameMonth($m)
{
    //$m='08';
    $months = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
    return $months[(int)$m];
}
