<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenorRequest;
use App\Http\Requests\UpdateTenorRequest;
use App\Http\Resources\Admin\TenorResource;
use App\Models\Tenor;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenorsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tenor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TenorResource(Tenor::all());
    }

    public function store(StoreTenorRequest $request)
    {
        $tenor = Tenor::create($request->all());

        return (new TenorResource($tenor))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Tenor $tenor)
    {
        abort_if(Gate::denies('tenor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TenorResource($tenor);
    }

    public function update(UpdateTenorRequest $request, Tenor $tenor)
    {
        $tenor->update($request->all());

        return (new TenorResource($tenor))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Tenor $tenor)
    {
        abort_if(Gate::denies('tenor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenor->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
