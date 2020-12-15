<?php

namespace App\Projects\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Projects\Repositories\ProjectMembersRepository;
use App\Core\Facades\DBHelper;
use App\Projects\Requests\ValidProjectMemberRequest;
use Illuminate\Http\Response;

class ProjectMemberResource extends Controller
{
    /**
     * @var ProjectMembersRepository
     */
    private ProjectMembersRepository $membersRepository;

    public function __construct(ProjectMembersRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth');
    }

    public function index()
    {
        $projectMembers = $this->repository->all();
        return $projectMembers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidProjectMemberRequest $request): Response
    {
        $projectMember = DBHelper::transactionOrFail(function () use ($request) {
            $projectMember = $this->repository->create($request->all());
            return $projectMember;
        });
        return SuccessResponse::json(['projectMemberId' => $projectMember->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): Response
    {
        $projectMember = $this->repository->find(id);
        return $projectMember;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidProjectMemberRequest $request, $id): Response
    {
        $projectMember = DBHelper::transactionOrFail(function () use ($request, $id) {
            $projectMember = $this->repository->update($request->all(), $id);
            return $projectMember;
        });
        return SuccessResponse::json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): Response
    {
        $projectMember = DBHelper::transactionOrFail(function () use ($id) {
            $this->repository->delete($id);
            return true;
        });
        return SuccessResponse::json();
    }
}
