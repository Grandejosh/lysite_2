<div>

    <div class="bg-white box-section">
        <div class="container-section page__container" style="width:90%;">
            <div class="row">
                <div class="col-md-2 align-items-start" style="padding: 0px;">
                    <p class="title-ia-lyon">
                        <STRONG>IA LYON</STRONG>
                    </p>
                </div>
                <div class="col-md-8 d-flex justify-content-center align-items-center" style="padding: 0px;">
                    <div class="image-der mr-3">
                        <img src="{{ asset('assets/images/ai-blanco.jpg') }}" alt="Card image cap"
                            style="width: 100px;  margin: auto;">
                    </div>
                    <div class="texto">
                        <h5 class="mb-0" style="margin-left: -10px;">
                            <strong style="font-size: 1.8rem;letter-spacing: 0.0em;">CONSULTAS IA</strong>
                        </h5>
                    </div>
                </div>
                <div class="col-md-2 align-items-end" style="padding: 0px;">
                    <p style="padding: 85px 0px 0px 0px;">

                        <strong style="font-weight: 700;">OPORTUNIDADES&nbsp;:</strong> Ilimitadas<br>

                        <strong
                            style="font-weight: 700;">UTILIZADOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>
                        0<br>

                        <strong
                            style="color: red;">DISPONIBLES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            Ilimitado
                        </strong>

                        <br>
                    </p>
                </div>
            </div>
            <div class="row box-chrerry">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="manito media tab-vertical active" style="cursor: pointer !important;">
                                <img src="{{ asset('assets/images/8a.png') }}" alt="Icono"
                                    class="media-left rounded">
                                <span class="media-body manito">
                                    <h5 class="mb-0">PARAFRASEADOR</h5>
                                    <p class="mt-0">Cambia textos para mejorar su originalidad.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="media tab-vertical" style="cursor: pointer !important;">
                                <img src="{{ asset('assets/images/8b.png') }}" alt="Icono"
                                    class="media-left rounded">
                                <span class="media-body">
                                    <h5 class="mb-0">RECOMENDADOR</h5>
                                    <p>Accede a la recomendación de articulos cientificos.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="media tab-vertical" style="cursor: pointer !important;">
                                <img src="{{ asset('assets/images/8c.png') }}" alt="Icono"
                                    class="media-left rounded">
                                <span class="media-body">
                                    <h5 class="mb-0">CORRECTOR</h5>
                                    <p>Revisa y corrige errores gramaticales.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="media tab-vertical" style="cursor: pointer !important;">
                                <img src="{{ asset('assets/images/8d.png') }}" alt="Icono"
                                    class="media-left rounded">
                                <span class="media-body">
                                    <h5 class="mb-0">CHATBOT</h5>
                                    <p>Haz consultas o sube archivos para cualquier duda.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="media tab-vertical" style="cursor: pointer !important;">
                                <img src="{{ asset('assets/images/8e.png') }}" alt="Icono"
                                    class="media-left rounded">
                                <span class="media-body">
                                    <h5 class="mb-0">REFERENCIADOR</h5>
                                    <p>Referencia de acuerdo a la normativa con solo un enlace.</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">

                    <div class="row align-items-center">
                        <div class="col-md-12">

                            <div class="mt-2">
                                <select name="prompt" class="form-control" id="exampleFormControlSelect1"
                                    style="background-color: #fff;">
                                    <option value="0">Como Investigador</option>
                                    <option value="1">Disminuir Similitud</option>
                                    <option value="2">Humanizar Texto</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <textarea class="form-control" id="consulta" rows="6" autocomplete="off"
                                    placeholder="Escribe aquí lo que desee parafrasear." style="background-color: #fff;"></textarea>
                            </div>

                            <button type="button" class="btn btn-orange">
                                <div style="display: none" class="spinner-grow spinner-grow-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Procesar
                            </button>


                            <div class="mb-3">
                                <textarea class="form-control"id="resultado" rows="5" readonly></textarea>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
