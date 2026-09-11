<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $this->search . '%'
                    )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . $this->search . '%'
                        );
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}
