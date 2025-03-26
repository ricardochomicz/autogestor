<div>
    <div class="card">

        <div class="card-body">
            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-md-12 col-lg-6 has-search">
                    <input class="form-control" wire:model.live="search" name="search" placeholder="pesquisa por nome...">
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    <button type="button" wire:click="clearFilter" class="btn btn-secondary">Limpar Filtro</button>
                </div>
            </div>
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Label</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                        <tr>
                            <td class="align-middle">{{ $permission->id }}</td>
                            <td class="align-middle">{{ $permission->label }}</td>
                            <td class="align-middle">{{ $permission->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum registro encontrado</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $permissions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
