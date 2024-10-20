<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

$request = new Request;

dd($request);

$user = Auth::user();

if (!isset($user)) {
    echo ("No puedes subir archivos");
    die(0);
}

$basePath = "thesis/";

$baseUrl = "thesis/";

// Done. Now test it!
// No need to modify anything below this line
//----------------------------------------------------
// ------------------------
// Input parameters: optional means that you can ignore it, and required means that you
// must use it to provide the data back to CKEditor.
// ------------------------
// Optional: instance name (might be used to adjust the server folders for example)
$CKEditor = isset($_GET['CKEditor']) ? $_GET['CKEditor'] : '';

// Required: Function number as indicated by CKEditor.
$funcNum = isset($_GET['CKEditorFuncNum']) ? $_GET['CKEditorFuncNum'] : 1;

// Optional: To provide localized messages
$langCode = isset($_GET['langCode']) ? $_GET['langCode'] : '';

// ------------------------
// Data processing
// ------------------------
// The returned url of the uploaded file
$url = '';

// Optional message to show to the user (file renamed, invalid file, not authenticated...)
$message = '';

$d = date('ymdHis');
$nom = $d . '.png';
if (isset($_FILES['upload'])) {
    // Be careful about all the data that it's sent!!!
    // Check that the user is authenticated, that the file isn't too big,
    // that it matches the kind of allowed resources...
    $name = $_FILES['upload']['name'];

    // It doesn't care if the file already exists, it's simply overwritten.
    move_uploaded_file($_FILES["upload"]["tmp_name"], $basePath . $nom);

    // Build the url that should be used for this file   
    $url = $baseUrl . $nom;

    // Usually you don't need any message when everything is OK.
    //    $message = 'new file uploaded';   
} else {
    $message = 'No se ha enviado ning&uacute;n archivo';
}
// ------------------------
// Write output
// ------------------------
// We are in an iframe, so we must talk to the object in window.parent
echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>";
