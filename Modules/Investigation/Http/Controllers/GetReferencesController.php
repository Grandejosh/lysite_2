<?php

namespace Modules\Investigation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
//use Spatie\Browsershot\Browsershot;
use DateTime;

class GetReferencesController extends Controller
{
    protected $client;
    public $code_consulta;
    public $is_doi;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function index()
    {
        return view('citar');
    }

    public function citar(Request $request)
    {
        //dd($request->all());
        $doi = $request->get('input-doi');
        $is_doi = false;
        if (strpos($doi, "http") !== false) {
            if (strpos($doi, 'doi.org') !== false) {
                $doi = str_replace("https://dx.doi.org/", "", $doi); // ES DOI
                $doi = str_replace("https://doi.org/", "", $doi); // ES DOI
                $doi = str_replace("http://dx.doi.org/", "", $doi); // ES DOI
                $doi = str_replace("http://doi.org/", "", $doi); // ES DOI
                $is_doi = true;
            } else {
                $is_doi = false;
            }
        } else {
            if (strpos($doi, '/') !== false) $is_doi = true;
        }
        $this->code_consulta = $doi;
        $normativa = $request->get('select-normativa');


        $response = $this->client->request('POST', 'https://api.mendeley.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('MENDELEY_CLIENT_ID'),
                'client_secret' => env('MENDELEY_CLIENT_SECRET'),
                'scope' => 'all'
            ]
        ]);

        $body = $response->getBody();

        $accessToken = json_decode($body)->access_token;

        /////////////luego buscamos el documento para optener el id/////////////////

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/vnd.mendeley-document.1+json'
        ];

        if ($is_doi) {
            $search_url = "https://api.mendeley.com/catalog?doi=" . urlencode($doi);


            //             // Make a request to the link
            // $response = Http::get('https://www.mendeley.com/catalogue/1152eea5-ed0e-3f81-88bf-be4f34aecabf/');

            // // Get the body of the response
            // $body = $response->body();

            // // Convert the body to a string
            // $html = (string)$body;
            // $partes = explode('data-name="citation"', $html);
            // $len=count($partes);
            // $partes=$partes[$len-1];
            // //</div>
            // $partes = explode('</div>', $partes);

            // $parte_despues = strstr($partes[0], '>');
            // if ($parte_despues !== false) {
            //     $parte_despues = substr($parte_despues, 1);
            // }
            // dd("<p>".$parte_despues);

        } else {  //Por AQUI SI ES UNA PAGINA WEB

            //$search_url = "https://api.mendeley.com/catalog?link=" . urlencode($doi);
            $api_opengraph = env('OPEN_GRAPH_IO_API');
            $url = 'https://opengraph.io/api/1.1/site/' . urlencode($doi) . '?app_id=' . $api_opengraph;

            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);

            $data = json_decode($response, true);
            switch ($normativa) {
                case 'apa':
                    $cita = $this->generar_cita_de_web($data, "apa");
                    return response()->json(['cita' => $cita]);
                case 'iso690':
                    $cita = $this->generar_cita_de_web($data, "iso690");
                    return response()->json(['cita' => $cita]);
                case 'vancouver':
                    $cita = $this->generar_cita_de_web($data, "vancouver");
                    return response()->json(['cita' => $cita]);
                default:
                    return 'Formato de cita no válido';
            }
        }

        $response = $this->client->request('GET', $search_url, [
            'headers' => $headers
        ]);

        $status_code = $response->getStatusCode();

        if ($status_code == 200) {

            $document = json_decode($response->getBody()->getContents());
            $cita = $this->generar_cita($document, $normativa);

            return response()->json(['cita' => $cita]);
        } else {

            return 'Intenta Nuevamente, Hubo un error en el servidor';
        }
    }

    public function generar_cita($document, $normativa)
    {

        if (count($document) > 0) {
            switch ($normativa) {
                case 'apa':
                    return $this->generate_apa($document[0]);
                case 'iso690':
                    return $this->generate_iso690($document[0]);
                case 'vancouver':
                    return $this->generate_vancouver($document[0]);
                default:
                    return 'Formato de cita no válido';
            }
        } else {
            return "Lo sentimos, No hemos podido encontrar el codigo que has brindado";
        }
    }

    public function generate_apa($document)
    {
        //dd($document);
        // Consultando la WEB de mendeley según el ID
        $response = Http::get('https://www.mendeley.com/catalogue/' . $document->id . '/');

        // Get the body of the response
        $body = $response->body();
        $html = $body;
        //dd($document);

        // $browsershot = new Browsershot();
        // $html = $browsershot->setURL('https://www.mendeley.com/catalogue/'.$document->id.'/')
        //                     ->waitUntilNetworkIdle()
        //                     ->bodyHtml();

        // Convert the body to a string
        $html = (string)$html;
        $partes = explode('data-name="citation"', $html);
        $len = count($partes);
        $partes = $partes[$len - 1];
        //</div>
        $partes = explode('</div>', $partes);

        $parte_despues = strstr($partes[0], '>');
        if ($parte_despues !== false) {
            $parte_despues = substr($parte_despues, 1);
        }
        $citation = "<p>" . $parte_despues;
        $citation = str_replace('Elsevier B.V.', '', $citation);
        //revisando si hay mas cierraParentesis para eliminar el ultimo
        $abreParentesis = substr_count($citation, "(");
        $cierraParentesis = substr_count($citation, ")");
        //dd($abreParentesis,$cierraParentesis, "ABRE Y CIERA");
        if ($cierraParentesis > $abreParentesis) {
            $posicion = strrpos($citation, "). "); // Busca la última ocurrencia de "). " en el string
            $citation = substr_replace($citation, ". ", $posicion, strlen("). ")); // Reemplaza la ocurrencia encontrada por ". "
        }

        $citation = str_replace(' (Vol. ', ', ', $citation);
        $citation = str_replace('. In ', '. ', $citation);
        $citation = str_replace('pp.', '', $citation);
        //Aqui abajo hay un error algunos años se muestran así (2012 y no cierra el parentesis y agrega el punto para eso lo siguiente
        $array = explode('(', $citation);
        $titulox = $array[0];
        $citation = preg_replace('/\((\d{4,5})\./', '($1).', $citation); // reemplazar "(X." con "(X)"echo $cadena;
        $nxplodes = explode('(' . $document->year . ')', $citation);
        $nxplodes[0] = $titulox; //$this->getAutorforAPA($document);
        //$citation = $titulox . implode('(' . $document->year . ')', $nxplodes);
        $citation = implode('(' . $document->year . ')', $nxplodes);

        $source = null;
        try {
            $source = $document->source;
        } catch (\Throwable $th) {
            $source = "";
        }

        $year = $document->year;

        $explotado = explode("https://doi", $citation);
        $explotado = explode('<i>' . $source . '</i>,', $explotado[0]);
        $volumen_and_pages_no_k = "";
        $volumen_and_pages = "";
        if (isset($explotado[1])) {
            $volumen_and_pages = $explotado[1];
            //dd($volumen_and_pages);
            $volumen_and_pages_no_k = $volumen_and_pages;
            $volumen_and_pages = explode(",", $volumen_and_pages);
            $pos = strpos($volumen_and_pages[0], "(");
            if ($pos == false) {
                $parts = explode(",", $volumen_and_pages[0]);
                $parts[0] = "<em>" . $parts[0] . "</em>";
                $volumen_and_pages[0] = implode(",", $parts);
            }
            //$volumen_and_pages[0] = $volumen_and_pages[0];
            $volumen_and_pages  = implode(",", $volumen_and_pages);


            $abreParentesis_ = substr_count($volumen_and_pages, "(");
            $cierraParentesis_ = substr_count($volumen_and_pages, ")");
            if ($cierraParentesis_ > $abreParentesis_) {
                //$volumen_and_pages = "(".$volumen_and_pages;
                $volumen_and_pages = str_replace(")", "", $volumen_and_pages);
            }
            $citation = str_replace($volumen_and_pages_no_k, $volumen_and_pages, $citation);
        }
        $citation = str_replace("Elsevier Ltd.", "", $citation);
        $citation = html_entity_decode($citation);
        $citation = preg_replace("/, &/", " y ", $citation);
        $citation = $this->deleteMonths($citation);

        /*
      INICIO  Cambios Abril 2024 APA ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

if($document->type == "journal" || $document->type == "book" || $document->type == "conference_proceedings"){
    $string = $citation;

    // Utilizamos expresiones regulares para buscar el número entre paréntesis
    $pattern = '/\((\d+)\)/';
    preg_match($pattern, $string, $matches);

    // La posición 0 del array $matches contiene el texto completo que coincide con el patrón
    // La posición 1 contiene el número entre paréntesis
    $newsubstring="";
    if (isset($matches[1])) {
        $numeroEntreParentesis = "(".$matches[1].")";
        $substring = strstr($string, $numeroEntreParentesis, true);
        $contadorComas = substr_count($substring, ",");
        if(count($document->authors)>2){
            $newsubstring = str_replace(" y ", ", & ", $substring);
        }else{
            $newsubstring = str_replace(" y ", " & ", $substring);
        }
    } else {

    }
    $citation = str_replace($substring, $newsubstring, $citation);
}

        //dd($document->authors); falta revisar lo de apellidos
/*
      FIN  Cambios Abril 2024 APA ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

        return $citation;
    }

    public function getAutorforAPA($document)
    {
        $authors = array();

        //Obtener el nombre de los autores
        try {
            foreach ($document->authors as $author) { //solo la inicial del primer nombre
                if ($document->type == "book") {
                    try {
                        array_push($authors, str_replace(" ", "-", $author->last_name) . ", " . substr($author->first_name, 0, 1) . ".");
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                } else {
                    try {
                        array_push($authors, $author->last_name . ", " . substr($author->first_name, 0, 1) . ".");
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        $citation2 = "";
        //Añadir los apellidos de los autores
        if (count($authors) == 1) {
            $citation2 .= $authors[0] . " ";
        } elseif (count($authors) == 2) {
            $citation2 .= $authors[0] . " & " . $authors[1] . " ";
        } elseif (count($authors) == 3) {
            $citation2 .= $authors[0] . ", " . $authors[1] . " & " . $authors[2] . " ";
        } elseif (count($authors) == 4) {
            $citation2 .= $authors[0] . ", " . $authors[1] . ", " . $authors[2] . " & " . $authors[3] . " ";
        } elseif (count($authors) == 5) {
            $citation2 .= $authors[0] . ", " . $authors[1] . ", " . $authors[2] . ", " . $authors[3] . " & " . $authors[4] . " ";
        } elseif (count($authors) == 5) {
            $citation2 .= $authors[0] . ", " . $authors[1] . ", " . $authors[2] . ", " . $authors[3] . ", " . $authors[4] . " & " . $authors[5] . " ";
        } elseif (count($authors) > 5) {
            $citation2 .= $authors[0] . ", " . $authors[1] . ", " . $authors[2] . ", " . $authors[3] . ", " . $authors[4] . ", " . $authors[5] . " & " . $authors[6] . " ";
        }

        // //Añadir el año de publicación y el título del artículo
        // $citation .= "(" . substr($document->year, 0, 4) . "). " . $document->title . ". ";

        // //Añadir el nombre de la revista
        // if (isset($document->source)) {
        //     $citation .= "<i>" . $document->source . "</i>";
        // }

        // //Añadir el volumen y el número (si están disponibles)
        // if (isset($document->volume)) {
        //     $citation .= ", " . $document->volume;
        // }
        // if (isset($document->issue)) {
        //     $citation .= "(" . $document->issue . ")";
        // }

        // //Añadir las páginas
        // if (isset($document->pages)) {
        //     $citation .= ", " . $document->pages;
        // }

        // //Añadir el DOI
        // if (isset($document->identifiers->doi)) {
        //     $citation .= ' <a href="https://doi.org/' . $document->identifiers->doi . '">' . "https://doi.org/" . $document->identifiers->doi . '</a>';
        // }

        // $citation .= "</p>";
        return $citation2;
    }

    public function generate_iso690($document)
    {
        //en test no sale aún obtener solo el mes de los articulos
        //$this->getMonthforISO($document->link);

        $authors = array();

        //Obtener el nombre de los autores
        foreach ($document->authors as $author) {
            try {
                $last_name = explode(" ", $author->last_name);
                $last_name = mb_strtoupper($last_name[0], 'UTF-8');
                $nombre = explode(" ", $author->first_name)[0]; // obtener el primer elemento del array, que será el primer nombre
                $nombre = ucfirst(strtolower($nombre)); // convertir la primera letra en mayúscula y el resto en minúsculas
                $name = $last_name . ', ' . $nombre;
                array_push($authors, $name);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $citation = '<p>';

        //Añadir los nombres de los autores
        if (count($authors) == 1) {
            $citation .= $authors[0] . '. ';
        } elseif (count($authors) == 2) {
            $citation .= $authors[0] . ' y ' . $authors[1] . '. ';
        } else {
            for ($i = 0; $i < count($authors) - 1; $i++) {
                if ($i == count($authors) - 2) {
                    $citation .= $authors[$i] . ' ';
                } else {
                    $citation .= $authors[$i] . '; ';
                }
            }
            $citation .= 'y ' . $authors[count($authors) - 1] . '. ';
        }

        //Añadir el título del artículo
        $citation .= $document->title . '. ';

        //Añadir el nombre de la revista
        if (isset($document->source)) {
            $citation .= '<em>' . $document->source . '</em> ' . ' [en línea] ';
        }

        $volumen_and_pages = $this->getVolumen_and_pages_iso($document);
        //Añadir el año de publicación
        $citation .= $document->year . ', ' . $volumen_and_pages;
        //-dd($volumen_and_pages);
        //Añadir las páginas
        if (isset($document->pages)) {
            $citation .= 's. ' . $document->pages . '. ';
        }

        //Fecha de consulta
        $month = date('n');
        switch ($month) {
            case '1':
                $month = "enero";
                break;
            case '2':
                $month = "febrero";
                break;
            case '3':
                $month = "marzo";
                break;
            case '4':
                $month = "abril";
                break;
            case '5':
                $month = "mayo";
                break;
            case '6':
                $month = "junio";
                break;
            case '7':
                $month = "julio";
                break;
            case '8':
                $month = "agosto";
                break;
            case '9':
                $month = "septiembre";
                break;
            case '10':
                $month = "octubre";
                break;
            case '11':
                $month = "noviembre";
                break;
            case '12':
                $month = "diciembre";
                break;
        }
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $fecha_actual = Carbon::now()->formatLocalized('%e de ' . $month . ' de %Y');
        $string_fecha = " [Fecha de consulta: " . $fecha_actual . "] ";
        $citation .= $string_fecha;


        //Añadir el DOI
        //dd($document->identifiers->doi);
        if (isset($document->identifiers->doi)) {
            $citation .= 'Disponible en: <a href="https://doi.org/' . $document->identifiers->doi . '">' . "https://doi.org/" . $document->identifiers->doi . '</a>.';
        }

        if (isset($document->identifiers->issn)) {
            $citation .= ' ISSN: ' . $document->identifiers->issn;
        }

        $citation .= '</p>';
        $citation = str_replace("Elsevier Ltd.", "", $citation);
        $citation = $this->deleteMonths($citation);

                ///-ABRIL CAMBIOS 2024------------------------------------------------------------------------------------------------------------------------

                if(count($document->authors)==2){
                    $string = $citation;
                    $posicion_y = strpos($string, ' y');

                    if ($posicion_y !== false) {
                        $citation = substr_replace($string, ' &', $posicion_y, 2);
                    } else {
                        $citation = $string;
                    }
                }

                if(count($document->authors)>=3){
                    $string = $citation;
                    $posicion_y = strpos($string, ' y');

                    if ($posicion_y !== false) {
                        $citation = substr_replace($string, '; &', $posicion_y, 2);
                    } else {
                        $citation = $string;
                    }
                }
                //////////////////////////////////////////////-------------------------------------------------------------------------------------------


        return $citation;
    }


    public function generate_vancouver($document)
    {
        $authors = array();

        //Obtener el nombre de los autores
        //dd($document);
        foreach ($document->authors as $author) {
            try {
                $first_lastname = explode(" ", $author->last_name); //en vancouver solo el primer apellido
                array_push($authors, $first_lastname[0] . " " . substr($author->first_name, 0, 1) . "."); // inicial de nombre
            } catch (\Throwable $th) {
                //dd($th);
            }
        }

        $citation = '<p>';

        //Añadir los apellidos y las iniciales de los nombres de los autores
        foreach ($authors as $key => $author) {
            $author = str_replace(" ", ", ", $author);
            $name_parts = explode(" ", $author);
            $initials = "";

            foreach ($name_parts as $part) {
                $initials .= substr($part, 0, 1) . ".";
            }

            if ($key === count($authors) - 1) {
                $citation .= $author . " ";
            } else {
                $citation .= $author . ", ";
            }
        }

        //Añadir el título del artículo
        if ($document->type == "book") {
            $citation .= $document->title . " [Internet]. ";
        } else {
            $citation .= $document->title . ". ";
        }

        //Añadir el nombre de la revista
        if (isset($document->source) && $document->title != $document->source) {
            $citation .= "" . $document->source . ". ";
        }

        //Añadir el año de publicación
        $citation .= $document->year . ";";

        //Añadir el volumen
        if (isset($document->volume)) {
            $citation .= $document->volume . ":";
        }

        //Añadir las páginas
        if (isset($document->pages)) {
            $citation .= $document->pages . ".";
        }

        if (isset($document->identifiers->doi)) {
            $citation .= ' https://dx.doi.org/' . $this->code_consulta . '.</p>';
        } else {
            $citation .= '</p>';
        }

        // $apa_citation = $this->generate_apa($document); //se usa porque este tiene información de paginas y volumen
        // $explotado = explode("https://doi", $apa_citation);
        // $explotado = explode('<i>'.$source.'</i>,', $explotado[0]);
        // $volumen_and_pages="";
        // if( count($explotado) > 1 ){
        //     $volumen_and_pages = $explotado[1];
        // }
        $volumen_and_pages = $this->getVolumen_and_pages($document);
        $volumen_and_pages = str_replace(",", ":", $volumen_and_pages);
        $citation = str_replace('https://dx.doi.org/', $volumen_and_pages . 'https://dx.doi.org/', $citation);
        $citation = str_replace('https://dx.doi.org/' . $this->code_consulta, '<a href="' . 'https://dx.doi.org/' . $this->code_consulta . '" target="_blank">' . 'https://dx.doi.org/' . $this->code_consulta . '</a>', $citation);
        //borrando tag <i> en vancouver no debe ir
        $citation = str_replace("<i>", "", $citation);
        $citation = str_replace('</i>', "", $citation);
        $citation = str_replace("<em>", "", $citation);
        $citation = str_replace('</em>', "", $citation);
        $citation = str_replace("Elsevier Ltd.", "", $citation);
        $citation = $this->deleteMonths($citation);
        return $citation;
    }


    public function getVolumen_and_pages($document)
    {

        $year = $document->year;
        try {
            $source = $document->source;
        } catch (\Throwable $th) {
            $source = "";
        }
        $apa_citation = $this->generate_apa($document); //se usa porque este tiene información de paginas y volumen
        $explotado = explode("https://doi", $apa_citation);
        $explotado = explode('<i>' . $source . '</i>,', $explotado[0]);
        $volumen_and_pages = "";
        if (isset($explotado[1])) {
            $volumen_and_pages = $explotado[1];
        }
        //quitar la coma si hay volumen pero no numero y cambiar por dos puntos
        $subcadenas = explode("</em>", $volumen_and_pages);
        $subca = explode('<em>', $subcadenas[0]);
        try {
            if (is_numeric(trim($subca[1]))) {
                $volumen_and_pages = str_replace($subca[1] . "</em>,", $subca[1] . "</em>:", $volumen_and_pages);
            } else {
                $volumen_and_pages = str_replace(",", ":", $volumen_and_pages);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }



        return $volumen_and_pages;
    }

    public function getVolumen_and_pages_iso($document)  //si el : va en todos cambia el metodo anterior y borra este
    {

        $year = $document->year;
        try {
            $source = $document->source;
        } catch (\Throwable $th) {
            $source = "";
        }
        $apa_citation = $this->generate_apa($document); //se usa porque este tiene información de paginas y volumen
        $explotado = explode("https://doi", $apa_citation);
        $explotado = explode('<i>' . $source . '</i>,', $explotado[0]);
        $volumen_and_pages = "";
        if (isset($explotado[1])) {
            $volumen_and_pages = $explotado[1];
        }
        //quitar la coma si hay volumen pero no numero y cambiar por dos puntos
        $subcadenas = explode("</em>", $volumen_and_pages);
        $subca = explode('<em>', $subcadenas[0]);
        try {
                $volumen_and_pages = str_replace(", ", ": ", $volumen_and_pages);
            if (is_numeric(trim($subca[1]))) {
                $volumen_and_pages = str_replace($subca[1] . "</em>,", $subca[1] . "</em>:", $volumen_and_pages);
            } else {
                $asd = $volumen_and_pages;
                $volumen_and_pages = str_replace(", ", ": ", $asd);
            }
        } catch (\Throwable $th) {
            //dd($th);
        }



        return $volumen_and_pages;
    }

    public function getMonthforISO($link)
    {

        // $browsershot = new Browsershot();
        // $html = $browsershot->setURL($link)
        //                     ->waitUntilNetworkIdle()
        //                     ->bodyHtml();
        // // $html ahora contiene el código HTML completo de la página web
        // dd((string)$html);

    }


    public function generar_cita_de_web($data, $normativa)
    {

        try {
            $site_name = "";
            $site_name = $data['hybridGraph']['site_name'];
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $site_title = "";
            $site_title = $data['hybridGraph']['title'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $url = "";
            $url = $data['hybridGraph']['url'];
        } catch (\Throwable $th) {
            //throw $th;
        }

        //revisa si tiene fecha de publicación
        $fecha_publicacion = "";
        if (isset($data['hybridGraph']['articlePublishedTime'])) {
            $articlePublishedTime = $data['hybridGraph']['articlePublishedTime'];
            $fecha_obj = new DateTime($articlePublishedTime);
            // Dar formato a la fecha de salida
            $fecha_publicacion = $fecha_obj->format('j \d\e F \d\e\l Y');
            $meses = array(
                'January' => 'enero',
                'February' => 'febrero',
                'March' => 'marzo',
                'April' => 'abril',
                'May' => 'mayo',
                'June' => 'junio',
                'July' => 'julio',
                'August' => 'agosto',
                'September' => 'septiembre',
                'October' => 'octubre',
                'November' => 'noviembre',
                'December' => 'diciembre'
            );

            // Reemplazar cada nombre de mes en inglés con su equivalente en español en la cadena de fecha
            $fecha_publicacion = str_replace(array_keys($meses), array_values($meses), $fecha_publicacion);
            $fecha_publicacion = "(" . $fecha_publicacion . ").";
        }

        if ($normativa == "apa") {
            $citation = $site_name . " " . $fecha_publicacion . " " . $site_title . " " . $site_name . ". " . $url;
            $citation = str_replace("Elsevier Ltd.", "", $citation);
            return $citation;
        } elseif ($normativa == "iso690") {
            $citation = $site_name . " " . $site_title . " Disponible en: " . $url;
            $citation = str_replace("Elsevier Ltd.", "", $citation);
            return $citation;
            /*
                CARO, Dino. Vacunagate y Public Compliance: el caso peruano. Agenda Estado de Derecho, 2021.
                Disponible en: https://agendaestadodederecho.com/vacunagate-y-public-compliance-el-caso-peruano/
                Apellido mayúscula, Nombre minúscula. Título de la página web, año. Disponible en: link de la pagina
*/
        } elseif ($normativa == "vancouver") {
            $citation = $site_name . " " . $site_title . " [Internet]. " . " Disponible en: " . $url;
            $citation = str_replace("Elsevier Ltd.", "", $citation);
            return $citation;

            /*
                Caro, D. Vacunagate y Public Compliance: el caso peruano [Internet]. Perú: Agenda Estado de Derecho; 2021.
                Disponible en: https://agendaestadodederecho.com/vacunagate-y-public-compliance-el-caso-peruano/
                Apellido, Inicial Nombre. Título [Internet]. Lugar de publicación: Editor; Fecha de publicación. Disponible en: Enlace.
                */
        }
    }

    public function deleteMonths($citation)
    {
        $citation = str_replace("(jan)", "", $citation);
        $citation = str_replace("(JAN)", "", $citation);
        $citation = str_replace("(Jan)", "", $citation);
        $citation = str_replace("(January)", "", $citation);
        $citation = str_replace("(JANUARY)", "", $citation);
        $citation = str_replace("(feb)", "", $citation);
        $citation = str_replace("(mar)", "", $citation);
        $citation = str_replace("(apr)", "", $citation);
        $citation = str_replace("(may)", "", $citation);
        $citation = str_replace("(jun)", "", $citation);
        $citation = str_replace("(jul)", "", $citation);
        $citation = str_replace("(aug)", "", $citation);
        $citation = str_replace("(sep)", "", $citation);
        $citation = str_replace("(oct)", "", $citation);
        $citation = str_replace("(nov)", "", $citation);
        $citation = str_replace("(dec)", "", $citation);

        $citation = str_replace("(FEB)", "", $citation);
        $citation = str_replace("(MAR)", "", $citation);
        $citation = str_replace("(APR)", "", $citation);
        $citation = str_replace("(MAY)", "", $citation);
        $citation = str_replace("(JUN)", "", $citation);
        $citation = str_replace("(JUL)", "", $citation);
        $citation = str_replace("(AUG)", "", $citation);
        $citation = str_replace("(SEP)", "", $citation);
        $citation = str_replace("(OCT)", "", $citation);
        $citation = str_replace("(NOV)", "", $citation);
        $citation = str_replace("(DEC)", "", $citation);

        $citation = str_replace("(Feb)", "", $citation);
        $citation = str_replace("(Mar)", "", $citation);
        $citation = str_replace("(Apr)", "", $citation);
        $citation = str_replace("(May)", "", $citation);
        $citation = str_replace("(Jun)", "", $citation);
        $citation = str_replace("(Jul)", "", $citation);
        $citation = str_replace("(Aug)", "", $citation);
        $citation = str_replace("(Sep)", "", $citation);
        $citation = str_replace("(Oct)", "", $citation);
        $citation = str_replace("(Nov)", "", $citation);
        $citation = str_replace("(Dec)", "", $citation);

        $citation = str_replace("(February)", "", $citation);
        $citation = str_replace("(March)", "", $citation);
        $citation = str_replace("(April)", "", $citation);
        $citation = str_replace("(May)", "", $citation);
        $citation = str_replace("(June)", "", $citation);
        $citation = str_replace("(July)", "", $citation);
        $citation = str_replace("(August)", "", $citation);
        $citation = str_replace("(September)", "", $citation);
        $citation = str_replace("(October)", "", $citation);
        $citation = str_replace("(November)", "", $citation);
        $citation = str_replace("(December)", "", $citation);

        $citation = str_replace("(FEBRUARY)", "", $citation);
        $citation = str_replace("(MARCH)", "", $citation);
        $citation = str_replace("(APRIL)", "", $citation);
        $citation = str_replace("(MAY)", "", $citation);
        $citation = str_replace("(JUNE)", "", $citation);
        $citation = str_replace("(JULY)", "", $citation);
        $citation = str_replace("(AUGUST)", "", $citation);
        $citation = str_replace("(SEPTEMBER)", "", $citation);
        $citation = str_replace("(OCTOBER)", "", $citation);
        $citation = str_replace("(NOVEMBER)", "", $citation);
        $citation = str_replace("(DECEMBER)", "", $citation);
        return $citation;
    }
}
