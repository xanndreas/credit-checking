<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDebtorInformationRequest;
use App\Http\Requests\UpdateDebtorInformationRequest;
use App\Http\Resources\Admin\DebtorInformationResource;
use App\Models\DebtorInformation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DebtorInformationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('debtor_information_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DebtorInformationResource(DebtorInformation::with(['auto_planner_information'])->get());
    }

    public function store(StoreDebtorInformationRequest $request)
    {
        $debtorInformation = DebtorInformation::create($request->all());

        return (new DebtorInformationResource($debtorInformation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DebtorInformation $debtorInformation)
    {
        abort_if(Gate::denies('debtor_information_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DebtorInformationResource($debtorInformation->load(['auto_planner_information']));
    }

    public function update(UpdateDebtorInformationRequest $request, DebtorInformation $debtorInformation)
    {
        $debtorInformation->update($request->all());

        return (new DebtorInformationResource($debtorInformation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DebtorInformation $debtorInformation)
    {
        abort_if(Gate::denies('debtor_information_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $debtorInformation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
