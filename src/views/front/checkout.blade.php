@extends('front.layouts.main')

@section('content')

<!-- breadcrumb-area -->
<section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('themes/werkn-backbone/img/bg/breadcrumb_bg01.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="text-white">Checkout</h2>
                    <p>Un paso más cerca de tus productos favoritos.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->

<!-- Checkout -->
<section class="mt-5 mb-5">
    <!-- Checkout -->
    <form action="" method="POST">
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card p-2">
                    <p>Dirección de Envío</p>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="lastname">Apellidos</label>
                            <input type="text" name="lastname" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="email">Correo</label>
                            <input type="text" name="email" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="email-c">Confirmar Correo</label>
                            <input type="text" name="email-c" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="phone">Telefono de contacto</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="country">País</label>
                            <select class="form-select" name="country">
                                <option value="mexico" selected>Mexico</option>
                                <option value="usa">USA</option>
                                <option value="canada">Canada</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="state">Estado</label>
                            <select class="form-select" name="country">
                                <option value="guanajuato" selected>Guanajuato</option>
                                <option value="Guadalajara">Guadalajara</option>
                                <option value="Queretaro">Queretaro</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="city">Ciudad</label>
                            <input type="text" name="city" class="form-control">
                        </div>

                        <div class="col-md-8">
                            <label for="street">Calle</label>
                            <input type="text" name="street" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="num">Num</label>
                            <input type="text" name="num" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="col">Colonia</label>
                            <input type="text" name="col" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="references">Referencias</label>
                            <textarea class="form-control" name="references"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="code">Codigo Postal</label>
                            <input type="text" name="code" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <a href="#" class="btn btn-primary mt-3">Continuar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-2">
                    <p>Información de Pago</p>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name">Numero de tarjeta</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="lastname">Nombre de Tarjeta</label>
                            <input type="text" name="lastname" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="email">Mes</label>
                            <input type="text" name="email" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="email-c">Año</label>
                            <input type="text" name="email-c" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="phone">CCV</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <a href="#" class="btn btn-primary mt-3">Continuar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-2">
                    <p>Confirma tu Pedido</p>
                    <div class="row">
                        <!-- Message -->
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                ¿Quieres editar el carrito?
                                <br>
                                <a href="{{ route('catalog') }}">Ve al catalogo</a>
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="row mb-2">
                            <div class="col">
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    XXL
                                </p>
                            </div>
                            <div class="col text-end">
                                <p>$37</p>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    XXL
                                </p>
                            </div>
                            <div class="col text-end">
                                <p>$37</p>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    XXL
                                </p>
                            </div>
                            <div class="col text-end">
                                <p>$37</p>
                            </div>
                        </div>

                        <!-- Information -->
                        <div class="row ">
                            <div class="col">
                                Envío
                            </div>
                            <div class="col text-end">
                                $10
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col">
                                Subtotal
                            </div>
                            <div class="col text-end">
                                $70.56
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col">
                                Iva
                            </div>
                            <div class="col text-end">
                                $13.44
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4>Total</h4>
                            </div>
                            <div class="col text-end">
                                <h4>84</h4>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-12 text-center">
                            <a href="#" class="btn btn-primary mt-3">Confirmar compra</a>
                            <p>todos los metodos procesadas por <ion-icon name="card-outline"></ion-icon></p>
                            <p>Envíos de 3 a 5 dias habiles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection