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
            <a href="{{ route('notifications.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Agregar Notificación
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Pedidos -->
        <div class="col-md-10 mb-4">
            <div class="card p-3">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Pedidos</h5>
                    <p class="tx-12 tx-color-03 mg-b-0">Pedidos.</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <!-- Body -->
                    <div class="row mt-3">
                        <div class="col">
                            Confirmación del pedido
                        </div>
                        <div class="col">
                            Enviado automáticamente al cliente después de realizar su pedido.
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            Pedido editado
                        </div>
                        <div class="col">
                            Se envía al cliente cuando su pedido se edita (si seleccionas esta opción) 
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            Factura del pedido
                        </div>
                        <div class="col">
                            Se envía al cliente cuando el pedido tiene un saldo pendiente.  
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            Carritos abandonados
                        </div>
                        <div class="col">
                            Se le envía al cliente si abandona la pantalla de pagos antes de comprar los artículos en su carrito. Configura opciones en  
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Envios -->
        <div class="col-md-10 mb-4">
            <div class="card p-3">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Envios</h5>
                    <p class="tx-12 tx-color-03 mg-b-0">Envios.</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col">
                            Actualización de envío
                        </div>
                        <div class="col">
                            Se envía automáticamente al cliente si el número de seguimiento del pedido enviado se actualiza (si seleccionas esta opción). 
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
    
                    <div class="row mt-3">
                        <div class="col">
                            Enviado al destinatario
                        </div>
                        <div class="col">
                            Se envía al cliente automáticamente después de que los pedidos con información de seguimiento estén en proceso de entrega.
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Retiro Local -->
        <div class="col-md-10 mb-4">
            <div class="card p-3">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Retiro Local</h5>
                    <p class="tx-12 tx-color-03 mg-b-0">Retiro Local.</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col">
                            Listo para ser retirado
                        </div>
                        <div class="col">
                            Envío de forma manual al cliente a través del Point of Sale o del panel de control. Informa al cliente que su pedido está listo para ser retirado. 
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cliente -->
        <div class="col-md-10 mb-4">
            <div class="card p-3">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Cliente</h5>
                    <p class="tx-12 tx-color-03 mg-b-0">Cliente.</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col">
                            Bienvenida a la cuenta de cliente
                        </div>
                        <div class="col">
                            Se envía de manera automática al cliente cuando completa la activación de la cuenta. 
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
    
                    <!-- Body -->
                    <div class="row mt-3">
                        <div class="col">
                            Restablecimiento de contraseña de cuenta de cliente
                        </div>
                        <div class="col">
                            Se envía de manera automática a los clientes cuando solicitan restablecer la contraseña de sus cuentas.  
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devoluciones -->
        <div class="col-md-10 mb-4">
            <h3>Devoluciones</h3>
            <div class="card p-3">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Cliente</h5>
                    <p class="tx-12 tx-color-03 mg-b-0">Cliente.</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col">
                            Instrucciones de etiqueta de devolución
                        </div>
                        <div class="col">
                            Enviada al cliente después de crear una etiqueta de devolución.  
                        </div>
                        <div class="col-2">
                            <a href="#">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection