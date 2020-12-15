<?php

namespace App\Engine\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Core\Facades\DBHelper;
use App\Core\Http\Responses\SuccessResponse;
use App\Engine\Repositories\EventFilterRepository;
use App\Engine\Requests\ValidEventFilterRequest;
use App\Engine\PluginEngine;
use Illuminate\Container\Container;
use Illuminate\Http\Response;

// TODO (late): security checks
class EventFilterResource extends Controller
{
    /**
     * @var EventFilterRepository
     */
    private EventFilterRepository $repository;

    /**
     * @var PluginEngine
     */
    private PluginEngine $pluginEngine;


    public function __construct(EventFilterRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->middleware('auth');
    }

    public function index(): Response
    {
        $eventFilters = $this->repository->all();
        return $eventFilters;
    }

    public function store(ValidEventFilterRequest $request): Response
    {
        $eventFilter = DBHelper::transactionOrFail(function () use ($request) {
            $data = $request->all();
            $eventFilter = $this->repository->create(array_merge($request->all(), ['data'=> $data]));
            return $eventFilter;
        });
        $eventProvider = $request->input('eventProvider');
        $eventPlugin = \App::makeWith(PluginEngine::class, ['provider' => $eventProvider]);
        $eventPlugin->plugin->eventFilterCreated($eventFilter);
        return SuccessResponse::json(['eventFilterId' => $eventFilter->id]);
    }

    public function show(int $id): Response
    {
        $eventFilter = $this->repository->find($id);
        return $eventFilter;
    }

    public function update(ValidEventFilterRequest $request, $id): Response
    {
        $eventFilter = DBHelper::transactionOrFail(function () use ($request, $id) {
            $data = $request->all();
            $eventFilter = $this->repository->update(array_merge($request->all(), ['data'=> $data]), $id);
            return $eventFilter;
        });
        return SuccessResponse::json();
    }

    public function destroy(int $id): Response
    {
        $eventFilter = $this->repository->find($id);
        $eventProvider = $eventFilter->data['eventProvider'];
        $eventPlugin = \App::makeWith(PluginEngine::class, ['provider' => $eventProvider]);
        $eventPlugin->plugin->eventFilterRemoved($eventFilter);
        $eventFilter = DBHelper::transactionOrFail(function () use ($id) {
            $this->repository->delete($id);
            return true;
        });



        return SuccessResponse::json();
    }

}
