<div id="search" class="search-container d-flex align-items-center">
	<div class="container">
		<h2 class="text-center mb-3">Búsqueda de Productos</h2>

	    <form action="#" id="search-form">
	        @csrf
	        <div class="row">
	            <div class="col-4 ms-auto me-auto" id="search-wrapper">
	            	<div class="d-flex align-items-center">
	            		<input type="text" class="form-control w-100 m-0 search" style="background-color: transparent !important;" placeholder="Encuentra tu favorito...">
	                	<ion-icon name="search-outline" style="font-size: 1.3em; position: relative; left: -25px;"></ion-icon>
	            	</div>
	            </div>

	            <div class="col-12">
	            	<div id="searchResults" class="mt-5">

	                </div>
	            </div>
	        </div>
	    </form>
	</div>
</div>

@push('scripts')
<script>
    $(function (){
        'use strict';
        $(document).on('keyup', '#search-form .search', function (){
            if($(this).val().length > 0){
                var search = $(this).val();
                $.get("{{ route('posts.search.now') }}", {search: search}, function (res){
                    $('#searchResults').html(res);
                });
                return;
            }

            $('#searchResults').empty();
        });
    });
</script>
@endpush

