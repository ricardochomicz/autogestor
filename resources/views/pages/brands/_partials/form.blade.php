<div class="row">
    <div class="form-group col-md-6 col-lg-12">
        <x-input label="Nome" name="name" id="name" class="form-control"
            value="{{ @$brand->name ?? old('name') }}" />
    </div>

</div>
<button class="btn btn-primary" type="submit"><i class="fas fa-save mr-2"></i> Salvar</button>
<a href="{{ route('brands.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Voltar</a>
