<div>
    <div class="card">
        <div class="card-header">
            <a href="{{ route('brands.create') }}" class="btn btn-primary">Nova Marca</a>
        </div>
        <div class="card-body">
            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-md-12 col-lg-6 has-search">
                    <input class="form-control" wire:model.live="search" name="search"
                        placeholder="pesquisa por nome...">
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    <button type="button" wire:click="clearFilter" class="btn btn-secondary">Limpar Filtro</button>
                </div>
            </div>
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Criado em</th>
                        <th class="text-center">...</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td class="align-middle">{{ $brand->id }}</td>
                            <td class="align-middle">{{ $brand->name }}</td>
                            <td class="align-middle">{{ $brand->created_at->diffForHumans() }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('brands.edit', $brand->id) }}"
                                    class="btn btn-sm btn-primary">Editar</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                    onclick="destroy('{{ route('brands.destroy', $brand->id) }}', 'deletar', '{{ $brand->name }}')">Excluir</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum registro encontrado</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $brands->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
