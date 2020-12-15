<?php


namespace App\Identity\Controllers;

use App\Core\Facades\DBHelper;
use App\Identity\Models\Connection;
use App\Identity\Models\User;
use App\Identity\ConnectionRepository;
use App\Identity\Exceptions\VkLoginException;
use Auth;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Request;
use Session;
use Socialite;
use SocialiteProviders\VKontakte\Provider;
use Str;
use URL;
use Illuminate\Http\Response;
use function abort;

class VkLoginController extends Controller
{
    const REDIRECT_SESSION_KEY = 'REDIRECT_EXTERNAL_URL';

    /**
     * @var TokenRepository
     */
    private TokenRepository $repository;

    public function __construct(ConnectionRepository $connectionRepository)
    {
        $this->connectionRepository = $connectionRepository;
    }

    /**
     * @return Provider
     */
    private function socialiteDriver(): Provider
    {
        $redirectUrl = URL::route('vk-callback');

        return Socialite::driver('vkontakte')
            ->setScopes(['offline'])
            ->redirectUrl($redirectUrl);
    }

    public function redirect()
    {
        $extRedirect = Request::query('externalRedirect', '/');

        // TODO Unchecked redirect vulnerability

        Session::put(self::REDIRECT_SESSION_KEY, $extRedirect);

        return $this->socialiteDriver()->redirect();
    }

    public function callback(): Response
    {
        $oauthUser = $this->socialiteDriver()->user();

        if (!$oauthUser instanceof \SocialiteProviders\Manager\OAuth2\User) {
            throw new VkLoginException();
        }

        $user = DBHelper::transactionOrFail(function () use ($oauthUser) {
            $connection = $this->connectionRepository->firstOrNew(
                    [
                        'providerId' => $oauthUser->getId(),
                        'provider' => Connection::PROVIDER_VKONTAKTE,
                    ]
                );

            $user = null;

            if ($connection->exists) {
                $user = User::query()->find($connection->userId)->first();
            }

            if (is_null($user)) {
                $user = new User();
                $user->username = $oauthUser->nickname;
                $user->name = $oauthUser->name;
                $user->avatar = $oauthUser->avatar;
                $user->password = Str::random(32);
                $user->save();

                $connection->userId = $user->id;
            }

            $connection->token = $oauthUser->token;
            $connection->profile = $oauthUser->user;
            $connection->save();

            return $user;
        });

        Auth::login($user, true);

        // TODO Unchecked redirect vulnerability

        $extRedirect = Session::get(self::REDIRECT_SESSION_KEY, '/');

        return new RedirectResponse($extRedirect);
    }
}
