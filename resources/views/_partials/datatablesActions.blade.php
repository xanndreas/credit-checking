@isset($otherDetailGate)
    @can($otherDetailGate)
        <a href="{{$otherDetailUrl}}" class="btn btn-sm btn-icon">
            <i class="text-primary ti ti-eye"></i>
        </a>
    @endcan
@endisset

@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
          onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <a onclick="$(this).parent().submit()" class="btn btn-sm btn-icon">
            <i class="text-primary ti ti-trash"></i>
        </a>
    </form>
@endcan


