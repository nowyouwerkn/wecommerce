@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Notificaciones</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>

    <style type="text/css">
        .status-circle{
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 5px;
            border-radius: 100%;
        }
    </style>
@endsection

@section('content')
<form method="POST" action="{{ route('mail.update', $mail->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="row">
        <div class="col-md-4">
            <div class="pr-5 pt-1 pl-3">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                    <h4 class="mb-0 ml-2">Regresar</h4>
                </div>

                <h3>Notificaciones</h3>
                <p>Para comunicarte por medio de correo electrónico por medio de tu plataforma necesitas configurar los datos del servidor.</p>
                <p>Las plantillas de correo son prediseñadas especialmente para mejorar la conversión y comunicación de tu marca con tus clientes.</p>

                <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios <i class="far fa-save"></i></button>
            </div>
        </div>
        <div class="col-md-8">
            
            <div class="card mb-4">
                <div class="card-body">
                
                <h6 class="text-uppercase mb-3">Configuración de Correo</h6>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="mail_host">Host del Servidor de Correos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mail_host" name="mail_host" value="{{ $mail->mail_host ?? '' }}" placeholder="smtp.postmarkapp.com" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_port">Puerto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mail_port" name="mail_port" value="{{ $mail->mail_port ?? '' }}" placeholder="587" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mail_username">Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mail_username" name="mail_username" value="{{ $mail->mail_username ?? '' }}" placeholder="" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mail_password">Contraseña <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mail_password" name="mail_password" value="{{ $mail->mail_password ?? '' }}" placeholder="" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="mail_encryption">Tipo de Encriptación <span class="text-danger">*</span></label>
                            <select class="form-control" name="mail_encryption">
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</form>
@endsection