<?php

namespace App\Livewire\Admin\Departments;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentsTable extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';
    #[Url(history: true)]
    public string $sortField = 'id';
    #[Url(history: true)]
    public string $sortDirection = 'desc';
    #[Url(history: true)]
    public int $perPage = 5;

    public array $selectedDepartments = [];
    public int $selectedDepartmentId;

    public bool $showModal = false;
    public bool $editMode = false;
    public bool $viewMode = false;
    public bool $selectAll = false;

    public ?string $image = null;
    public ?string $name = null;
    public ?string $responsible_id = null;
    public ?string $parent_id = null;
    public ?string $author_id = null;
    public ?string $order = null;
    public ?string $slug = null;
    public ?string $summary = null;
    public ?string $description = null;
    public ?string $is_active = null;
    public ?string $card_color = null;

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
            $this->selectedDepartments = $this->departments->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->selectedDepartments = [];
        }
    }

    public function openCreateModal(): void
    {
        $this->reset(['image', 'name', 'responsible_id', 'parent_id', 'author_id', 'order', 'slug', 'summary', 'description', 'is_active', 'card_color', 'selectedDepartments']);
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = false;
    }

    public function openViewModal($departmentId): void
    {
        $this->resetValidation();
        $this->reset(['image', 'name', 'responsible_id', 'parent_id', 'author_id', 'order', 'slug', 'summary', 'description', 'is_active', 'card_color', 'selectedDepartments']);

        $department = Department::with('parent', 'children', 'users', 'responsible')->findOrFail($departmentId);
        $this->selectedDepartmentId = $departmentId;
        $this->name = $department->name;
        $this->responsible_id = $department->responsible_id;
        $this->parent_id = $department->parent_id;
        $this->author_id = $department->author_id;
        $this->order = $department->order;
        $this->slug = $department->slug;
        $this->summary = $department->summary;
        $this->description = $department->description;
        $this->is_active = $department->is_active;
        $this->card_color = $department->card_color;

        $this->showModal = true;
        $this->viewMode = true;
        $this->editMode = false;
    }

    public function openEditModal($departmentId): void
    {
        $this->resetValidation();
        $this->reset(['image', 'name', 'responsible_id', 'parent_id', 'author_id', 'order', 'slug', 'summary', 'description', 'is_active', 'card_color', 'selectedDepartments']);

        $department = Department::with('parent', 'children', 'users', 'responsible')->findOrFail($departmentId);
        $this->selectedDepartmentId = $departmentId;
        $this->name = $department->name;
        $this->responsible_id = $department->responsible_id;
        $this->parent_id = $department->parent_id;
        $this->author_id = $department->author_id;
        $this->order = $department->order;
        $this->slug = $department->slug;
        $this->summary = $department->summary;
        $this->description = $department->description;
        $this->is_active = $department->is_active;
        $this->card_color = $department->card_color;

        $this->showModal = true;
        $this->editMode = true;
        $this->viewMode = false;
    }

    public function createDepartment(): void
    {
        $this->validate([
            'image' => 'required|image|max:1024',
            'name' => 'required|string|unique:departments,name',
            'responsible_id' => 'required|exists:users,id',
            'parent_id' => 'nullable|exists:departments,id',
            'order' => 'required|string|unique:departments,order',
            'card_color' => 'nullable|hex_color',
            'is_active' => 'required|boolean',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',

        ],[
            'image.required' => 'A imagem é obrigatória',
            'image.image' => 'A imagem deve ser um arquivo de imagem',
            'image.max' => 'A imagem não pode ter mais de 1MB',
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser uma string',
            'name.unique' => 'O nome já está em uso',
            'responsible_id.required' => 'O responsável é obrigatório',
            'responsible_id.exists' => 'O responsável não existe',
            'parent_id.exists' => 'O departamento pai não existe',
            'order.required' => 'A ordem é obrigatória',
            'order.string' => 'A ordem deve ser uma string',
            'order.unique' => 'A ordem já está em uso',
            'card_color.hex_color' => 'A cor do cartão deve ser uma cor hexadecimal',
            'is_active.required' => 'O status é obrigatório',
            'is_active.boolean' => 'O status deve ser um booleano',
            'summary.string' => 'O resumo deve ser uma string',
            'description.string' => 'A descrição deve ser uma string',

        ]);

        $this->author_id = auth()->id();
        $this->slug = Str::slug($this->name);

        Department::create([
            'name' => $this->name,
            'responsible_id' => $this->responsible_id,
            'parent_id' => $this->parent_id,
            'author_id' => $this->author_id,
            'order' => $this->order,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        flash()->addSuccess('Departamento criado com sucesso!');

        $this->showModal = false;
    }

    public function updateDepartment(): void
    {
        $this->validate([
            'name' => 'required|string|unique:departments,name,' . $this->selectedDepartmentId,
            'responsible_id' => 'required|exists:users,id',
            'parent_id' => 'nullable|exists:departments,id',
            'order' => 'required|string|unique:departments,order,' . $this->selectedDepartmentId,
            'card_color' => 'nullable|hex_color',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ],[
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser uma string',
            'name.unique' => 'O nome já está em uso',
            'responsible_id.required' => 'O responsável é obrigatório',
            'responsible_id.exists' => 'O responsável não existe',
            'parent_id.exists' => 'O departamento pai não existe',
            'order.required' => 'A ordem é obrigatória',
            'order.string' => 'A ordem deve ser uma string',
            'order.unique' => 'A ordem já está em uso',
            'card_color.hex_color' => 'A cor do cartão deve ser uma cor hexadecimal',
            'summary.string' => 'O resumo deve ser uma string',
            'description.string' => 'A descrição deve ser uma string',
            'is_active.required' => 'O status é obrigatório',
            'is_active.boolean' => 'O status deve ser um booleano',
        ]);

        $department = Department::findOrFail($this->selectedDepartmentId);

        if ($this->name !== $department->name) {
            $this->slug = Str::slug($this->name);
        }

        $department->update([
            'name' => $this->name,
            'responsible_id' => $this->responsible_id,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'card_color' => $this->card_color,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        flash()->addSuccess('Departamento atualizado com sucesso!');

        $this->showModal = false;
    }

    public function delete(Department $department): void
    {
        if ($department->users->count() > 0) {
            flash()->addError('Não é possível excluir um departamento que possui usuários');
            return;
        }

        if ($department->children->count() > 0) {
            flash()->addError('Não é possível excluir um departamento que possui sub-departamentos');
            return;
        }

        $department->delete();
        flash()->addSuccess('Departamento excluído com sucesso!');
    }

    public function deleteSelectedDepartments(): void
    {
        $departments = Department::whereIn('id', $this->selectedDepartments)->get();

        foreach ($departments as $department) {
            if ($department->users->count() > 0) {
                flash()->addError('Não é possível excluir um departamento que possui usuários');
                return;
            }

            if ($department->children->count() > 0) {
                flash()->addError('Não é possível excluir um departamento que possui sub-departamentos');
                return;
            }
        }

        Department::whereIn('id', $this->selectedDepartments)->delete();
        $this->selectedDepartments = [];
        $this->selectAll = false;
        flash()->addSuccess('Departamentos selecionados excluídos com sucesso!');
    }

    public function closeModal(): void
    {
        $this->reset([
            'showModal',
            'editMode',
            'viewMode',
            'selectedDepartmentId',
            'selectedDepartments',
            'image',
            'name',
            'responsible_id',
            'parent_id',
            'author_id',
            'order',
            'card_color',
            'slug',
            'summary',
            'description',
            'is_active',
        ]);
    }

    public function render(): View
    {
        $departments = Department::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('users', 'responsible', 'parent')
            ->paginate($this->perPage);
        $users = User::all();
        return view('livewire.admin.departments.departments-table', compact('departments', 'users'));
    }
}
