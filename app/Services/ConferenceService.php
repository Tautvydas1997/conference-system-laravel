<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ConferenceService
{
    private Collection $conferences;
    private Collection $registrations;
    private int $nextId;

    /**
     * Initialize ConferenceService with sample data
     */
    public function __construct()
    {
        $this->conferences = collect([
            [
                'id' => 1,
                'name' => 'PHP Developer Conference 2024',
                'description' => 'Metinė PHP programuotojų konferencija',
                'lecturers' => 'Jonas Jonaitis, Petras Petraitis',
                'date' => '2024-12-15',
                'time' => '10:00',
                'address' => 'Vilnius, Konferencijų centras, Gedimino pr. 1',
                'status' => 'planned',
            ],
            [
                'id' => 2,
                'name' => 'Web Technologies Summit',
                'description' => 'Šiuolaikinių web technologijų konferencija',
                'lecturers' => 'Marija Marijaitė, Tomas Tomaitis',
                'date' => '2024-11-20',
                'time' => '14:00',
                'address' => 'Kaunas, Tech Hub, Laisvės al. 55',
                'status' => 'completed',
            ],
            [
                'id' => 3,
                'name' => 'Laravel Framework Workshop',
                'description' => 'Praktinis Laravel framework mokymasis',
                'lecturers' => 'Andrius Andriukaitis',
                'date' => '2025-01-10',
                'time' => '09:00',
                'address' => 'Vilnius, Code Academy, Vokiečių g. 5',
                'status' => 'planned',
            ],
        ]);

        $this->registrations = collect([
            ['id' => 1, 'conference_id' => 2, 'user_id' => 1],
            ['id' => 2, 'conference_id' => 2, 'user_id' => 2],
        ]);

        $this->nextId = 4;
    }

    public function all(): Collection
    {
        return $this->conferences;
    }

    public function find(int $id): ?array
    {
        return $this->conferences->firstWhere('id', $id);
    }

    public function create(array $data): array
    {
        $conference = [
            'id' => $this->nextId++,
            'name' => $data['name'],
            'description' => $data['description'],
            'lecturers' => $data['lecturers'],
            'date' => $data['date'],
            'time' => $data['time'],
            'address' => $data['address'],
            'status' => $data['status'] ?? 'planned',
        ];

        $this->conferences->push($conference);

        return $conference;
    }

    public function update(int $id, array $data): ?array
    {
        $index = $this->conferences->search(function ($conference) use ($id) {
            return $conference['id'] === $id;
        });

        if ($index === false) {
            return null;
        }

        $conference = $this->conferences[$index];
        $conference['name'] = $data['name'];
        $conference['description'] = $data['description'];
        $conference['lecturers'] = $data['lecturers'];
        $conference['date'] = $data['date'];
        $conference['time'] = $data['time'];
        $conference['address'] = $data['address'];

        if (isset($data['status'])) {
            $conference['status'] = $data['status'];
        }

        $this->conferences[$index] = $conference;

        return $conference;
    }

    public function delete(int $id): bool
    {
        $conference = $this->find($id);

        if (!$conference) {
            return false;
        }

        // Cannot delete completed conferences
        if ($conference['status'] === 'completed') {
            return false;
        }

        $this->conferences = $this->conferences->reject(function ($conference) use ($id) {
            return $conference['id'] === $id;
        });

        // Remove related registrations
        $this->registrations = $this->registrations->reject(function ($registration) use ($id) {
            return $registration['conference_id'] === $id;
        });

        return true;
    }

    public function getPlanned(): Collection
    {
        return $this->conferences->where('status', 'planned');
    }

    public function registerUser(int $conferenceId, int $userId): bool
    {
        // Check if already registered
        $existing = $this->registrations->first(function ($registration) use ($conferenceId, $userId) {
            return $registration['conference_id'] === $conferenceId && $registration['user_id'] === $userId;
        });

        if ($existing) {
            return false;
        }

        $registrationId = $this->registrations->max('id') + 1;
        $this->registrations->push([
            'id' => $registrationId,
            'conference_id' => $conferenceId,
            'user_id' => $userId,
        ]);

        return true;
    }

    public function getRegisteredUsers(int $conferenceId): Collection
    {
        $registrationIds = $this->registrations
            ->where('conference_id', $conferenceId)
            ->pluck('user_id');

        return $registrationIds;
    }

    public function isUserRegistered(int $conferenceId, int $userId): bool
    {
        return $this->registrations->contains(function ($registration) use ($conferenceId, $userId) {
            return $registration['conference_id'] === $conferenceId && $registration['user_id'] === $userId;
        });
    }
}

