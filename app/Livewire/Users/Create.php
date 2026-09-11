<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = 'seller';

    public bool $active = true;

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
                'unique:users,email',
            ],

            'password' => [
                'required',
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

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'active' => $this->active,
        ]);

        session()->flash(
            'success',
            'Usuario creado correctamente.'
        );

        return $this->redirect(
            route('users.index'),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
