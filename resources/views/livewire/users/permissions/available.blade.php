<div>
    <div class="card col-8 mx-auto">
        <div class="card-header">
            <div class="card-tools">
                Selecionar todos
                <label class="switch mr-2">
                    <input type="checkbox" class="default module-checkbox" id="select-all-checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
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
            <div class="small-box shadow-none">

                <div class="table-responsive rounded">

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="15%"></th>
                                @if (count($permissions))
                                    <th>Permissão</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('user.permissions.attach', $user->id) }}" method="POST">
                                @csrf
                                @forelse($permissions as $p)
                                    <tr>
                                        <td class="text-center">
                                            <label class="switch ">
                                                <input type="checkbox" class="primary module-checkbox"
                                                    name="permissions[]" value="{{ $p->id }}">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>{{ $p->label }}</td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">Nenhuma permissão
                                            disponível</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="2">
                                        @if (count($permissions))
                                            <button class="btn btn-primary"><i class="fas fa-link mr-1"></i>
                                                Vincular</button>
                                        @endif
                                        <a href="{{ route('user.permissions', $user->id) }}"
                                            class="btn btn-secondary"><i class="fas fa-angle-left mr-1"></i> Voltar</a>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $permissions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtem o checkbox "Selecionar Todos"
            var selectAllCheckbox = document.getElementById('select-all-checkbox');

            // Obtem todos os outros checkboxes
            var moduleCheckboxes = document.querySelectorAll('.module-checkbox');

            // Adiciona um evento de clique ao checkbox "Selecionar Todos"
            selectAllCheckbox.addEventListener('click', function() {
                // Verifique se o checkbox "Selecionar Todos" está marcado
                var isChecked = selectAllCheckbox.checked;

                // Atualiza o estado de todos os outros checkboxes
                moduleCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        });
    </script>
@endpush
