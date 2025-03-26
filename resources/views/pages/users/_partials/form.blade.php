<div class="row">
    <div class="form-group col-md-6 col-lg-12">
        <x-input label="Nome" name="name" id="name" class="form-control"
            value="{{ @$user->name ?? old('name') }}" />

    </div>
    <div class="form-group col-md-6 col-lg-12">
        <x-input label="E-mail" name="email" id="email" class="form-control"
            value="{{ @$user->email ?? old('email') }}" />

    </div>
    @if (isset($isEdit) && !$isEdit)
        <div class="form-group col-md-6 col-lg-12">
            <x-input label="Senha" name="password" id="password" class="form-control" type="password" />
        </div>
    @endif
</div>
<button class="btn btn-primary" type="submit"><i class="fas fa-save mr-2"></i> Salvar</button>
<a href="{{ route('users.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Voltar</a>
