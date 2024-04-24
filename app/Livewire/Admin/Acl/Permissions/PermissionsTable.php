<?php

namespace App\Livewire\Admin\Acl\Permissions;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionsTable extends Component
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
    public array $selectedPermissions = [];

    public bool $showModal = false;
    public bool $editMode = false;
    public bool $viewMode = false;
    public int $selectedPermissionId;
    public bool $selectAll = false;

    public ?string $name = null;
    public ?string $slug = null;
    public ?string $description = null;


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
            $this->selectedPermissions = $this->permissions->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }

    public function delete(Permission $permission): void
    {
        if ($permission->roles()->count() > 0) {
            flash()->addError('A permissão não pode ser excluída porque está vinculada a uma ou mais funções.');
        } else {
            $permission->delete();
            flash()->addSuccess('Permissão deletada com sucesso!');
        }
    }

    public function deleteSelectedPermissions(): void
    {
        Permission::whereIn('id', $this->selectedPermissions)->delete();
        $this->selectedPermissions = [];
        $this->selectAll = false;
        flash()->addSuccess('Permissões deletadas com sucesso!');

    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'slug', 'description']);
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = false;
    }

    public function openEditModal($permissionId): void
    {
        $permission = Permission::findOrFail($permissionId);
        $this->selectedPermissionId = $permissionId;
        $this->name = $permission->name;
        $this->description = $permission->description;
        $this->showModal = true;
        $this->editMode = true;
        $this->viewMode = false;
    }

    public function openViewModal($permissionId): void
    {
        $permission = Permission::findOrFail($permissionId);
        $this->selectedPermissionId = $permissionId;
        $this->name = $permission->name;
        $this->slug = $permission->slug;
        $this->description = $permission->description;
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'editMode', 'viewMode', 'selectedPermissionId']);
    }

    public function createPermission(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'O nome informado já está em uso.',
        ]);

        Permission::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        flash()->addSuccess('Permissão criada com sucesso!');

        $this->closeModal();
    }

    public function updatePermission(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->selectedPermissionId,
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'O nome informado já está em uso.',
        ]);

        $permission = Permission::findOrFail($this->selectedPermissionId);
        $permission->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        flash()->addSuccess('Permissão atualizada com sucesso!');

        $this->closeModal();
    }

    public function render(): View
    {
        $permissions = Permission::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.admin.acl.permissions.permissions-table', compact('permissions'));
    }
}
