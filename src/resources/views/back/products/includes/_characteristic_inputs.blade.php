<div class="d-flex align-items-center">
    <div>
        <a href="javascript:void(0)" class="btn-eliminate mr-2"><i class="fas fa-minus"></i></a>
    </div>

    <div class="row ml-1">
        <div class="form-group col-4">
            <label for="name">Titulo <span class="text-danger tx-12">*</span></label>
            <input type="text" name="char_title[]" class="form-control">
        </div>

        <div class="form-group col-4">
            <label for="name">Subtítulo <span class="text-info tx-12">(Opcional)</span></label>
            <input type="text" name="char_subtitle[]" class="form-control">
        </div>
    
        <div class="form-group col-4">
            <label for="name">Ícono / Imagen <span class="text-info tx-12">(Opcional)</span></label>
            <input type="file" name="char_icon[]" class="form-control">
        </div>
    </div>

    <script>
        $('.btn-eliminate').on('click', function(e){
            $(this).parent().parent().remove();
        });
    </script>
</div>

