@php
    $task_type = isset($_GET['task_type']) ? $_GET['task_type'] : 'running';
@endphp

<ul class="nav nav-tabs eNav-Tabs-custom p-0" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($task_type == 'running') active @endif" onclick="redirectTo('{{ route('staff.my.profile',['tab' => 'task', 'task_type' => 'running']) }}')">
            {{get_phrase('Running Tasks')}}
            <span></span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($task_type == 'archive') active @endif" onclick="redirectTo('{{ route('staff.my.profile',['tab' => 'task', 'task_type' => 'archive']) }}')">
            {{get_phrase('Archive Tasks')}}
            <span></span>
        </button>
    </li>
</ul>
<div class="tab-content eNav-Tabs-content profile-tab-content p-0" id="myTabContent">
    @php
        if ($task_type == 'running') {
            $tasks = App\Models\Task::where('user_id', $user->id)
                ->where('status', 'running')
                ->orderBy('sort', 'asc')
                ->get();
        } else {
            $tasks = App\Models\Task::where('user_id', $user->id)
                ->where('status', 'archive')
                ->orderBy('sort', 'asc')
                ->get();
        }
    @endphp
    <ul class="mb-2">
        <li class="mx-2">
            <form action="{{ route('staff.task.store', $user->id) }}" method="post" class="ajaxForm resetable w-100">
                @Csrf
                <div class="input-group px-1">
                    <input type="text" name="description" class="form-control py-2 text-13px ms-3 border-1" placeholder="Enter a new task" aria-label="Enter a new task">
                    <button class="input-group-text text-12px text-dark me-3">{{get_phrase('Add')}}</button>
                </div>
            </form>
        </li>
    </ul>
    <ul class="task-list sortable" id="user-task-list{{ $user->id }}">
        @foreach ($tasks as $sorting_positions => $task)
            @include('staff.tasks.task')
        @endforeach
    </ul>
</div>

<script>
    "use strict";
    
    $(function() {
        $('#user-task-list{{ $user->id }}').sortable({
            axis: "y",
            start: function(event, ui) {},
            change: function(event, ui) {},
            update: function(event, ui) {
                let item_id = ui.item.attr('id');
                let sort_value = '';
                $.each($('#user-task-list{{ $user->id }} .sorting_values'), function(index, value) {
                    sort_value = sort_value + $(value).val() + ',';
                });
                console.log(sort_value);
                $.ajax({
                    type: 'post',
                    url: "{{ route('staff.task.sort') }}",
                    data: {
                        sort_value: sort_value
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        distributeServerResponse(response);
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        });
    });
    
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

        if ($(e).hasClass('expand-btn')) {
            $('.accordion-button').addClass('collapsed');
            $('.accordion-collapse').addClass('show');
            $(e).addClass('d-hidden');
        } else {
            $('.collapse-btn').addClass('d-hidden');
        }

    }

    function taskExpandToggler(taskId) {
        let taskArea = document.querySelector('#task-list' + taskId + ' textarea');
        let scrollHeight = taskArea.scrollHeight;
        let outerHeight = $('#task-list' + taskId + ' textarea').outerHeight();
        if (outerHeight <= 35) {
            taskArea.style.height = scrollHeight + 'px';
        } else {
            taskArea.style.height = '32px';
        }
    }
</script>
