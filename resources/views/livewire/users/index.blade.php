<div>
    <div class="card">
        @if (Gate::allows('is-admin'))
            <div class="card-header">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Novo Usuário</a>
            </div>
        @endif
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
                        <th>Email</th>
                        <th>Papel</th>
                        <th>Criado em</th>
                        <th class="text-center">...</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="align-middle">{{ $user->id }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td class="align-middle">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                @if (Gate::allows('is-admin'))
                                    <a href="{{ route('user.permissions', $user->id) }}"
                                        class="btn btn-sm btn-info">Permissões</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                        onclick="destroy('{{ route('users.transfer', $user->id) }}', 'deletar', '{{ $user->name }}')">Excluir</a>
                                @endif
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
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
