import { Plugin } from "ckeditor5/src/core";
import { ButtonView } from "ckeditor5/src/ui";
import addComment from "./theme/icons/add-comment.svg";
import removeComment from "./theme/icons/remove-comment.svg";
import "./theme/annotation.css";

const confComment = {
    element: "lyComment",
};
export default class comments extends Plugin {
    init() {
        const editor = this.editor;
        // The button must be registered among the UI components of the editor
        // to be displayed in the toolbar.
        const ajaxData = editor.config.get("comments.ajax") || [];

        editor.ui.componentFactory.add("comments", () => {
            // The button will be an instance of ButtonView.
            const button = new ButtonView();

            button.set({
                label: "Comentarios",
                icon: addComment,
                //withText: true,
                tooltip: true,
                //isEnabled: false // Deshabilitamos el botón por defecto
            });

            button.on("execute", () => {
                if (Object.keys(ajaxData).length > 0) {
                    const partId = ajaxData.data.thesi_student_part_id;
                    if (partId != 0) {
                        this._createDialog();
                    } else {
                        alert("No puede comentar, aun no hay contenido");
                    }
                } else {
                    alert("No puede acceder a esta función, solo para tutores");
                }
            });

            return button;
        });

        // editor.model.schema.register(confComment.element, {
        //     isObject: true,
        //     allowWhere: '$block',
        //     allowContentOf: '$root',
        // });

        // editor.model.schema.extend( '$text', { allowAttributes: confComment.element } );

        // editor.conversion.for('downcast').elementToElement({
        //     model: {
        //         name: confComment.element,
        //         attributes: [ 'id' ]
        //     },
        //     view: ( modelElement, { writer } ) => {
        //         return writer.createContainerElement(
        //             'label',
        //                 {
        //                     id: modelElement.getAttribute('id'),
        //                     class: 'ly-suggestion-marker-deletion'
        //                 }
        //         );
        //     }
        // });

        // editor.conversion.for('upcast').elementToElement({
        //     view: {
        //         name: 'label',
        //         classes: 'ly-suggestion-marker-deletion',
        //         attributes: {
        //             id: true
        //         }
        //     },
        //     model: (viewElement, { writer: modelWriter }) => {
        //         return modelWriter.createElement(confComment.element, {
        //             id: viewElement.getAttribute('id')
        //         });
        //     }
        // });

        const urlData = editor.config.get("comments.urlData") || null;
        if (urlData) {
            __getDataComments(urlData);
        }
    }

    _createDialog() {
        const editor = this.editor;
        var ckFormComment = document.createElement("div");
        ckFormComment.id = "div_comments";
        ckFormComment.className = "div-form-comments";
        var user_name = localStorage.getItem("user_name");
        var divComment = `<div class="card">
                            <div class="card-body">
                                <div>
                                    <textarea id="form-comment-textarea" class="form-control form-control-sm" rows="2"></textarea>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-secondary btn-lg dialogClose"><i class="fas fa-times"></i></button>
                                        <button id="commentButtonSave" type="button" class="btn btn-success btn-lg"><i class="fas fa-check"></i></button>
                                    </div>
                                </div>
                              </div>
                        </div>`;

        ckFormComment.innerHTML = divComment;
        document.body.appendChild(ckFormComment);

        var buttons = document.getElementsByClassName("dialogClose");

        // Recorremos todos los botones y les agregamos el evento onclick
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = function () {
                ckFormComment.remove();
            };
        }

        var buttonSave = document.getElementById("commentButtonSave");

        buttonSave.onclick = function () {
            const selection = editor.model.document.selection;
            let selectedText = "";
            if (selection.isCollapsed) {
                alert("No hay contenido seleccionado.");
            } else {
                const textarea = document.getElementById(
                    "form-comment-textarea"
                ); // Obtener el elemento textarea por su ID
                const contenido = textarea.value.trim(); // Obtener el valor del textarea y eliminar espacios en blanco al inicio y final

                if (contenido.length > 0) {
                    const selectedContent =
                        editor.model.getSelectedContent(selection);

                    const selectedArray = selectedContent._children._nodes;

                    for (let i = 0; i < selectedArray.length; i++) {
                        selectedText += selectedArray[i]._data;
                    }
                    const randomNum = Math.random().toString();

                    // editor.conversion.for('downcast').elementToElement({
                    //     model: confComment.element,
                    //     view: {
                    //         name: 'label',
                    //         classes: 'ly-suggestion-marker-deletion',
                    //         attributes: {
                    //             id: `lyc-${randomNum}`
                    //         }
                    //     }
                    // });

                    // editor.model.change( writer => {
                    //     const commentElement =  writer.createElement(confComment.element, {id: `lyc-${randomNum}`})
                    //     writer.insertText(selectedText, commentElement)
                    //     editor.model.insertContent(commentElement);
                    // } );

                    const parameters =
                        editor.config.get("comments.ajax") || "empty";
                    const urlData2 =
                        editor.config.get("comments.urlData") || null;

                    if (parameters != "empty") {
                        __runAjax(
                            parameters,
                            randomNum,
                            textarea.value,
                            selectedText,
                            urlData2
                        );
                    }
                } else {
                    alert("El textarea está vacío");
                }

                selectedText = "";
                ckFormComment.remove();
            }
        };
    }
}

