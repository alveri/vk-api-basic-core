<?php


namespace App\Identity;

use App\Identity\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use function abort;

class AuthUserProvider implements \Illuminate\Contracts\Auth\UserProvider
{

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $user = User::query()->find($identifier);
        return $user;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return User::query()
            ->where([
                ['id', $identifier],
                ['remember_token', $token]
            ])
            ->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        if (!$user instanceof User) {
            abort('400');
        }
        $user->setRememberToken($token);
        $user->update();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        abort('400');
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        abort('400');
    }
}
