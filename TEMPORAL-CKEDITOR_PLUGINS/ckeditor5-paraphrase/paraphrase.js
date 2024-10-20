import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import parafraseo from './icons/parafraseo.svg';

export default class paraphrase extends Plugin {
    init() {
        const editor = this.editor;
        editor.ui.componentFactory.add('paraphrase', () => {

            const button = new ButtonView();

            button.set( {
                label: 'Parafrasear',
                icon: parafraseo,
                tooltip: true
            } );

            button.on( 'execute', () => {
                let paraphrase = document.getElementById('paraphrase');
                let documentsheet = document.getElementById('documentsheet');
                paraphrase.style.display = 'block';

                documentsheet.classList.remove("col-12");
                documentsheet.classList.add("col-9");
            } );

            return button;
        } );
        
    }
}