<?php

namespace App\Projects\Controllers;

use DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Core\Facades\DBHelper;
use App\Projects\Requests\ValidProjectRequest;
use App\Projects\Project;
use App\Projects\ProjectMember;
use App\Projects\Repositories\ProjectMembersRepository;
use App\Projects\Repositories\ProjectRepository;
use App\Core\Http\Responses\SuccessResponse;
use Illuminate\Http\Response;

class ProjectResource extends Controller
{
    /**
     * @var ProjectRepository
     */
    private ProjectRepository $repository;

    /**
     * @var ProjectMembersRepository
     */
    private ProjectMembersRepository $membersRepository;

    public function __construct(ProjectRepository $repository, ProjectMembersRepository $projectMembersRepository)
    {
        $this->repository = $repository;
        $this->membersRepository = $projectMembersRepository;
        $this->middleware('auth');
    }

    public function index(): Response
    {
        $projects = $this->repository->all();
        return $projects;
    }

    public function show($projectId): Response
    {
        $project = $this->repository->find($projectId);
        return $project;
    }

    public function update(ValidProjectRequest $request, $id): Response
    {
        $project = DBHelper::transactionOrFail(function () use ($request, $id) {
            $project = $this->repository->update($request->all(), $id);
            return $project;
        });
        return SuccessResponse::json();
    }
}
