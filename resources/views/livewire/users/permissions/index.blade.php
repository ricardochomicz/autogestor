<div>
    <div class="card col-8 mx-auto rounded">
        <div class="card-header">
            <a href="{{ route('users.index') }}" class="btn btn-info"><i class="fas fa-angle-left mr-1"></i> Voltar</a>
            <a href="{{ route('user.permissions.available', $user->id) }}" class="btn btn-default"><i
                    class="fas fa-link mr-1"></i> Adicionar Permissão</a>
        </div>
        <div class="card-body">
            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-sm-6 has-search">
                    <input wire:model.live="search" class="form-control" name="search"
                        placeholder="pesquisa por nome...">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" wire:click="clearFilter">Limpar Filtros</button>
                </div>
            </div>

            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th class="text-center">...</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->label }}</td>
                            <td class="text-center">
                                <a href="{{ route('user.permissions.detach', [$user->id, $permission->id]) }}"
                                    class="btn btn-sm btn-danger"><i class="fas fa-unlink mr-2"></i> Desvincular</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $permissions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
