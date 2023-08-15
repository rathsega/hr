@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">

                <p class="column-title">Employee Tasks</p>
                <ul class="nav nav-tabs eNav-Tabs-custom" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($tasks_type == 'running') active @endif" onclick="redirectTo('{{route('admin.tasks', 'running')}}')">
                            Running Tasks
                            <span></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($tasks_type == 'archive') active @endif" onclick="redirectTo('{{route('admin.tasks', 'archive')}}')">
                            Archive Tasks
                            <span></span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content eNav-Tabs-content" id="myTabContent">
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
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading_{{ $key }}">
                                        <button class="accordion-button @php echo (isset($_GET['expand-user']) && $user->id == $_GET['expand-user']) ? '' : 'collapsed'; @endphp"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $key }}"
                                            aria-expanded="@php echo (isset($_GET['expand-user']) && $user->id == $_GET['expand-user']) ? 'true' : 'false'; @endphp"
                                            aria-controls="collapse_{{ $key }}">
                                            <img class="rounded-circle me-2" width="30px" src="{{ get_image('uploads/user-image/' . $user->photo) }}">
                                            {{ $user->name }}
                                        </button>
                                    </h2>
                                    <div id="collapse_{{ $key }}"
                                        class="accordion-collapse collapse @php echo (isset($_GET['expand-user']) && $user->id == $_GET['expand-user']) ? 'show' : ''; @endphp"
                                        aria-labelledby="heading_{{ $key }}" data-bs-parent="#accordionStaff" style="">
                                        <div class="accordion-body py-3">
                                            <ul class="mb-2">
                                                <li>
                                                    <form action="{{ route('admin.task.store', $user->id) }}" method="post" class="ajaxForm resetable w-100">
                                                        @Csrf
                                                        <div class="input-group">
                                                            <input type="text" name="description" class="form-control py-2 text-13px" placeholder="Enter a new task"
                                                                aria-label="Enter a new task">
                                                            <button class="input-group-text text-12px text-dark">Add</button>
                                                        </div>
                                                    </form>
                                                </li>
                                            </ul>
                                            <ul class="task-list" id="user-task-list{{ $user->id }}">
                                                @foreach ($tasks as $task)
                                                    @include('admin.tasks.task')
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
