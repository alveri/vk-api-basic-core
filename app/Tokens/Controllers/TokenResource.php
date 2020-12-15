<?php


namespace App\Tokens\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use URL;
use DB;
use Session;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuth;
use VK\OAuth\Scopes\VKOAuthGroupScope;
use VK\OAuth\VKOAuthResponseType;
use App\Core\Facades\DBHelper;
use App\Tokens\Requests\ValidTokenRequest;
use App\Tokens\Token;
use App\Projects\ProjectMember;
use App\Tokens\Repositories\TokenRepository;
use App\Tokens\Exceptions\VkGroupCodeException;
use App\Core\Http\Responses\SuccessResponse;
use Illuminate\Http\Response;

class TokenResource extends Controller
{
    /**
     * @var TokenRepository
     */
    private TokenRepository $repository;

    public function __construct(TokenRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth');
    }

    public function update(ValidTokenRequest $request, int $id): Response
    {
        $token = DBHelper::transactionOrFail(function () use ($request, $id) {
            $projectUpdate = $this->repository->update($request->all(), $id);
            return $projectUpdate;
        });

        return SuccessResponse::json();
    }

    public function delete(int $id): Response
    {
        $tokenDelete = DBHelper::transactionOrFail(function () use ($id) {
            return($this->repository->delete($id));
        });
        return SuccessResponse::json();
    }
}
