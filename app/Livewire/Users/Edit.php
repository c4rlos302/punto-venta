<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public User $user;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = 'seller';

    public bool $active = true;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->active = $user->active;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $this->user->id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,seller',
            ],

            'active' => [
                'boolean',
            ],
        ];
    }

    public function save()
    {
        $this->validate();

        if (
            $this->user->isAdmin()
            && (
                $this->role !== 'admin'
                || ! $this->active
            )
        ) {
            $otherAdmins = User::query()
                ->where('role', 'admin')
                ->where('id', '!=', $this->user->id)
                ->where('active', true)
                ->exists();

            if (! $otherAdmins) {
                $this->addError(
                    'role',
                    'No puedes dejar el sistema sin un administrador activo.'
                );

                return;
            }
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'active' => $this->active,
        ];

        if ($this->password !== '') {
            $data['password'] = $this->password;
        }

        $this->user->update($data);

        session()->flash(
            'success',
            'Usuario actualizado correctamente.'
        );

        return $this->redirect(
            route('users.index'),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
