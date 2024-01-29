<li class="position-relative mx-2 @if ($task->is_completed == 1) completed @endif" id="task-list{{ $task->id }}">
    <input class="sorting_values" type="hidden" value="{{$task->id}}">

    <div class="position-relative">
        <a href="#" class="sorting-btn">
            <i class="fi-rr-grip-dots-vertical"></i>
        </a>
    </div>
    <div class="task-checkbox-content">
        <input onchange="actionTo('{{ route('staff.task.completion', ['id' => $task->id]) }}')" class="task-checkbox" type="checkbox" data-bs-toggle="tooltip"
            title="{{ get_phrase('Mark As Completed') }}" @if ($task->is_completed == 1) checked @endif>
    </div>
    <div class="task-area-content w-100">
        <form action="{{ route('staff.task.update', $task->id) }}" method="post" class="ajaxForm task-from">
            @Csrf
            <textarea onkeyup="setTimeoutAwait(this); taskExpandToggler('{{ $task->id }}', true)" name="description" class="task-description form-control border-0" rows="1">{{ $task->description }}</textarea>
        </form>
    </div>
    <div class="archive-section">
        <button class="btn px-1 py-0" onclick="taskExpandToggler('{{ $task->id }}')" title="{{ get_phrase('Expand') }}" data-bs-toggle="tooltip">
            <i class="fi-bs-arrows-alt-v"></i>
        </button>

        @if ($task->status == 'running')
            <button onclick="actionTo('{{ route('staff.task.status', ['id' => $task->id]) }}')" type="button" class="btn p-0" title="{{ get_phrase('Mark as Archive') }}"
                data-bs-toggle="tooltip">
                <i class="fi-rr-archive"></i>
            </button>
        @else
            <button onclick="actionTo('{{ route('staff.task.status', ['id' => $task->id]) }}')" type="button" class="btn px-1 py-0" title="{{ get_phrase('Restore') }}"
                data-bs-toggle="tooltip">
                <svg fill="none" height="14" viewBox="0 0 24 24" width="14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="fi_8929802">
                    <clipPath id="clip0_11_1220">
                        <path d="m0 0h24v24h-24z"></path>
                    </clipPath>
                    <g clip-path="url(#clip0_11_1220)">
                        <path
                            d="m14 12c0-1.1-.9-2.00005-2-2.00005s-2 .90005-2 2.00005.9 2 2 2 2-.9 2-2zm-1.74-9.00005c-5.09-.14-9.26 3.95-9.26 9.00005h-1.79c-.45 0-.67.54-.35.85l2.79 2.79c.2.2.51.2.71 0l2.79-2.79c.31-.31.09-.85-.36-.85h-1.79c0-3.90005 3.18-7.05005 7.1-7.00005 3.72.05 6.85 3.18 6.9 6.90005.05 3.9099-3.1 7.1-7 7.1-1.25 0-2.42-.34-3.44-.91-.39-.22-.87-.14-1.18.18-.46.46-.37 1.25.2 1.57 1.31.73 2.81 1.16 4.42 1.16 5.05 0 9.14-4.17 9-9.26-.13-4.69005-4.05-8.61005-8.74-8.74005z"
                            fill="#000"></path>
                    </g>
                </svg>
            </button>
        @endif

        <button class="btn px-1 py-0" onclick="actionTo('{{ route('staff.task.delete', ['id' => $task->id]) }}')" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
            <i class="fi fi-rr-trash"></i>
        </button>
    </div>
</li>

@include('init')
