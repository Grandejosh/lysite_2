import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import ButtonView from '@ckeditor/ckeditor5-ui/src/button/buttonview';
import iconMargins from './icons/borde-exterior.svg';

export default class margins extends Plugin {
    init() {
        const editor = this.editor;
		// Función para arrastrar el modal
		var isDragging = false;
		var currentX;
		var currentY;
		var initialX;
		var initialY;
		var xOffset = 0;
		var yOffset = 0;

        editor.ui.componentFactory.add('margins', locale => {
            const view = new ButtonView( locale );

            view.set( {
                label: 'Márgenes',
                icon: iconMargins,
                tooltip: true
            } );

            view.on( 'execute', () => {
                const form = `
				<div id="ckmodal" class="ly-ck-dialog ly-ck-dialog-300">
					<div class="ly-ck-dialog-header">
						<div><strong>Márgenes</strong></div>
						<div id="ckcloseBtn" class="ly-ck-dialog-close-icon">&#10005;</div>
					</div>
					<form class="ly-ck-dialog-form">
						<div class="ly-ck-dialog-group-control">
							<label class="ly-ck-dialog-label" for="left-margin">Margen Izquierdo en mm:</label>
							<input class="ly-ck-dialog-input" type="number" id="left-margin" name="left-margin">
						</div>
						<div class="ly-ck-dialog-group-control">
							<label class="ly-ck-dialog-label" for="right-margin">Margen Derecho en mm:</label>
							<input class="ly-ck-dialog-input" type="number" id="right-margin" name="right-margin">
						</div>
						<div class="ly-ck-dialog-group-control">
							<label class="ly-ck-dialog-label" for="top-margin">Margen Arriba en mm:</label>
							<input class="ly-ck-dialog-input" type="number" id="top-margin" name="top-margin">
						</div>
						<div class="ly-ck-dialog-group-control">
							<label class="ly-ck-dialog-label" for="bottom-margin">Margen Abajo en mm:</label>
							<input class="ly-ck-dialog-input" type="number" id="bottom-margin" name="bottom-margin">
						</div>
						<div class="ly-ck-dialog-buttons">
							<button class="ly-ck-dialog-button" type="button" id="submit-margins" onclick="saving()">
								<span class="fa fa-check"></span>
							</button>
						</div>
					</form>
				</div>
                `;

				var modalMargins = document.createElement("div");
				modalMargins.className = "div-form-center";
				modalMargins.innerHTML = form;
				document.body.appendChild(modalMargins);

                const submitButton = document.querySelector( '#submit-margins' );

                submitButton.addEventListener( 'click', () => {
                    const leftMargin = document.querySelector( '#left-margin' ).value;
                    const rightMargin = document.querySelector( '#right-margin' ).value;
                    const topMargin = document.querySelector( '#top-margin' ).value;
                    const bottomMargin = document.querySelector( '#bottom-margin' ).value;

					document.getElementById('xleft-margin').value = leftMargin;
					document.getElementById('xright-margin').value = rightMargin;
					document.getElementById('xtop-margin').value = topMargin;
					document.getElementById('xbottom-margin').value = bottomMargin;

                    editor.editing.view.getDomRoot().style.paddingLeft = leftMargin + 'mm';
                    editor.editing.view.getDomRoot().style.paddingRight = rightMargin + 'mm';
                    editor.editing.view.getDomRoot().style.paddingTop = topMargin + 'mm';
                    editor.editing.view.getDomRoot().style.paddingBottom = bottomMargin + 'mm';
                } );

				const modal = document.querySelector( '#ckmodal' );
				modal.style.display = "block";

				const ckcloseBtn = document.querySelector( '#ckcloseBtn' );

				ckcloseBtn.addEventListener( 'click', () => {
					modalMargins.remove();
				});
            } );

            return view;
        });

    }

}
