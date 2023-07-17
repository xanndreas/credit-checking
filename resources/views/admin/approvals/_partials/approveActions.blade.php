@cannot($approveGate)
    <span
        class="badge {{$approvals ? ($approvals->status == 'Approved' ? 'bg-success' : 'bg-danger') : 'bg-warning'}}">{{ $approvals ? $approvals->status: 'Waiting'  }}</span>
@endcannot

@can($approveGate)
    @if(!$approvals)
        <button type="button" class="btn btn-danger waves-effect" data-bs-toggle="modal" data-bs-target="#reasonModal">
            <i class="tf-icons ti ti-x"></i>
        </button>

        <form action="{{ route('admin.approvals.approve') }}" method="POST"
              onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="status" value="Approved">
            <input type="hidden" name="dealer_information_id" value="{{ $row->id }}">

            <a onclick="$(this).parent().submit()">
                <button type="button" class="btn btn-success waves-effect">
                    <i class="tf-icons ti ti-check"></i>
                </button>
            </a>
        </form>
    @else
        <span class="badge {{ $approvals->status == 'Approved' ? 'bg-success' : 'bg-danger' }}">{{ $approvals->status }}</span>
    @endif
@endcan


