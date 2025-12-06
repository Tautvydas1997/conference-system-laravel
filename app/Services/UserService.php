<?php

namespace App\Services;

use Illuminate\Support\Collection;

class UserService
{
    private Collection $users;
    private int $nextId;

    public function __construct()
    {
        $this->users = collect([
            [
                'id' => 1,
                'first_name' => 'Jonas',
                'last_name' => 'Jonaitis',
                'email' => 'jonas@example.com',
                'role' => 'client',
            ],
            [
                'id' => 2,
                'first_name' => 'Petras',
                'last_name' => 'Petraitis',
                'email' => 'petras@example.com',
                'role' => 'client',
            ],
            [
                'id' => 3,
                'first_name' => 'Marija',
                'last_name' => 'Marijaitė',
                'email' => 'marija@example.com',
                'role' => 'employee',
            ],
            [
                'id' => 4,
                'first_name' => 'Admin',
                'last_name' => 'Administratorius',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ],
        ]);

        $this->nextId = 5;
    }

    public function all(): Collection
    {
        return $this->users;
    }

    public function find(int $id): ?array
    {
        return $this->users->firstWhere('id', $id);
    }

    public function update(int $id, array $data): ?array
    {
        $index = $this->users->search(function ($user) use ($id) {
            return $user['id'] === $id;
        });

        if ($index === false) {
            return null;
        }

        $user = $this->users[$index];
        $user['first_name'] = $data['first_name'];
        $user['last_name'] = $data['last_name'];
        $user['email'] = $data['email'];

        $this->users[$index] = $user;

        return $user;
    }

    public function getByRole(string $role): Collection
    {
        return $this->users->where('role', $role);
    }
}

