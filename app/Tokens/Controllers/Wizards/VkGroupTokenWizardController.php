<?php


namespace App\Tokens\Controllers\Wizards;

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
use App\Tokens\Token;
use App\Tokens\ProjectLink;
use App\Tokens\Repositories\TokenRepository;
use App\Tokens\Events\TokenCreated;
use App\Core\Exceptions\VkApiException;
use App\Core\Http\Responses\SuccessResponse;
use App\Common\VKConstants;
use App\Projects\Repositories\ProjectRepository;
use App\Projects\Exceptions\ProjectNotExistException;
use Illuminate\Http\Response;

class VkGroupTokenWizardController extends Controller
{
    /**
     * @var TokenRepository
     */
    private TokenRepository $repository;

    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    public function __construct(TokenRepository $repository, ProjectRepository $projectRepository)
    {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->middleware('auth');
    }

    public function redirect(Request $request)
    {
        $projectId = $request->get('projectId');
        if(is_null( $this->projectRepository->find($projectId) )) {
            throw new ProjectNotExistException();
        }
        $oauth = new VKOAuth();
        $client_id = config('services.vkontakte.client_id');
        $redirect_uri = URL::route('vk-group-wizard-callback');
        $display = VKOAuthDisplay::PAGE;
        $scope = [VKOAuthGroupScope::MANAGE];
        $state = Str::random(20);
        Session::put('securityState', $state);
        Session::put('vkGroupId', $request->get('groupId'));
        Session::put('projectId', $request->get('projectId'));
        $groupsIds = [$request->get('groupId')];
        $browserUrl = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state, $groupsIds);
        return redirect($browserUrl);
    }


    public function callback(Request $request): Response
    {
        $state = $request->get('state');
        if ($state != Session::get('securityState')) {
            throw new VkApiException('Invalid security state');
        }
        $code = $request->get('code');
        $oauth = new VKOAuth();
        $client_id = config('services.vkontakte.client_id');
        $client_secret = config('services.vkontakte.client_secret');
        $redirect_uri = URL::route('vk-group-wizard-callback');
        $code = $code;

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);

        if (array_key_exists('error', $response)) {
            throw new VkApiException($response['error']);
        }
        $key = 'access_token_'.Session::get('vkGroupId');
        $result = DBHelper::transactionOrFail(function () use ($response, $key) {
            $result = [];
            $token = $this->repository->create([
                    'token' => $response[$key],
                    'provider' => VKConstants::VK_GROUP_PROVIDER,
                    'providerId' => Session::get('vkGroupId'),
                    'userId' => Auth::user()->id,
                ]);

            $projectLink = new ProjectLink;
            $projectLink->tokenId = $token->id;
            $projectLink->projectId = Session::get('projectId');
            $projectLink->save();

            $result['token'] = $token;
            $result['projectLink'] = $projectLink;
            return $result;
        });

        event(new TokenCreated($result['token'], $result['projectLink']));


        // todo implement checking for projectUser

        return SuccessResponse::json();
    }
}
