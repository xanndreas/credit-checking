<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDealerInformationRequest;
use App\Http\Requests\UpdateDealerInformationRequest;
use App\Http\Resources\Admin\DealerInformationResource;
use App\Models\DealerInformation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealerInformationApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('dealer_information_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealerInformationResource(DealerInformation::with(['dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information'])->get());
    }

    public function store(StoreDealerInformationRequest $request)
    {
        $dealerInformation = DealerInformation::create($request->all());

        foreach ($request->input('id_photos', []) as $file) {
            $dealerInformation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('id_photos');
        }

        return (new DealerInformationResource($dealerInformation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DealerInformationResource($dealerInformation->load(['dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information']));
    }

    public function update(UpdateDealerInformationRequest $request, DealerInformation $dealerInformation)
    {
        $dealerInformation->update($request->all());

        if (count($dealerInformation->id_photos) > 0) {
            foreach ($dealerInformation->id_photos as $media) {
                if (! in_array($media->file_name, $request->input('id_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $dealerInformation->id_photos->pluck('file_name')->toArray();
        foreach ($request->input('id_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $dealerInformation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('id_photos');
            }
        }

        return (new DealerInformationResource($dealerInformation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DealerInformation $dealerInformation)
    {
        abort_if(Gate::denies('dealer_information_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dealerInformation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
