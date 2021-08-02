@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Preferencias Generales</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Preferencias Generales</h4>
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
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Preferencias Generales</h3>
            <p>Conecta cualquier sistema de empresas de terceros para analítica, seguimiento de pedidos, reservaciones, chats en vivo y más. .</p>

            <p>Tu tienda puede vincularse con: </p>

            <ul>
                <li>Google Analytics</li>
                <li>Facebook Pixel</li>
                <li>Jivo Chat</li>
                <li>Sirvoy</li>
                <li>Acuity Scheduling</li>
                <li>Calendly</li>
                <li>y mas...</li>
            </ul>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card card-body mb-4">
            <h4>Logotipo de Tienda</h4>
            <p class="mb-4"><strong>Operativo</strong></p>

            @if($store_logo->store_logo == NULL)
            <div class="text-center">
                <img src="{{ asset('assets/img/logo.png') }}" class="ml-auto mr-auto mb-5">
            </div>
            @else
            <div class="text-center">
                <img src="{{ asset('assets/img/' . $store_logo->store_logo ?? 'logo-store.png') }}" class="ml-auto mr-auto mb-5">
            </div>
            @endif

            @if($store_logo->store_logo == NULL)
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalLogo" class="btn btn-sm btn-outline-light btn-uppercase btn-block mt-3">Subir Logotipo</a>
            @else
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalLogo" class="btn btn-sm btn-outline-light btn-uppercase btn-block mt-3">Editar Logotipo</a>
            @endif
        </div>

        <div class="card card-body mb-4">
            <h4>Integraciones del Sitio</h4>
            <p class="mb-4"><strong>Operativo</strong></p>

            @if($integrations->count() == 0)
            <div class="text-center">
                <img src="{{ asset('assets/img/group_9.svg') }}" class="wd-40p ml-auto mr-auto mb-5">
                <h4>No hay integraciones activas en tu plataforma.</h4>
                <p class="mb-4">Empieza dando click en el botón inferior.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($integrations as $integration)
                        <tr>
                            <td>{{ $integration->name }}</td>
                            <td>{{ $integration->code }}</td>
                            <td>
                                @if($integration->is_active == true)
                                    <span class="status-circle bg-success"></span> Activo
                                @else
                                    <span class="status-circle bg-danger"></span> Desactivado
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </a>

                                <form method="POST" action="{{ route('integrations.destroy', $integration->id) }}" style="display: inline-block;">
                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" data-toggle="tooltip" data-original-title="Borrar">
                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                    </button>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-outline-light btn-uppercase btn-block mt-3">Integrar un nuevo sistema</a>
        </div>
    </div>
</div>


<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('integrations.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="form-group mt-2">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <select class="custom-select tx-13" id="main_category"  name="name" required="">
                            <option value="Google Analytics">Google Analytics</option>
                            <option value="Facebook Pixel">Facebook Pixel</option>
                            <option value="Jivo Chat">Jivo Chat</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label>Código <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="code" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Integrar Ahora</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modalLogo" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Subir Logotipo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="POST" action="{{ route('store.logo') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="form-group mt-2">
                        <label>Imágen <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="logo" name="logo" />
                        <small>RECOMENDACIONES: Sube un archivo en .PNG optimizado que no supere 400px de ancho.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Subir Logotipo</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection