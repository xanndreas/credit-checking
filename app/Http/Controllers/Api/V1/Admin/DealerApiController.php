<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Http\Resources\Admin\DealerResource;
use App\Models\Dealer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dealer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealerResource(Dealer::all());
    }

    public function store(StoreDealerRequest $request)
    {
        $dealer = Dealer::create($request->all());

        return (new DealerResource($dealer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Dealer $dealer)
    {
        abort_if(Gate::denies('dealer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealerResource($dealer);
    }

    public function update(UpdateDealerRequest $request, Dealer $dealer)
    {
        $dealer->update($request->all());

        return (new DealerResource($dealer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Dealer $dealer)
    {
        abort_if(Gate::denies('dealer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
