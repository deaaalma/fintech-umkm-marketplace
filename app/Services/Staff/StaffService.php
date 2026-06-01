<?php

namespace App\Services\Staff;

use App\Models\User;
use App\Models\UmkmWorker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffService
{
    public function create(array $data, $profilePicture = null)
    {
        return DB::transaction(function () use ($data, $profilePicture) {
            $user = User::where('email', $data['email'])->first();

            $profilePicturePath = null;
            if ($profilePicture) {
                $profilePicturePath = $profilePicture->store('profile-photos', 'public');
            }

            if (!$user) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'role' => 'worker',
                    'profile_photo_path' => $profilePicturePath,
                    'nik' => $data['nik'] ?? null,
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                ]);
            } else {
                // Update existing user with provided data if they are missing
                $user->update(array_filter([
                    'phone' => $user->phone ?: $data['phone'],
                    'nik' => $user->nik ?: ($data['nik'] ?? null),
                    'date_of_birth' => $user->date_of_birth ?: ($data['date_of_birth'] ?? null),
                    'profile_photo_path' => $user->profile_photo_path ?: $profilePicturePath,
                ]));

                if ($user->role === 'customer') {
                    $user->update(['role' => 'worker']);
                }
            }

            return UmkmWorker::create([
                'umkm_id' => $data['umkm_id'],
                'user_id' => $user->id,
                'specialization' => $data['specialization'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'permissions' => $data['permissions'] ?? [],
                'joined_at' => now(),
            ]);
        });
    }

    public function update(UmkmWorker $worker, array $data, $profilePicture = null)
    {
        return DB::transaction(function () use ($worker, $data, $profilePicture) {
            $user = $worker->user;

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'nik' => $data['nik'] ?? $user->nik,
                'date_of_birth' => $data['date_of_birth'] ?? $user->date_of_birth,
            ];

            if (isset($data['password']) && $data['password']) {
                $userData['password'] = Hash::make($data['password']);
            }

            if ($profilePicture) {
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                $userData['profile_photo_path'] = $profilePicture->store('profile-photos', 'public');
            }

            $user->update($userData);

            $worker->update([
                'specialization' => $data['specialization'] ?? $worker->specialization,
                'is_active' => $data['is_active'] ?? $worker->is_active,
                'permissions' => $data['permissions'] ?? $worker->permissions,
            ]);

            return $worker;
        });
    }

    public function delete(UmkmWorker $worker)
    {
        return DB::transaction(function () use ($worker) {
            $user = $worker->user;

            if ($user && $user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $worker->delete();
            if ($user) {
                $user->delete();
            }
        });
    }
}
