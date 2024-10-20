let globalComments;
function setGlobolComments(data) {
    globalComments = data;
}

function buscarYCambiar() {


    // Crear un objeto Range que cubra todo el contenido del cuerpo de la página
    var range = document.createRange();
    range.selectNodeContents(document.body);

    // Crear un objeto Selection y establecer su rango en el objeto Range creado anteriormente
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    // Establecer el punto inicial de la selección en el primer nodo de texto del cuerpo de la página
    var startNode = document.body.firstChild;
    var startOffset = 0;
    while (startNode.nodeType !== Node.TEXT_NODE) {
        startNode = startNode.nextSibling;
    }
    range.setStart(startNode, startOffset);

    // Establecer el punto final de la selección en el mismo punto que el punto inicial
    range.collapse(true);

    // Establecer el foco en la selección
    document.body.focus();


    var textoBuscado = "Arduino y el Internet de las cosas";

    var encontrado = window.find(textoBuscado);

    if (encontrado) {
        // El texto se encontró en la página
        console.log("El texto se encontró en la página.");

        // Seleccionar el texto encontrado
        var range = window.getSelection().getRangeAt(0);
        var startNode = range.startContainer;
        var startOffset = range.startOffset;
        var posicion = range.toString().indexOf(textoBuscado);
        if (posicion !== -1) {
            while (startNode.nodeType !== Node.TEXT_NODE) {
                startNode = startNode.childNodes[startOffset];
                startOffset = 0;
            }
            range.setStart(startNode, startOffset + posicion);
            range.setEnd(startNode, startOffset + posicion + textoBuscado.length);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);


            // Obtener el elemento con id "editor"
            var editor = document.getElementById("editor");

            // Desplazar el contenido del elemento con id "editor" hacia abajo en 100 píxeles
            editor.scrollTop += 100;
        } else {
            console.log("No se pudo encontrar la posición del texto.");
        }
    } else {
        // El texto no se encontró en la página
        console.log("El texto no se encontró en la página.");
    }

}

// Ejecutamos la función cada 5 segundos
//setInterval(buscarYCambiar, 1000);


function focusComment(thesis_student_id, thesis_format_part_id, selecction_id, selecction_text) {
    const urlActual = window.location.href;

    if (urlActual.includes("investigation/thesis/check")) { // con esto averiguo si estamos en la vista del instructor
        let ext_id = urlActual.split("/");
        let enlace = '/investigation/thesis/check/' + ext_id[6] + '/' + thesis_format_part_id;
        enlace = new URL(decodeURIComponent(window.location.href)).origin + enlace;
        if (urlActual.includes(enlace)) {
            search_text(selecction_text);
        } else {
            // redirigir a la URL especificada
            window.location.href = enlace;
        }
    } else {
        let enlace = '/investigation/thesis/parts/' + thesis_student_id + '/' + thesis_format_part_id;
        enlace = new URL(decodeURIComponent(window.location.href)).origin + enlace;
        if (urlActual.includes(enlace)) {
            search_text(selecction_text);
        } else {
            // redirigir a la URL especificada
            window.location.href = enlace;
        }
    }

}

function search_text(selecction_text) {
    // Crear un objeto Range que cubra todo el contenido del cuerpo de la página
    var range = document.createRange();
    range.selectNodeContents(document.body);

    // Crear un objeto Selection y establecer su rango en el objeto Range creado anteriormente
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    // Establecer el punto inicial de la selección en el primer nodo de texto del cuerpo de la página
    var startNode = document.body.firstChild;
    var startOffset = 0;
    while (startNode.nodeType !== Node.TEXT_NODE) {
        startNode = startNode.nextSibling;
    }
    range.setStart(startNode, startOffset);

    // Establecer el punto final de la selección en el mismo punto que el punto inicial
    range.collapse(true);

    // Establecer el foco en la selección
    document.body.focus();


    var textoBuscado = selecction_text;

    var encontrado = window.find(textoBuscado);

    if (encontrado) {

        //moviendo los scrools hasta abajo porque parece q asi si funciona 
        // Obtener todos los elementos con capacidad de scroll
        var scrollableElements = document.querySelectorAll('*[data-scrollable]');

        // Recorrer los elementos y desplazarlos hasta abajo
        scrollableElements.forEach(function (element) {
            element.scrollTop = element.scrollHeight;
        });

        // Desplazar la página completa hasta abajo
        document.documentElement.scrollTop = document.documentElement.scrollHeight;

        var searchText = textoBuscado; // El texto que deseas buscar y enfocar

        var textNodes = document.evaluate("//text()", document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null); // Obtener todos los nodos de texto en la página

        for (var i = 0; i < textNodes.snapshotLength; i++) {
            var node = textNodes.snapshotItem(i);
            var nodeText = node.textContent;

            var startIndex = nodeText.indexOf(searchText);
            if (startIndex !== -1) {
                var endIndex = startIndex + searchText.length;

                var range = document.createRange(); // Crear un nuevo rango
                range.setStart(node, startIndex); // Establecer el punto de inicio del rango
                range.setEnd(node, endIndex); // Establecer el punto final del rango

                var selection = window.getSelection(); // Obtener la selección actual
                selection.removeAllRanges(); // Eliminar cualquier rango anterior
                selection.addRange(range); // Agregar el nuevo rango

                // Desplazar el contenido hacia la selección
                range.startContainer.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

                break; // Detener la búsqueda después de encontrar la primera coincidencia
            }
        }

    } else {
        // El texto no se encontró en la página
        console.log("El texto no se encontró en la página.");
    }
}