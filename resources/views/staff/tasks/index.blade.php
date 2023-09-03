@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">

                <p class="column-title">Employee Tasks</p>
                <ul class="nav nav-tabs eNav-Tabs-custom" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($tasks_type == 'running') active @endif" onclick="redirectTo('{{route('staff.tasks', 'running')}}')">
                            Running Tasks
                            <div class="badge bg-secondary ms-2" title="{{get_phrase('Total task')}}" data-bs-toggle="tooltip">
                                {{App\Models\Task::where('user_id', auth()->user()->id)
                                    ->where('status', 'running')->count()}}
                            </div>
                            <span></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($tasks_type == 'archive') active @endif" onclick="redirectTo('{{route('staff.tasks', 'archive')}}')">
                            Archive Tasks
                            <div class="badge bg-secondary ms-2" title="{{get_phrase('Total task')}}" data-bs-toggle="tooltip">
                                {{App\Models\Task::where('user_id', auth()->user()->id)
                                    ->where('status', 'archive')->count()}}
                            </div>
                            <span></span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content eNav-Tabs-content border-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
                        <div class="accordion custom-accordion" id="accordionStaff">

                            @foreach ($users as $key => $user)
                                @php
                                    if ($tasks_type == 'running') {
                                        $tasks = App\Models\Task::where('user_id', $user->id)
                                            ->where('status', 'running')
                                            ->orderBy('id', 'desc')
                                            ->get();
                                    } else {
                                        $tasks = App\Models\Task::where('user_id', $user->id)
                                            ->where('status', 'archive')
                                            ->orderBy('id', 'desc')
                                            ->get();
                                    }
                                @endphp
                                <div class="accordion-item border-0">
                                    <div id="collapse_{{ $key }}"
                                        class="accordion-collapse collapse show"
                                        aria-labelledby="heading_{{ $key }}" data-bs-parent="#accordionStaff" style="">
                                        <div class="accordion-body py-3 px-0">
                                            <ul class="mb-2">
                                                <li>
                                                    <form action="{{ route('staff.task.store', $user->id) }}" method="post" class="ajaxForm resetable w-100">
                                                        @Csrf
                                                        <div class="input-group">
                                                            <input type="text" name="description" class="form-control py-2 text-13px" placeholder="Enter a new task"
                                                                aria-label="Enter a new task" style="border: 1px solid #e7e7e7;">
                                                            <button class="input-group-text text-12px text-dark" style="    background-color: #f5f5f5; border: 1px solid #e7e7e7;">Add</button>
                                                        </div>
                                                    </form>
                                                </li>
                                            </ul>
                                            <ul class="task-list" id="user-task-list{{ $user->id }}">
                                                @foreach ($tasks as $task)
                                                    @include('staff.tasks.task')
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var time = 0;

        function setTimeoutAwait(e) {
            clearTimeout(time);
            time = setTimeout(() => {
                $(e).parent().submit();
            }, 1000);
        }
    </script>
@endpush
