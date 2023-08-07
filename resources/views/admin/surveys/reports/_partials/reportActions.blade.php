@can('survey_report_create')
    @if($surveyReports)
        <a href="{{ route('admin.surveys.reports.download', ['survey' => $surveyReports->survey_id]) }}" class="btn btn-xs btn-warning waves-effect waves-light">
            Download
        </a>
    @else
        <a href="{{ route('admin.surveys.reports.create', ['survey' => $survey->id]) }}" class="btn btn-xs btn-outline-warning waves-effect waves-light">
            Write
        </a>
    @endif
@endcan

@can('survey_report_show')
    @if($surveyReports)
        <a href="{{ route('admin.surveys.reports.download', ['survey' => $surveyReports->survey_id]) }}" class="btn btn-xs btn-warning waves-effect waves-light">
            Download
        </a>
    @else
        <button class="btn btn-xs btn-danger waves-effect waves-light" disabled>
            Waiting
        </button>
    @endif
@endcan
