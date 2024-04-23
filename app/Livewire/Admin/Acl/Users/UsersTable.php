<?php

namespace App\Livewire\Admin\Acl\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';
    #[Url]
    public int $perPage = 5;
    #[Url(history: true)]
    public string $sortField = 'name';
    #[Url(history: true)]
    public string $sortDirection = 'desc';

    public bool $showModal = false;
    public bool $editMode = false;
    public bool $viewMode = false;
    public int $selectedUserId;

    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;


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

    public function delete(User $user): void
    {
        $user->delete();
        $this->dispatch('success', ['message' => 'Usuário deletado com sucesso!']);
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = false;
    }

    public function openEditModal($userId): void
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = null;
        $this->showModal = true;
        $this->editMode = true;
        $this->viewMode = false;
    }

    public function openViewModal($userId): void
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'editMode', 'viewMode', 'selectedUserId']);
    }

    public function createUser(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Usuário criado com sucesso!']);

        $this->closeModal();
    }

    public function updateUser(): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->selectedUserId,
        ];

        // Senha só é obrigatória se estiver sendo fornecida
        if (!empty($this->password)) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $this->validate($rules,[
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        $user = User::findOrFail($this->selectedUserId);
        $updatedData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $updatedData['password'] = bcrypt($this->password);
        }

        $user->update($updatedData);

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Usuário atualizado com sucesso!']);

        $this->closeModal();
    }

    public function render(): View
    {
        $users = User::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.acl.users.users-table', compact('users'));
    }
}
