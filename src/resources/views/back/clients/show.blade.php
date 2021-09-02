@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Clientes</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-2">
		<!-- Page card -->
		<div class="card text-center">
			<div class="card-header">
				<div class="card-header-content">
					<a class="avatar avatar-lg" href="javascript:void(0)">
						@if( $client->image == NULL)
						<img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( $client->email))) . '?d=retro&s=200' }}" alt="{{ $client->name }}" style="width: 100%;" class="rounded-circle mt-2">
						@else
						<img src="{{ asset('img/users/' . $client->image ) }}" alt="{{ $client->name }}" class="rounded-circle">
						@endif
					</a>

					<div class="profile-user mt-3"><strong>{{ $client->name }}</strong></div>
					<p>{{ $client->email }}</p>
				</div>
			</div>
			<div class="card-footer">
				<ul class="list-inline mb-0">
					<li class="list-inline-item"><strong class="profile-stat-count">{{ $client->orders->count() }}</strong>
						<span>Órdenes</span>
					</li>
					<li class="list-inline-item">
						<strong class="profile-stat-count">
							@if($client->reviews == NULL)
							0
							@else
							{{ $client->reviews->count() }}
							@endif
						</strong>
						<span>Reseñas</span>
					</li>
					<li class="list-inline-item">
						<strong class="profile-stat-count">
							@if($wishlist == NULL)
							0
							@else
							{{ $wishlist->count() }}
							@endif
						</strong>
						<span>Wishlist</span>
					</li>
				</ul>
			</div>
		</div>
		<!-- End Page card -->
	</div>

	<div class="col-md-10">
		<!-- card -->
		<div class="card">
			<div class="card-body pt-0">
				<ul class="nav nav-line mt-3" data-plugin="nav-tabs" role="tablist">
					<li class="nav-item" role="presentation"><a data-toggle="tab" href="#orders" aria-controls="orders"
					role="tab" class="nav-link active">Órdenes <span class="badge badge-danger">{{ $client->orders->count() }}</span></a></li>

					<li class="nav-item" role="presentation"><a data-toggle="tab" href="#wishlist" aria-controls="wishlist"
					role="tab" class="nav-link">Wishlist <span class="badge badge-danger">{{ $wishlist->count() }}</span></a></li>

					<li class="nav-item" role="presentation"><a data-toggle="tab" href="#addresses" aria-controls="addresses"
					role="tab" class="nav-link">Direcciones <span class="badge badge-danger">{{ $addresses->count() }}</span></a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="orders" role="tabpanel">
						@if($orders->count())
						<div class="table-responsive mt-3">
		                    <div class="table-responsive">
			                    @include('wecommerce::back.orders.utilities._order_table')
			                </div>
		                </div>
						@else
						<div class="text-center mt-5">
							<h4 class="mb-0">{{ $client->name }} no tiene compras recientes.</h4>
							<p>¡Visita a este cliente en el futuro para ver si ya compró algo!</p>
						</div>
						@endif
					</div>

					<div class="tab-pane" id="wishlist" role="tabpanel">
						@if($wishlist->count())
						<div class="mt-3">
							<div class="row">
								@foreach($wishlist as $ws)
								<div class="col-md-3">
									<div class="card">
										<img src="{{ asset('img/products/' . $ws->product->image) }}" class="card-img-top" alt="{{ $ws->product->name }}">
										<div class="card-body">
											<h6 class="card-title mb-0">{{ $ws->product->name }}</h6>
											<p class="card-text">SKU: {{ $ws->product->sku ?? $ws->product->barcode }}</p>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
						@else
						<div class="text-center mt-5">
							<h4 class="mb-0">{{ $client->name }} no ha agregado productos a su wishlist.</h4>
							<p>¡Visita a este cliente en el futuro!</p>
						</div>
						@endif
					</div>

					<div class="tab-pane" id="addresses" role="tabpanel">
						@if($addresses->count())
						<div class="table-responsive mt-3">
		                    <table class="table">
		                        <thead>
		                            <tr>
		                                <th>#</th>
		                                <th>Nombre</th>
		                                <th>Dirección</th>
		                                <th>Teléfono</th>
		                                <th>Creación</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            @foreach($addresses as $add)
		                            <tr>
		                                <td>#{{ $add->id }}</td>
		                                <td>{{ $add->name }}</td>
		                                <td>{{ $add->street . ',' . $add->street_num }} / {{ $add->city . ',' . $add->state . ' ' . $add->postal_code }}</td>
		                                <td>{{ $add->phone }}</td>
		                                <td>
		                                    <span class="text-muted"><i class="wb wb-time"></i> {{ $add->created_at }}</span>
		                                </td>
		                            </tr>
		                            @endforeach
		                        </tbody>
		                    </table>
		                </div>
						@else
						<div class="text-center mt-5">
							<h4 class="mb-0">{{ $client->name }} no ha agregado direcciones.</h4>
							<p>¡Visita a este cliente en el futuro!</p>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection