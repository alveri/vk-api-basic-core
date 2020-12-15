<?php

namespace App\CallbackServer\Controllers\Commands;

use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\CallbackServer\Repositories\CallbackServerRepository;
use App\CallbackServer\Events\CallbackServerConfirmationEvent;
use App\Common\Events\ProjectEvent;
use App\Common\DTO\HttpEvent;
use App\CallbackServer\Exceptions\CallbackServerNotExistException;

class CallbackController extends Controller
{
    /**
     * @var CallbackServerRepository
     */
    private CallbackServerRepository $callbackServerRepository;

    public function __construct(CallbackServerRepository $callbackServerRepository)
    {
        $this->callbackServerRepository = $callbackServerRepository;
        // TODO Why is it here ?
        $this->callbackServerRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->middleware('accept-json');
    }

    public function callback(Request $request, string $code, string $provider): void
    {
        // TODO (late): cache response
        $callbackServer = $this->callbackServerRepository->findByField('code',$code)->first();
        if( is_null($callbackServer) ) {
            throw new CallbackServerNotExistException();
        }

        if( $request->input('type') == 'confirmation' ) {
            event(new CallbackServerConfirmationEvent($callbackServer) );
            return;
        }

        $headers = $request->headers->all();
        $httpEvent = new HttpEvent($headers,$request->getContent(), $request->fullUrl());
        event(new ProjectEvent($callbackServer->projectId, $httpEvent, $provider));

    }



}
