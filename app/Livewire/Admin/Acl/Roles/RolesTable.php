<?php

namespace App\Livewire\Admin\Acl\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RolesTable extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';
    #[Url]
    public int $perPage = 5;
    #[Url(history: true)]
    public string $sortField = 'id';
    #[Url(history: true)]
    public string $sortDirection = 'desc';
    public array $selectedRoles = [];

    public bool $showModal = false;
    public bool $editMode = false;
    public bool $viewMode = false;
    public int $selectedRoleId;
    public bool $selectAll = false;

    public ?string $name = null;
    public ?string $slug = null;
    public ?string $description = null;
    public array $selectedPermissions = [];


    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedRoles = $this->roles->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedRoles = [];
        }
    }

    public function delete(Role $role): void
    {
        if ($role->users()->count() > 0) {
            flash()->addError('A função não pode ser excluída porque está vinculada a uma ou mais usuários.');
        } else {
            $role->delete();
            flash()->addSuccess('Função deletada com sucesso!');
        }
    }

    public function deleteSelectedRoles(): void
    {
        Role::whereIn('id', $this->selectedRoles)->delete();
        $this->selectedRoles = [];
        $this->selectAll = false;
        flash()->addSuccess('Funções deletadas com sucesso!');

    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'slug', 'description']);

        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = false;
    }

    public function openEditModal($roleId): void
    {
        $role = Role::findOrFail($roleId);
        $this->selectedRoleId = $roleId;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->showModal = true;
        $this->editMode = true;
        $this->viewMode = false;
    }

    public function openViewModal($roleId): void
    {
        $role = Role::findOrFail($roleId);
        $this->selectedRoleId = $roleId;
        $this->name = $role->name;
        $this->slug = $role->slug;
        $this->description = $role->description;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'editMode', 'viewMode', 'selectedRoleId']);
    }

    public function createRole(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'O nome informado já está em uso.',
        ]);

        $role = Role::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        flash()->addSuccess('Função criada com sucesso!');

        $this->closeModal();
    }

    public function updateRole(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->selectedRoleId,
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'O nome informado já está em uso.',
        ]);

        $role = Role::findOrFail($this->selectedRoleId);
        $role->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        flash()->addSuccess('Função atualizada com sucesso!');

        $this->closeModal();
    }

    public function render(): View
    {
        $roles = Role::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        $permissions = Permission::all();
        return view('livewire.admin.acl.roles.roles-table', compact('roles', 'permissions'));
    }
}
