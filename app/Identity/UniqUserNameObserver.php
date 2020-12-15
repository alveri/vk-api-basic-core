<?php


namespace App\Identity;

use App\Identity\Models\User;
use Illuminate\Support\Str;

class UniqUserNameObserver
{
    private function isUsed($username): bool
    {
        return User::query()
                ->take(1)
                ->where([
                    'username' => $username,
                ])
                ->count() > 0;
    }

    public function saving(User $user)
    {
        if ($user->exists) {
            return;
        }

        $username = $user->username;

        while ($this->isUsed($user->username)) {
            $user->username = $username . '_' . Str::random(6);
        }
    }
}
