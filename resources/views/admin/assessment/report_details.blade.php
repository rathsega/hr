@extends('index')

@section('content')
    <div class="eCard">
        <div class="eCard-body">
            <h5 class="eCard-title">Employee Report</h5>
            <div class="my-4 d-flex">
                <div class="">
                    <img width="50px" height="50px" class="rounded-circle"
                        src="{{ get_image('uploads/user-image/' . $staff->photo) }}">
                </div>
                <div class="d-flex flex-column ms-3">
                    <span class="eCard-title mb-0">{{ $staff->name }}</span>
                    <small>{{ $staff->designation }}</small>
                </div>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(!isset($_GET['tab'])) active @endif" id="incident-tab" data-bs-toggle="tab"
                        data-bs-target="#incident-tab-pane" type="button" role="tab" aria-controls="incident-tab-pane"
                        aria-selected="true">Incident</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(isset($_GET['tab'])) active @endif" id="performance-tab" data-bs-toggle="tab"
                        data-bs-target="#performance-tab-pane" type="button" role="tab"
                        aria-controls="performance-tab-pane" aria-selected="false">Performance</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade @if(!isset($_GET['tab'])) active show @endif" id="incident-tab-pane" role="tabpanel" aria-labelledby="incident-tab"
                    tabindex="0">
                    <form action="{{ route('admin.assessment.team.report', $staff->id) }}" method="get">
                        <div class="row">
                            <div class="col-md-6 py-4">
                                <select name="year"
                                    class="form-select eForm-select eChoice-multiple-without-remove select2-hidden-accessible"
                                    onchange="$(this).parent().submit()">
                                    @for ($year = 2020; $year <= date('Y'); $year++)
                                        <option name="year" value="{{ $year }}"
                                            @if ($year == date('Y')) selected @endif>{{ $year }}</option>
                                    @endfor;
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        @php
                            if (isset($_GET['year'])) {
                                $selected_year = $_GET['year'];
                            } else {
                                $selected_year = date('Y');
                            }
                        @endphp
                        @for ($month = 1; $month <= 12; $month++)
                            @php
                            
                                $start_date = $selected_year . '-' . $month . '-1 00:00:00';
                                $end_date = $selected_year . '-' . $month .'-'.date('t', strtotime($start_date)).' 00:00:00';
                                $assessments = App\Models\Assessment::where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
                            @endphp
                            <div class="col-md-6">
                                <div class="accordion custom-accordion mb-3" id="accordion{{ $month }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $month }}" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                {{ date('F', strtotime('01-' . $month . '-' . $selected_year)) }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $month }}" class="accordion-collapse collapse show"
                                            data-bs-parent="#accordion{{ $month }}">
                                            <div class="accordion-body">
                                                <ul>
                                                    @foreach ($assessments->get() as $key => $assessment)
                                                        <li class="text-danger">{{ ++$key }}.
                                                            {{ $assessment->description }}</li>
                                                    @endforeach

                                                    @if ($assessments->count() == 0)
                                                        <li>There are no incidents</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="tab-pane fade @if(isset($_GET['tab'])) active show @endif" id="performance-tab-pane" role="tabpanel" aria-labelledby="performance-tab"
                    tabindex="0">
                    <form action="{{ route('admin.assessment.team.report', $staff->id) }}" method="get">
                        <div class="row">
                            <div class="col-md-6 py-4">
                                <select name="year"
                                    class="form-select eForm-select eChoice-multiple-without-remove select2-hidden-accessible"
                                    onchange="$(this).parent().submit()">
                                    @for ($year = 2020; $year <= date('Y'); $year++)
                                        <option name="year" value="{{ $year }}"
                                            @if ($year == date('Y')) selected @endif>{{ $year }}</option>
                                    @endfor;
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        @php
                            if (isset($_GET['year'])) {
                                $selected_year = $_GET['year'];
                            } else {
                                $selected_year = date('Y');
                            }
                            
                        @endphp
                        
                        @for ($month = 1; $month <= 12; $month++)
                            @php
                                $start_date = $selected_year . '-' . $month . '-1 00:00:00';
                                $end_date = $selected_year . '-' . $month .'-'.date('t', strtotime($start_date)).' 00:00:00';
                                
                                $all = App\Models\Staff_performance::where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date)
                                    ->where('type', '!=', 'remarks');
                                $discipline = App\Models\Staff_performance::where('type', 'discipline')
                                    ->where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
                                $leadership = App\Models\Staff_performance::where('type', 'leadership')
                                    ->where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
                                $punctuality = App\Models\Staff_performance::where('type', 'punctuality')
                                    ->where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
                                $performance = App\Models\Staff_performance::where('type', 'performance')
                                    ->where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
                                $remarks = App\Models\Staff_performance::where('type', 'remarks')
                                    ->where('user_id', $staff->id)
                                    ->whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
                            @endphp
                            <div class="col-md-6">
                                <div class="accordion custom-accordion mb-3" id="accordion{{ $month }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $month }}" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                {{ date('F', strtotime('01-' . $month . '-' . $selected_year)) }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $month }}" class="accordion-collapse collapse show"
                                            data-bs-parent="#accordion{{ $month }}">
                                            <div class="accordion-body">
                                                <ul>
                                                    <li class="d-flex my-3">
                                                        <p>
                                                            Average:
                                                            @if ($all->count() > 0)
                                                                @php $all_rating = $all->get()->sum('rating')/$all->count(); @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $all_rating)
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    @else
                                                                        <i class="bi bi-star"></i>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        </p>
                                                    </li>

                                                    <li class="d-flex my-3">
                                                        <p>
                                                            Leadership:
                                                            @if ($leadership->count() > 0)
                                                                @php $leadership_rating = $leadership->get()->sum('rating')/$leadership->count(); @endphp
                                                                {{$leadership_rating}}
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $leadership_rating)
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    @else
                                                                        <i class="bi bi-star"></i>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        </p>
                                                        <a onclick="showRightModal('{{route('right_modal', ['view_path' => 'admin.assessment.rating_update', 'rating_type' => 'leadership', 'user_id' => $staff->id, 'timestamp' => strtotime($selected_year . '-' . $month . '-'. date('d'))])}}', 'Rate the Leadership')" class="ms-auto" href="#"><i class="bi bi-pencil"></i></a>
                                                    </li>

                                                    <li class="d-flex my-3">
                                                        <p>
                                                            Performance:
                                                            @if ($performance->count() > 0)
                                                                @php $performance_rating = $performance->get()->sum('rating')/$performance->count(); @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $performance_rating)
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    @else
                                                                        <i class="bi bi-star"></i>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        </p>
                                                        <a onclick="showRightModal('{{route('right_modal', ['view_path' => 'admin.assessment.rating_update', 'rating_type' => 'performance', 'user_id' => $staff->id, 'timestamp' => strtotime($selected_year . '-' . $month . '-'. date('d'))])}}', 'Rate the Performance')" class="ms-auto" href="#"><i class="bi bi-pencil"></i></a>
                                                    </li>

                                                    <li class="d-flex my-3">
                                                        <p>
                                                            Discipline:
                                                            @if ($discipline->count() > 0)
                                                                @php $discipline_rating = $discipline->get()->sum('rating')/$discipline->count(); @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $discipline_rating)
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    @else
                                                                        <i class="bi bi-star"></i>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        </p>
                                                        <a onclick="showRightModal('{{route('right_modal', ['view_path' => 'admin.assessment.rating_update', 'rating_type' => 'discipline', 'user_id' => $staff->id, 'timestamp' => strtotime($selected_year . '-' . $month . '-'. date('d'))])}}', 'Rate the Discipline')" class="ms-auto" href="#"><i class="bi bi-pencil"></i></a>
                                                    </li>

                                                    <li class="d-flex my-3">
                                                        <p>
                                                            Punctuality:
                                                            @if ($punctuality->count() > 0)
                                                                @php $punctuality_rating = $punctuality->get()->sum('rating')/$punctuality->count(); @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $punctuality_rating)
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    @else
                                                                        <i class="bi bi-star"></i>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        </p>
                                                        <a onclick="showRightModal('{{route('right_modal', ['view_path' => 'admin.assessment.rating_update', 'rating_type' => 'punctuality', 'user_id' => $staff->id, 'timestamp' => strtotime($selected_year . '-' . $month . '-'. date('d'))])}}', 'Rate the Punctuality')" class="ms-auto" href="#"><i class="bi bi-pencil"></i></a>
                                                    </li>
                                                    <li class="d-flex my-3">
                                                        <p>Remarks:</p>
                                                        <ul>
                                                            @foreach($remarks->get() as $remark)
                                                                <li>{{$remark->description}}</li>
                                                            @endforeach
                                                        </ul>
                                                        <a onclick="showRightModal('{{route('right_modal', ['view_path' => 'admin.assessment.rating_update', 'rating_type' => 'remarks', 'user_id' => $staff->id, 'timestamp' => strtotime($selected_year . '-' . $month . '-'. date('d'))])}}', 'Remarks')" class="ms-auto" href="#"><i class="bi bi-pencil"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
