<div class="row">
    <div class="form-group col-md-12 col-lg-6">
        <x-input label="Label" name="label" id="label" class="form-control"
            value="{{ @$permission->label ?? old('label') }}" />
    </div>
    <div class="form-group col-md-12 col-lg-6">
        <x-input label="Nome" name="name" id="name" class="form-control"
            value="{{ @$permission->name ?? old('name') }}" />
    </div>

</div>
<button class="btn btn-primary" type="submit"><i class="fas fa-save mr-2"></i> Salvar</button>
<a href="{{ route('permissions.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Voltar</a>
