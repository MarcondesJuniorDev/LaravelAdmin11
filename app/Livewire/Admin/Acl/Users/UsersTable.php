<?php

namespace App\Livewire\Admin\Acl\Users;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
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
    public string $sortField = 'id';
    #[Url(history: true)]
    public string $sortDirection = 'desc';
    public array $selectedUsers = [];

    public bool $showModal = false;
    public bool $editMode = false;
    public bool $viewMode = false;
    public int $selectedUserId;
    public bool $selectAll = false;

    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public array $selectedRoles = [];
    public ?string $image = null;
    public ?string $about = null;
    public ?string $featured_homepage = null;
    public ?string $status = null;
    public ?string $website = null;
    public ?string $lattes = null;
    public ?string $facebook = null;
    public ?string $twitter = null;
    public ?string $instagram = null;
    public ?string $linkedin = null;
    public ?string $github = null;


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
            $this->selectedUsers = $this->users->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'selectedRoles', 'image', 'about', 'featured_homepage', 'status', 'website', 'lattes', 'facebook', 'twitter', 'instagram', 'linkedin', 'github']);
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = false;
    }

    public function openViewModal($userId): void
    {
        $this->resetValidation();
        $this->reset(['selectedRoles', 'image', 'about', 'featured_homepage', 'status', 'website', 'lattes', 'facebook', 'twitter', 'instagram', 'linkedin', 'github']);

        $user = User::with('details', 'roles')->findOrFail($userId);
        $this->selectedUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->image = $user->details->image;
        $this->about = $user->details->about;
        $this->featured_homepage = $user->details->featured_homepage;
        $this->status = $user->details->status;
        $this->website = $user->details->website;
        $this->lattes = $user->details->lattes;
        $this->facebook = $user->details->facebook;
        $this->twitter = $user->details->twitter;
        $this->instagram = $user->details->instagram;
        $this->linkedin = $user->details->linkedin;
        $this->github = $user->details->github;
        $this->showModal = true;
        $this->editMode = false;
        $this->viewMode = true;
    }

    public function openEditModal($userId): void
    {
        $this->resetValidation();
        $this->reset(['selectedRoles', 'image', 'about', 'featured_homepage', 'status', 'website', 'lattes', 'facebook', 'twitter', 'instagram', 'linkedin', 'github']);

        $user = User::with('details', 'roles')->findOrFail($userId);
        $this->selectedUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = null;
        $this->password_confirmation = null;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->image = $user->details->image;
        $this->about = $user->details->about;
        $this->featured_homepage = $user->details->featured_homepage;
        $this->status = $user->details->status;
        $this->website = $user->details->website;
        $this->lattes = $user->details->lattes;
        $this->facebook = $user->details->facebook;
        $this->twitter = $user->details->twitter;
        $this->instagram = $user->details->instagram;
        $this->linkedin = $user->details->linkedin;
        $this->github = $user->details->github;
        $this->showModal = true;
        $this->editMode = true;
        $this->viewMode = false;
    }

    public function createUser(): void
    {
        $this->validate([
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'about' => 'nullable|string',
            'featured_homepage' => 'required|in:yes,no',
            'status' => 'required|in:active,inactive',
            'website' => 'nullable|url',
            'lattes' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
        ],[
            'image.image' => 'O campo imagem deve ser uma imagem válida.',
            'image.max' => 'O campo imagem deve ter no máximo 1MB.',
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
            'featured_homepage.required' => 'O campo destaque na homepage é obrigatório.',
            'featured_homepage.in' => 'O campo destaque na homepage deve ser sim ou não.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O campo status deve ser ativo ou inativo.',
            'website.url' => 'O campo website deve ser uma URL válida.',
            'lattes.url' => 'O campo lattes deve ser uma URL válida.',
            'facebook.url' => 'O campo facebook deve ser uma URL válida.',
            'twitter.url' => 'O campo twitter deve ser uma URL válida.',
            'instagram.url' => 'O campo instagram deve ser uma URL válida.',
            'linkedin.url' => 'O campo linkedin deve ser uma URL válida.',
            'github.url' => 'O campo github deve ser uma URL válida.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'image' => $this->image,
            'about' => $this->about,
            'featured_homepage' => $this->featured_homepage,
            'status' => $this->status,
            'website' => $this->website,
            'lattes' => $this->lattes,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
        ]);

        $user->roles()->sync($this->selectedRoles);

        flash()->addSuccess('Usuário criado com sucesso!');

        $this->closeModal();
    }

    public function updateUser(): void
    {
        $rules = [
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->selectedUserId,
            'about' => 'nullable|string',
            'featured_homepage' => 'required|in:yes,no',
            'status' => 'required|in:active,inactive',
            'website' => 'nullable|url',
            'lattes' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
        ];

        if (!empty($this->password)) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $this->validate($rules,[
            'image.image' => 'O campo imagem deve ser uma imagem válida.',
            'image.max' => 'O campo imagem deve ter no máximo 1MB.',
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
            'featured_homepage.required' => 'O campo destaque na homepage é obrigatório.',
            'featured_homepage.in' => 'O campo destaque na homepage deve ser sim ou não.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O campo status deve ser ativo ou inativo.',
            'website.url' => 'O campo website deve ser uma URL válida.',
            'lattes.url' => 'O campo lattes deve ser uma URL válida.',
            'facebook.url' => 'O campo facebook deve ser uma URL válida.',
            'twitter.url' => 'O campo twitter deve ser uma URL válida.',
            'instagram.url' => 'O campo instagram deve ser uma URL válida.',
            'linkedin.url' => 'O campo linkedin deve ser uma URL válida.',
            'github.url' => 'O campo github deve ser uma URL válida.',
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

        $userDetails = UserDetail::where('user_id', $user->id)->first();
        $userDetails->update([
            'image' => $this->image,
            'about' => $this->about,
            'featured_homepage' => $this->featured_homepage,
            'status' => $this->status,
            'website' => $this->website,
            'lattes' => $this->lattes,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
        ]);

        $user->roles()->sync($this->selectedRoles);

        flash()->addSuccess('Usuário atualizado com sucesso!');

        $this->closeModal();
    }

    public function delete(User $user): void
    {
        $user->delete();
        flash()->addSuccess('Usuário deletado com sucesso!');
    }

    public function deleteSelectedUsers(): void
    {
        User::whereIn('id', $this->selectedUsers)->delete();
        $this->selectedUsers = [];
        $this->selectAll = false;
        flash()->addSuccess('Usuários deletados com sucesso!');

    }

    public function closeModal(): void
    {
        $this->reset([
            'showModal',
            'editMode',
            'viewMode',
            'selectedUserId',
            'selectedRoles',
            'image',
            'about',
            'featured_homepage',
            'status',
            'website',
            'lattes',
            'facebook',
            'twitter',
            'instagram',
            'linkedin',
            'github'
        ]);
    }

    public function render(): View
    {
        $users = User::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('details', 'roles')
            ->paginate($this->perPage);
        $roles = Role::all();

        return view('livewire.admin.acl.users.users-table', compact('users', 'roles'));
    }
}
