import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import iconHelpKeywords from './icons/palabras-claves.svg';

export default class helpkeywords extends Plugin {
    init() {
        const editor = this.editor;
        // The button must be registered among the UI components of the editor
        // to be displayed in the toolbar.
        editor.ui.componentFactory.add('helpkeywords', () => {
            // The button will be an instance of ButtonView.
            const button = new ButtonView();

            button.set( {
                label: 'Corrección de gramática',
                icon: iconHelpKeywords,
                tooltip: true
            } );

            button.on( 'execute', () => {
                openModalHelpKeywords();
            } );

            return button;
        } );
        
    }
}

function openModalHelpKeywords(){
    const form = `
    <div class="ly-ck-dialog ly-ck-dialog-800">
        <div class="ly-ck-dialog-header">
            <div><strong>Corrección de gramática</strong></div>
            <div id="btn-dialog-close-iconHelpKeywords" class="ly-ck-dialog-close-icon">&#10005;</div>
        </div>
        <form id="ly-ck-formGrammarCorrection" class="ly-ck-dialog-form">
            <div class="ly-ck-dialog-group-control">
                <label class="ly-ck-dialog-label" for="help-texto">Texto</label>
                <textarea class="ly-ck-dialog-input" rows="5" id="help-texto" name="help-texto" placeholder="Escriba aquí..."></textarea>
                <spam id="input-text-error"></span>
            </div> 
            <div id="ly-ck-dialog-grammar-correction-result" class="ly-ck-dialog-group-control mb-2" style="overflow-x: hidden;overflow-y: auto;max-height: 150px;" >
                
            </div>
            <div class="ly-ck-dialog-buttons">
                <button class="ly-ck-dialog-button btn-orange mr-2" type="submit"><i class="fas fa-search"></i>Corregir</button>
                <button id="ckcloseBtnHelpKeywords" class="ly-ck-dialog-button btn-orange" type="button"><i class="fas fa-times"></i>Cancelar</button>
            </div>
        </form>
    </div>`;

    var modalHelpKeywords = document.createElement("div");
    modalHelpKeywords.className = "div-form-center";
    modalHelpKeywords.innerHTML = form;
    document.body.appendChild(modalHelpKeywords);

    const ckcloseBtnIconHelpKeywords = document.querySelector( '#btn-dialog-close-iconHelpKeywords' );
    const ckcloseBtnHelpKeywords = document.querySelector( '#ckcloseBtnHelpKeywords' );

    ckcloseBtnIconHelpKeywords.addEventListener( 'click', () => {
        modalHelpKeywords.remove();
    });

    ckcloseBtnHelpKeywords.addEventListener( 'click', () => {
        modalHelpKeywords.remove();
    });

    const formSubmit = document.getElementById('ly-ck-formGrammarCorrection');
    const xhr = new XMLHttpRequest();

    formSubmit.addEventListener('submit', (event) => {
        event.preventDefault();

        const input = document.getElementById('help-texto');
        const error = document.getElementById('input-text-error');

        if (input.value.length === 0) {
            error.textContent = 'Este campo no puede estar vacío';
        } else {
            error.textContent = '';
            const spinner = `<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>`;

            const content = document.getElementById('ly-ck-dialog-grammar-correction-result');
            content.innerHTML = spinner;

            const parameters = editor.config.get('helpkeywords') || 'empty';
            const formData = new FormData(formSubmit);
            
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    content.innerHTML = `<div class="alert alert-primary" role="alert">
                                            ${JSON.parse(xhr.responseText).result}
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