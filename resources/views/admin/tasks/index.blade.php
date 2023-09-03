@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">

                <p class="column-title">Employee Tasks</p>
                <ul class="nav nav-tabs eNav-Tabs-custom" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if ($tasks_type == 'running') active @endif" onclick="redirectTo('{{ route('admin.tasks', 'running') }}')">
                            Running Tasks
                            <span></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if ($tasks_type == 'archive') active @endif" onclick="redirectTo('{{ route('admin.tasks', 'archive') }}')">
                            Archive Tasks
                            <span></span>
                        </button>
                    </li>
                    <li class="nav-item ms-auto" role="presentation">
                        <button onclick="tab_toggle(this)" class="nav-link text-secondary expand-btn">
                            Expand All
                        </button>
                        <button onclick="tab_toggle(this)" class="nav-link text-secondary collapse-btn d-hidden">
                            Collapse All
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
                                            <span class="badge bg-secondary ms-auto me-3" title="{{ get_phrase('Total task') }}" data-bs-toggle="tooltip">{{ $tasks->count() }}</span>
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
                                                                aria-label="Enter a new task" style="border: 1px solid #e7e7e7;">
                                                            <button class="input-group-text text-12px text-dark"
                                                                style="    background-color: #f5f5f5; border: 1px solid #e7e7e7;">Add</button>
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

        function tab_toggle(e) {
            $('.expand-btn').removeClass('d-hidden');
            $('.collapse-btn').removeClass('d-hidden');
            $('.accordion-button').removeClass('collapsed');
            $('.accordion-collapse').removeClass('show');

            if($(e).hasClass('expand-btn')){
                $('.accordion-button').addClass('collapsed');
                $('.accordion-collapse').addClass('show');
                $(e).addClass('d-hidden');
            }else{
                $('.collapse-btn').addClass('d-hidden');
            }

        }
    </script>
@endpush
