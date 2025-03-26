<div class="row">
    <div class="form-group col-md-6 col-lg-6">
        <x-select label="Marca" :options="$brands" name="brand_id" id="brand_id" title="Selecione"
            value="{{ old('brand_id') ?? @$product->brand_id }}" />
    </div>
    <div class="form-group col-md-6 col-lg-6">
        <x-select label="Categoria" :options="$categories" name="category_id" id="category_id" title="Selecione"
            value="{{ old('category_id') ?? @$product->category_id }}" />
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12 col-lg-8">
        <x-input label="Nome" name="name" id="name" class="form-control"
            value="{{ @$product->name ?? old('name') }}" />
    </div>
    <div class="form-group col-md-12 col-lg-4">
        <x-input label="Valor" name="price" id="price" class="form-control"
            value="{{ @$product->price ?? old('price') }}" />
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12 col-lg-12">
        <x-input label="Descrição" name="description" id="description" class="form-control"
            value="{{ @$product->description ?? old('description') }}" />
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12 col-lg-2">
        <x-input type="number" label="Quantidade" name="stock" id="stock" class="form-control"
            value="{{ @$product->stock ?? old('stock') }}" />
    </div>
</div>
<button class="btn btn-primary" type="submit"><i class="fas fa-save mr-2"></i> Salvar</button>
<a href="{{ route('products.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Voltar</a>
