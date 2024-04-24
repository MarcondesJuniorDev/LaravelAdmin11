<div>
    <div class="p-4 justify-between sm:inline-flex sm:space-x-2 space-x-0 sm:space-y-0 space-y-2">
        <div>
            <button wire:click="openCreateModal" class="w-full flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                </svg>
                Nova Função
            </button>
        </div>
        <div>
            <label for="table-search" class="sr-only">Pesquisa</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" id="table-search" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pesquisar . .">
            </div>
        </div>
    </div>
    @if($selectedRoles)
        <div class="p-4 justify-between sm:space-x-2 space-x-0 sm:space-y-0 space-y-2">
            <div>
                <button wire:click="deleteSelectedRoles" onclick="confirm('Tem certeza que deseja excluir todos as funções selecionadas ?') || event.stopImmediatePropagation()" title="Remover funções selecionadas?" class="w-full flex bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    Deletar Funções Selecionadas ({{ count($selectedRoles) }})
                </button>
            </div>
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input wire:model="selectAll" type="checkbox" class="sr-only w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label class="sr-only">Selecionar Todos</label>
                    </div>
                </th>
                <th scope="col" wire:click="sortBy('id')" class="px-6 py-3">
                    <button>
                        #
                        @if($sortField === 'id')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 15l7-7 7 7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </th>
                <th scope="col" wire:click="sortBy('name')" class="px-6 py-3">
                    <button>
                        NOME
                        @if($sortField === 'name')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 15l7-7 7 7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </th>
                <th scope="col" wire:click="sortBy('slug')" class="px-6 py-3">
                    <button>
                        SLUG
                        @if($sortField === 'slug')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 15l7-7 7 7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    PERMISSÕES
                </th>
                <th scope="col" wire:click="sortBy('description')" class="px-6 py-3">
                    <button>
                        DESCRIÇÃO
                        @if($sortField === 'description')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 15l7-7 7 7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-end">
                    AÇÕES
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr
                    wire:key="{{ $role->id }}"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input type="checkbox" value="{{ $role->id }}" wire:model.live="selectedRoles" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $role->id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $role->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $role->slug }}
                    </td>
                    <td class="px-6 py-4">
                        @foreach($role->permissions as $permission)
                            <span class="bg-blue-100 text-blue-600 dark:bg-blue-500 dark:text-white px-2 py-1 rounded-full text-xs">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4">
                        {{ $role->description }}
                    </td>
                    <td class="px-6 py-4 text-end">
                        <button wire:click="openEditModal({{ $role->id }})" class="text-blue-600 hover:text-blue-900" title="Editar {{ $role->name }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 hover:text-blue-700">
                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                            </svg>
                        </button>
                        <button wire:click="openViewModal({{ $role->id }})" class="text-yellow-400 hover:text-yellow-500" title="Detalhes de {{ $role->name }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button wire:click="delete({{ $role->id }})" onclick="confirm('Tem certeza que deseja excluir a permissão {{ $role->name }}?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-900" title="Remover {{ $role->name }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 hover:text-red-700">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-4 px-3">
        <div class="flex">
            <div class="flex space-x-4 items-center mb-3">
                <label class="w-20 text-sm font-medium text-gray-900 dark:text-gray-200">
                    Por página
                </label>
                <select
                    wire:model.live="perPage"
                    class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-blue-500"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        {{ $roles->links() }}
    </div>
    @if($showModal)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 dark:bg-gray-700 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="{{ $editMode ? 'updateRole' : 'createRole' }}">
                        <div class="bg-white dark:bg-gray-700 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200" id="modal-title">
                                        @if($editMode)
                                            Editar Função
                                        @elseif($viewMode)
                                            Detalhes da Função
                                        @else
                                            Nova Função
                                        @endif
                                    </h3>
                                    <hr>
                                    <div class="mt-2">
                                        <div>
                                            <div class="mb-4">
                                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome</label>
                                                <input wire:model.defer="{{ !$viewMode || !$editMode ? 'name' : '' }}" type="text" name="name" id="name" class="dark:bg-gray-700 text-gray-200 mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $viewMode ? 'cursor-not-allowed' : ' ' }}" @if($viewMode) disabled @endif placeholder="Nome Completo">
                                                @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
                                            </div>
                                            @if ($viewMode)
                                                <div class="mb-4">
                                                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Slug</label>
                                                    <input wire:model.defer="{{ !$viewMode || !$editMode ? 'slug' : '' }}" type="text" name="slug" id="slug" class="dark:bg-gray-700 text-gray-200 mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $viewMode ? 'cursor-not-allowed' : ' ' }}" @if($viewMode) disabled @endif placeholder="example@example.com">
                                                    @error('slug') <span class="text-red-600">{{ $message }}</span> @enderror
                                                </div>
                                            @endif
                                            <div class="mb-4">
                                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Descrição</label>
                                                <textarea wire:model.defer="description" type="text" name="description" id="description" class="dark:bg-gray-700 text-gray-200 mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $viewMode ? 'cursor-not-allowed' : ' ' }}" @if($viewMode) disabled @endif placeholder="{{ $editMode ? '' : 'Breve descrição da Permissão' }}"></textarea>
                                                @error('description') <span class="text-red-600">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Permissões</label>
                                                <select wire:model="selectedPermissions" multiple id="permissions" name="permissions[]" class="dark:bg-gray-700 text-gray-200 mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $viewMode ? 'cursor-not-allowed' : '' }}" @if($viewMode) disabled @endif>
                                                    @foreach($permissions as $permission)
                                                        <option value="{{ $permission->id }}" {{ in_array($permission->id, $selectedPermissions) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('selectedPermissions') <span class="text-red-600">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            @if($viewMode)
                                <button type="button" wire:click="closeModal" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Fechar
                                </button>
                            @else
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    @if($editMode)
                                        Atualizar
                                    @else
                                        Salvar
                                    @endif
                                </button>
                                <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>
