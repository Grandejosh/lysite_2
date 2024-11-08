@extends('layouts.tutorio')
@section('styles')

@stop
@section('content')
    <div class="hero_area">
        <div class="mdk-header-layout__content page-content">
            <div class="container" style="margin-top: 16px">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <form method="POST" action="{{ route('complaintbook_store') }}">
                            @csrf
                            <div class="card">
                                <img src="/theme-lyontech/images/leon.png" class="card-img-top"
                                    style="width: 180px;height:180px;margin:auto;margin-top:10px" />
                                <div class="card-body">
                                    <h4>IDENTIFICACIÓN DEL CONSUMIDOR DRECLAMANTE</h4>
                                    <div class="form-group row">
                                        <label for="nombres" class="col-sm-4 col-form-label">NOMBRES Y APELLIDOS</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('nombres') }}" name="nombres" id="nombres" type="text"
                                                class="form-control">
                                            @error('nombres')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="numero_dni" class="col-sm-4 col-form-label">DNI</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('numero_dni') }}" name="numero_dni" type="text"
                                                class="form-control" id="numero_dni">
                                            @error('numero_dni')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-4 col-form-label">TELÉFONO</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('telefono') }}" name="telefono" type="text"
                                                class="form-control" id="telefono">
                                            @error('telefono')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label">EMAIL</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('email') }}" name="email" type="text"
                                                class="form-control" id="email">
                                            @error('email')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="domicilio" class="col-sm-4 col-form-label">DOMICILIO</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('domicilio') }}" name="domicilio" type="text"
                                                class="form-control" id="domicilio">
                                            @error('domicilio')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <h4 style="margin-top:60px">IDENTIFICACIÓN DEL BIEN CONTRATADO</h4>
                                    <div class="form-group row">
                                        <label for="serie" class="col-sm-4 col-form-label">SERIE Y NÚMERO</label>
                                        <div class="col-sm-4">
                                            <input value="{{ old('serie') }}" name="serie" id="serie" type="text"
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <input value="{{ old('numero') }}" name="numero" id="numero" type="text"
                                                class="form-control">
                                        </div>
                                        @error('serie')
                                            <small class="text-danger text-xs">{{ $message }}</small>
                                        @enderror
                                        @error('numero')
                                            <small class="text-danger text-xs">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">MONTO RECLAMADO</label>
                                        <div class="col-sm-4">
                                            <input value="{{ old('monto') }}" name="monto" type="text"
                                                class="form-control" id="monto">
                                            @error('monto')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="contrato-descripcion"
                                            class="col-sm-4 col-form-label">DESCRIPCIÓN</label>
                                        <div class="col-sm-8">
                                            <input value="{{ old('contrato-descripcion') }}" name="contrato-descripcion"
                                                type="text" class="form-control" id="contrato-descripcion">
                                            @error('contrato-descripcion')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <h4 style="margin-top:60px">DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h4>
                                    <div class="form-group row">
                                        <label for="tipo" class="col-sm-4 col-form-label">TIPO</label>
                                        <div class="col-sm-8">
                                            <select name="tipo" class="form-control" id="tipo">
                                                <option value="reclamo" {{ old('tipo') == 'reclamo' ? 'selected' : '' }}>
                                                    RECLAMO</option>
                                                <option value="queja" {{ old('tipo') == 'queja' ? 'selected' : '' }}>
                                                    QUEJA</option>
                                            </select>
                                            @error('tipo')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="detalle" class="col-sm-4 col-form-label">DETALLE</label>
                                        <div class="col-sm-8">
                                            <textarea name="detalle" class="form-control" id="detalle" rows="4">{{ old('detalle') }}</textarea>
                                            @error('detalle')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pedido" class="col-sm-4 col-form-label">PEDIDO</label>
                                        <div class="col-sm-8">
                                            <textarea name="pedido" class="form-control" id="pedido" rows="4">{{ old('pedido') }}</textarea>
                                            @error('pedido')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <fieldset class="form-group row">
                                        <legend class="col-form-label col-sm-4 float-sm-left pt-0"></legend>
                                        <div class="col-sm-8">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="conformidad"
                                                    name="conformidad" value="1">
                                                <label class="form-check-label" for="conformidad">
                                                    EN CONFORMIDAD POR LO DETALLADO
                                                </label>
                                            </div>
                                            @error('conformidad')
                                                <small class="text-danger text-xs">{{ $message }}</small>
                                            @enderror
                                            <br />
                                            <p>* RECLAMO: Disconformidad relacionada a los productos o servicios</p>
                                            <p>* QUEJA: Disconformidad no relacionada a los productos o servicios; o
                                                malestar o descontento respecto a la atención al público.</p>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('modales')

    <!-- Modal -->
    <div class="modal fade" id="exampleModalAlerta" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Validación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    @if ($errors->any())
        <script>
            $('#exampleModalAlerta').modal('show');
        </script>
    @endif
@stop
