import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import iconrecommendation from './icons/buscar-alt.svg';

export default class recommendation extends Plugin {
    init() {
        const editor = this.editor;
        // The button must be registered among the UI components of the editor
        // to be displayed in the toolbar.
        editor.ui.componentFactory.add('recommendation', () => {
            // The button will be an instance of ButtonView.
            const button = new ButtonView();

            button.set( {
                label: 'Recomendador de Articulos',
                icon: iconrecommendation,
                tooltip: true
            } );

            button.on( 'execute', () => {
                openModalRecommendation(editor);
            } );

            return button;
        } );
        
    }
}

function openModalRecommendation(editor){

    const form = `
    <div class="ly-ck-dialog ly-ck-dialog-800">
        <div class="ly-ck-dialog-header">
            <div><strong>Recomendador de Articulos</strong></div>
            <div id="ly-ck-btn-dialog-close-icon-recommendation" class="ly-ck-dialog-close-icon">&#10005;</div>
        </div>
        <form id="ly-ck-form-recommendation" class="ly-ck-dialog-form">
            <div class="ly-ck-dialog-group-control">
                <label class="ly-ck-dialog-label" for="input-doi">Descripción:</label>
                <input class="ly-ck-dialog-input" type="text" id="re-input-text" name="re-input-text" placeholder="Escriba aquí..." autocomplete="off">
                <spam id="input-re-error"></span>
            </div> 

            <div id="ly-ck-dialog-references-result" class="ly-ck-dialog-group-control mb-2" style="overflow-x: hidden;overflow-y: auto;max-height: 150px;">
                
            </div>
            <div class="ly-ck-dialog-buttons">
                <button id="ckgetBtnReference" class="ly-ck-dialog-button btn-orange mr-2" type="submit"><i class="fas fa-search"></i>Buscar</button>
                <button id="ckcloseBtnReference" class="ly-ck-dialog-button btn-orange" type="button"><i class="fas fa-times"></i>Cancelar</button>
            </div>
        </form>
    </div>`;

    var modalReference = document.createElement("div");
    modalReference.className = "div-form-center";
    modalReference.innerHTML = form;
    document.body.appendChild(modalReference);

    const ckcloseBtnReferenceIcon = document.querySelector( '#ly-ck-btn-dialog-close-icon-recommendation' );
    const ckcloseBtnReference = document.querySelector( '#ckcloseBtnReference' );

    ckcloseBtnReference.addEventListener( 'click', () => {
        modalReference.remove();
    });

    ckcloseBtnReferenceIcon.addEventListener( 'click', () => {
        modalReference.remove();
    });

    const formSubmit = document.getElementById('ly-ck-form-recommendation');
    const xhr = new XMLHttpRequest();

    formSubmit.addEventListener('submit', (event) => {
        event.preventDefault();

        const input = document.getElementById('re-input-text');
        const error = document.getElementById('input-re-error');

        if (input.value.length === 0) {
            error.textContent = 'Este campo no puede estar vacío';
        } else {
            error.textContent = '';
            const spinner = `<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>`;

            const content = document.getElementById('ly-ck-dialog-references-result');
            content.innerHTML = spinner;

            const parameters = editor.config.get('recommendation') || 'empty';
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

