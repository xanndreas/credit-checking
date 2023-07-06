<div class="modal fade text-start" id="reasonModal" tabindex="-1" aria-labelledby="reasonModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="reasonModal">Please write Reasons</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="add-new-brand pt-0" method="POST" action="{{ route('admin.approvals.approve') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="dealer_information_id" id="dealer_information_id" value="">
                    <input type="hidden" name="status" value="Rejected">

                    <div class="mb-3">
                        <label class="required" for="slik">Reason</label>
                        <textarea class="form-control" name="slik" id="slik"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
