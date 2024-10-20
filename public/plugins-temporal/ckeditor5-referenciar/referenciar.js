import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import iconReferenciar from './icons/referenciar.svg';

export default class referenciar extends Plugin {
    init() {
        const editor = this.editor;
        // The button must be registered among the UI components of the editor
        // to be displayed in the toolbar.
        editor.ui.componentFactory.add('referenciar', () => {
            // The button will be an instance of ButtonView.
            const button = new ButtonView();

            button.set( {
                label: 'Referenciar',
                icon: iconReferenciar,
                tooltip: true
            } );

            button.on( 'execute', () => {
                openModalReference(editor);
            } );

            return button;
        } );

    }
}

function openModalReference(editor){
    const form = `
    <div class="ly-ck-dialog ly-ck-dialog-800">
        <div class="ly-ck-dialog-header">
            <div><strong>Referenciador:</strong></div>
            <div id="ly-ck-btn-dialog-close-icon" class="ly-ck-dialog-close-icon">&#10005;</div>
        </div>
        <form id="ly-ck-form-referenciar" class="ly-ck-dialog-form">
            <div style="max-height: 300px;overflow-x: none;overflow-y: auto;">
                <div id="input-doi-buscar-id" class="ly-ck-dialog-group-control">
                    <label class="ly-ck-dialog-label" for="input-doi">DOI*:</label>
                    <input class="ly-ck-dialog-input" type="text" id="input-doi" name="input-doi" placeholder="Escriba aquí...">
                    <spam id="input-doi-error"></span>
                </div>

                <div class="ly-ck-dialog-group-control mb-2">
                    <label class="ly-ck-dialog-label" for="select-normativa">Normativa:</label>
                    <select onchange="select_citation('changenormative')" class="ly-ck-dialog-select" id="select-normativa" name="select-normativa">
                        <option value="apa">APA</option>
                        <option value="iso690">ISO</option>
                        <option value="vancouver">Vancouver</option>
                    </select>
                </div>
                <div class="collapse width" id="collapseWidthExample1" >

                <div class="ly-ck-dialog-group-control">

                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        <button onclick="select_citation('thesis')" type="button" class="btn btn-primary">Tesis</button>
                        <button onclick="select_citation('article')" type="button" class="btn btn-primary">Artículo</button>
                        <button onclick="select_citation('page')" type="button" class="btn btn-primary">Página Web</button>
                        <button onclick="select_citation('book')" type="button" class="btn btn-primary">Libro Virtual</button>
                        <button onclick="select_citation('book-fisico')" type="button" class="btn btn-primary">Libro Físico</button>
                        <button onclick="select_citation('document-gubernamental')" type="button" class="btn btn-primary">Documento Gub.</button>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Doc. Legal
                            </button>
                            <div class="dropdown-menu">
                                <a onclick="select_citation('document-legal-codigo-general')" class="dropdown-item" href="#">Código general</a>
                                <a onclick="select_citation('document-legal-codigo-explicito')" class="dropdown-item" href="#">Código explícito</a>
                                <a onclick="select_citation('document-legal-expedido-sala-penal')" class="dropdown-item" href="#">Expedido por Salas penales</a>
                                <a onclick="select_citation('document-legal-expedido-sala-corte-suprema')" class="dropdown-item" href="#">Sala Penal perm. de Corte Suprema</a>
                                <a onclick="select_citation('document-legal-reglamento-notarial')" class="dropdown-item" href="#">Reglamento Notarial</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ly-ck-dialog-group-control">
                <h3 class="col-6 mx-auto" id="tipo-referencia"></h3>
                </div>

                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-autor">Autor/es:</label>
                        <textarea onkeyup="manual_citation(event)" class="ly-ck-dialog-input" rows="2" id="input-autor" name="input-autor" placeholder="John Miguel, Gutierrez Sosa; Carmen María, Mendoza Villa"></textarea>
                        <spam id="input-autor-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-institucion">Institución, Entidad o Revista:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-institucion" name="input-institucion" placeholder="Escriba aquí...">
                        <spam id="input-institucion-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-libro">N° de Libro:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-libro" name="input-libro" placeholder="Ejem. Libro segundo">
                        <spam id="input-libro-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-n-titulo">N° de Título:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-n-titulo" name="input-n-titulo" placeholder="Ejem. Título Noveno">
                        <spam id="input-n-titulo-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-capitulo">Capítulo N°:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-capitulo" name="input-capitulo" placeholder="Ejem. XII, I, IV, etc.">
                        <spam id="input-capitulo-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-capitulo-nombre">Nombre del Capítulo:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-capitulo-nombre" name="input-capitulo-nombre" placeholder="Ejem. Peculado">
                        <spam id="input-capitulo-nombre-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-titulo">Título:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-titulo" name="input-titulo" placeholder="Escriba aquí...">
                        <spam id="input-titulo-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-namepage">Nombre de la Página WEB:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-namepage" name="input-namepage" placeholder="Escriba aquí...">
                        <spam id="input-namepage-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-date">Fecha de publicación:</label>
                        <input onchange="manual_citation(event)" class="ly-ck-dialog-input" type="date" id="input-date" name="input-date">
                        <spam id="input-date-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-date-consulta">Fecha de Consulta:</label>
                        <input onchange="manual_citation(event)" class="ly-ck-dialog-input" type="date" id="input-date-consulta" name="input-date-consulta">
                        <spam id="input-date-consulta-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-grado">Grado Académico:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-grado" name="input-grado" placeholder="Escriba aquí...">
                        <spam id="input-grado-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-universidad">Universidad:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-universidad" name="input-universidad" placeholder="Escriba aquí...">
                        <spam id="input-universidad-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-pais">País o Ciudad:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-pais" name="input-pais" placeholder="Escriba aquí...">
                        <spam id="input-pais-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-siglas">Siglas Entidad/Nombre del Emisor:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-siglas" name="input-siglas" placeholder="Siglas de la entidad emisora o el nombre del emisor">
                        <spam id="input-siglas-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-repositorio">Repositorio:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-repositorio" name="input-repositorio" placeholder="Repositorio de la Universidad Nacional de Ingeniería, Repositorio de la Universidad Cayetano...">
                        <spam id="input-repositorio-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-isbn">ISBN:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-isbn" name="input-isbn" placeholder="Escriba aquí...">
                        <spam id="input-isbn-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-volumen">Volumen:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="number" id="input-volumen" name="input-volumen" placeholder="Escriba aquí...">
                        <spam id="input-volumen-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-numero">Número:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="number" id="input-numero" name="input-numero" placeholder="Escriba aquí...">
                        <spam id="input-numero-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-paginas">Páginas:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-paginas" name="input-paginas" placeholder="Ejem. 20-32">
                        <spam id="input-paginas-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-editorr">Editor:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-editorr" name="input-editorr" placeholder="Escriba aquí...">
                        <spam id="input-editorr-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-editorial">Editorial:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-editorial" name="input-editorial" placeholder="Escriba aquí...">
                        <spam id="input-editorial-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-edicion">Número de Edición:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="number" id="input-edicion" name="input-edicion" placeholder="Escriba aquí...">
                        <spam id="input-edicion-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-repositorio">Repositorio:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-repositorio" name="input-repositorio" placeholder="Ejemplos: Repositorio UCV, Repositorio UNMSM u otros...">
                        <spam id="input-repositorio-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-enlace">Enlace URL o URI:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-enlace" name="input-enlace" placeholder="Escriba aquí...">
                        <spam id="input-enlace-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-doi-a">Código DOI:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-doi-a" name="input-doi-a" placeholder="Escriba aquí...">
                        <spam id="input-doi-a-error"></span>
                    </div>
                    <div class="ly-ck-dialog-group-control">
                        <label class="ly-ck-dialog-label" for="input-issn">ISSN:</label>
                        <input onkeyup="manual_citation(event)" class="ly-ck-dialog-input" type="text" id="input-issn" name="input-issn" placeholder="Escriba aquí...">
                        <spam id="input-issn-error"></span>
                    </div>

                </div>
                <div id="ly-ck-dialog-references-result" class="ly-ck-dialog-group-control mb-2">

                </div>
            </div>
            <div class="ly-ck-dialog-buttons">

                <button onclick="modifyCitation()" class="ly-ck-dialog-button btn-info mr-2" type="button">
                <i class="fa fa-i-cursor" aria-hidden="true"></i>Modificar esta Cita
                </button>

                <button onclick="copyCitation()" class="ly-ck-dialog-button btn-info mr-2" type="button">
                <i class="fa fa-files-o" aria-hidden="true"></i>Copiar Cita
                </button>

                <button onclick="hideBuscar()" id="cita-manual-id" class="ly-ck-dialog-button btn-info mr-5" type="button" data-toggle="collapse" data-target="#collapseWidthExample1" aria-expanded="false" aria-controls="collapseWidthExample1">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Cita Manual
                </button>
                <button id="ckgetBtnReference" class="ly-ck-dialog-button mr-2" type="submit"><i class="fas fa-search"></i>Buscar</button>
                <button id="ckcloseBtnReference" class="ly-ck-dialog-button" type="button"><i class="fas fa-times"></i>Cancelar</button>
            </div>
        </form>
    </div>`;

    var modalReference = document.createElement("div");
    modalReference.className = "div-form-center";
    modalReference.innerHTML = form;
    document.body.appendChild(modalReference);

    const ckcloseBtnReferenceIcon = document.querySelector( '#ly-ck-btn-dialog-close-icon' );
    const ckcloseBtnReference = document.querySelector( '#ckcloseBtnReference' );

    ckcloseBtnReference.addEventListener( 'click', () => {
        modalReference.remove();
    });

    ckcloseBtnReferenceIcon.addEventListener( 'click', () => {
        modalReference.remove();
    });

    const formSubmit = document.getElementById('ly-ck-form-referenciar');
    const xhr = new XMLHttpRequest();

    formSubmit.addEventListener('submit', (event) => {
        event.preventDefault();

        const input = document.getElementById('input-doi');
        const error = document.getElementById('input-doi-error');

        if (input.value.length === 0) {
            error.textContent = 'Este campo no puede estar vacío';
            alert('Algunos campos son necesarios')
        } else {
            const spinner = `<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>`;

            const content = document.getElementById('ly-ck-dialog-references-result');
            content.innerHTML = spinner;

            const parameters = editor.config.get('references') || 'empty';
            const formData = new FormData(formSubmit);

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    content.innerHTML = `<div class="alert alert-primary" id="citation-id" role="alert">
                                            ${JSON.parse(xhr.responseText).cita}
                                        </div>`;
                }
            };

            xhr.open('POST', parameters.url, true);

            // Definir token de seguridad antes de establecer los headers
            const token = parameters.headers['X-CSRF-TOKEN'];
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);

            const formDataJson = {};
            for (const [key, value] of formData.entries()) {
                formDataJson[key] = value;
            }

            xhr.send(JSON.stringify(formDataJson));
        }
    });


}