function __runAjax(
    parameters,
    selecction_id,
    comment_text,
    selectedText,
    urlData2
) {
    // Crear objeto XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Si method es POST
    if (parameters.method === "POST") {
        xhr.open("POST", parameters.url);
        parameters.data.commentary = comment_text;
        parameters.data.selecction_id = selecction_id;
        parameters.data.selecction_text = selectedText;
        // Setear header y enviar datos
        var token = parameters.headers["X-CSRF-TOKEN"];
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", token);
        xhr.send(JSON.stringify(parameters.data));
    }

    // Si method es GET
    else if (parameters.method === "GET") {
        xhr.open("GET", parameters.url);
        xhr.send();
    }

    // Si method no es ni POST ni GET
    else {
        console.error('Envíe "POST" o "GET" para ejecutar la petición.');
        return;
    }

    // Manejar respuesta
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Manejar respuesta exitosa
            console.log("Petición exitosa:", xhr.response);
            console.log(urlData2);
            if (urlData2) {
                console.log("acaesta");
                __getDataComments(urlData2);
            }
        } else {
            // Manejar error
            console.error("Error en la petición:", xhr.status, xhr.statusText);
        }
    };
}
function _createSidebarComments(text, id) {
    var cksidebarComments = document.createElement("div");
    cksidebarComments.id = "lyc-" + id + "-item";
    cksidebarComments.className = "ly-sidebar-comment";

    const svg = document.createElement("div");
    svg.innerHTML = removeComment;

    var sidebar = `<div class="ly-sidebar-item">
                        <div class="ly-annotation-wrapper" tabindex="-1">
                            <span class="ly-remove-comment" id="ly-btn-remove-${id}">
                                ${svg.innerHTML}
                            </span>
                            <div class="" tabindex="-1">
                                <div class="ck-thread__container">
                                    ${text}
                                </div>
                            </div>
                        </div>
                    </div>`;

    cksidebarComments.innerHTML = sidebar;

    document.body.appendChild(cksidebarComments);

    const button = document.getElementById("ly-btn-remove-" + id);
    const comment = document.getElementById("lyc-" + id + "-item");
    button.onclick = function () {
        comment.remove();
    };
}

function __getDataComments(url) {
    const xhr = new XMLHttpRequest();

    xhr.open("GET", url, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (Object.keys(response).length > 0) {
                var cksidebarListComments = document.createElement("div");
                cksidebarListComments.id = "lyc-ck-sidebar-list-comments";
                var htmlUl = `<div class="card">`;
                htmlUl += `<div class="card-body list-comments-scroll">`;
                response.forEach(function (obj) {
                    var getElapsedTime = obtenerTiempoTranscurrido(
                        obj.created_at
                    );
                    // Realiza las operaciones necesarias con cada elemento del array
                    htmlUl += `<div class="alert alert-warning alert-dismissible fade show" role="alert" id="ly-list-item-${obj.selecction_id}">
                                    <small>${getElapsedTime}</small> 
                                    <button onclick="__getDestroyComments(${obj.id},${obj.selecction_id},${obj.thesis_student_id})" type="button" class="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <hr>
                                    <a class="ck-link-selections" onclick="focusComment(${obj.thesis_student_id},${obj.thesis_format_part_id}, ${obj.selecction_id}, '${obj.selecction_text}')" style="text-decoration: none; color: black;">${obj.commentary}</a>
                                </div>`;
                });
                htmlUl += `</div>`;
                htmlUl += `</div>`;
                cksidebarListComments.innerHTML = htmlUl;

                document.body.appendChild(cksidebarListComments);
            }
        } else {
            console.log("Error: " + xhr.status);
        }
    };

    xhr.onerror = function () {
        console.log("Error de red.");
    };

    xhr.send();
}

function obtenerTiempoTranscurrido(fecha) {
    const fechaActual = new Date();
    const fechaComparar = new Date(fecha);
    const diferenciaTiempo = fechaActual - fechaComparar;
    const diferenciaDias = Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));

    if (diferenciaDias > 7) {
        const options = {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        };
        const formatoFecha = fechaComparar.toLocaleString("es-ES", options);
        return formatoFecha;
    } else {
        return `Hace ${diferenciaDias} días`;
    }
}
