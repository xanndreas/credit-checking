<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAutoPlannerRequest;
use App\Http\Requests\UpdateAutoPlannerRequest;
use App\Http\Resources\Admin\AutoPlannerResource;
use App\Models\AutoPlanner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoPlannerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('auto_planner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutoPlannerResource(AutoPlanner::with(['auto_planner_name'])->get());
    }

    public function store(StoreAutoPlannerRequest $request)
    {
        $autoPlanner = AutoPlanner::create($request->all());

        return (new AutoPlannerResource($autoPlanner))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AutoPlanner $autoPlanner)
    {
        abort_if(Gate::denies('auto_planner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutoPlannerResource($autoPlanner->load(['auto_planner_name']));
    }

    public function update(UpdateAutoPlannerRequest $request, AutoPlanner $autoPlanner)
    {
        $autoPlanner->update($request->all());

        return (new AutoPlannerResource($autoPlanner))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AutoPlanner $autoPlanner)
    {
        abort_if(Gate::denies('auto_planner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autoPlanner->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
