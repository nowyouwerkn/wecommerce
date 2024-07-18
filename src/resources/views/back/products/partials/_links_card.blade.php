<div class="card mg-t-10 mb-4">
    <!-- Header -->
    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
        <h5 class="mg-b-5">Links Externos</h5>
        <p class="tx-12 tx-color-03 mg-b-0">Configura esta información para darle a conocer a tus clientes en que otros lugares se vende tu producto.</p>
    </div>

    <!-- Form -->
    <div class="card-body">
        <form id="link-new" action="{{ route('link.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" name="product_id" value="{{ $product->id }}" hidden>
            <div class="d-flex align-items-center">
                <div class="d-flex">
                    <a href="javascript:void(0)" class="btn-eliminate mr-2"><i class="fas fa-minus"></i></a>
                    <button type="submit" class="btn-save mr-2"><i class="fas fa-save"></i></button>
                </div>

                <div class="row ml-1">
                    <div class="form-group col-4">
                        <label for="name">Nombre <span class="text-danger tx-12">*</span></label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="form-group col-4">
                        <label for="name">URL <span class="text-danger tx-12">*</span></label>
                        <input type="text" name="url" class="form-control">
                    </div>

                    <div class="form-group col-4">
                        <label for="name">Ícono / Imagen <span class="text-info tx-12">(Opcional)</span></label>
                        <input type="file" name="image" class="form-control" accept=".jpg, .jpeg, .png">
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <a href="javascript:void(0)" id="newLink" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i class="far fa-plus-square"></i> Agrega Link</a>
        <hr>

        @foreach($product->links as $link)
        <div class="d-flex align-items-center">
            <div class="d-flex">
                <form method="POST" action="{{ route('link.destroy', $link->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn-eliminate mr-2" style="border: none"><i class="fas fa-trash"></i></button>
                </form>
            </div>

            <form id="link-u" action="{{ route('link.update', $link->id) }}" method="POST" class="d-flex align-items-center">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <button type="submit" class="btn-save-2 mr-2" style="border: none"><i class="fas fa-save"></i></button>

                <div class="row ml-1">
                    <div class="form-group col-4">
                        <label for="name">Nombre <span class="text-danger tx-12">*</span></label>
                        <input type="text" name="name" value="{{ $link->name }}" class="form-control">
                    </div>

                    <div class="form-group col-4">
                        <label for="name">URL <span class="text-info tx-12">(Opcional)</span></label>
                        <input type="text" name="url" value="{{ $link->url }}" class="form-control">
                    </div>

                    <div class="form-group col-4">
                        <label for="name">Ícono / Imagen <span class="text-info tx-12">(Opcional)</span></label>
                        @if($link->icon != NULL)
                        <img src="{{ asset('/img/icons/' . $link->icon) }}" alt="icon" width="120">
                        @else
                        <i class="fas fa-check-circle text-success"></i>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

