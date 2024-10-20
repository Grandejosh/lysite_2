import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import ButtonView from '@ckeditor/ckeditor5-ui/src/button/buttonview';
import iconIndent from './icons/indent.svg';

export default class indexes extends Plugin {
    init() {
        const editor = this.editor;

        editor.ui.componentFactory.add('indexes', locale => {
            const view = new ButtonView( locale );

            view.set( {
                label: 'Índices',
                icon: iconIndent,
                tooltip: true
            } );

            view.on('execute', () => {
				openModalIndexes();
            });

            return view;
        });

    }

}
