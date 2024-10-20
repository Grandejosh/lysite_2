import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import iconOjo from './icons/ojo.svg';

export default class completethesis extends Plugin {
    init() {
        const editor = this.editor;
        // The button must be registered among the UI components of the editor
        // to be displayed in the toolbar.
        editor.ui.componentFactory.add('completethesis', () => {
            // The button will be an instance of ButtonView.
            const button = new ButtonView();

            button.set( {
                label: 'Ver Tesis Completa',
                icon: iconOjo,
                tooltip: true
            } );

            button.on( 'execute', () => {
                let urlThesis = document.getElementById('xurl_thesis').value;
                window.open(urlThesis, '_blank');
            } );

            return button;
        } );
        
    }
}