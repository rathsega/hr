<div class="row">
    <div class="col-md-8">
        <div class="eSection-wrap">

            <div class="tab-content eNav-Tabs-content border-0" id="myTabContent">
                <div class="tab-pane fade show active" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
                    <div class="accordion custom-accordion" id="accordionStaff">

                            @php
                                $tasks = App\Models\Task::where('user_id', $user->id)
                                    // ->where('status', 'running')
                                    ->orderBy('id', 'desc')
                                    ->get();
                                $tasks = App\Models\Task::where('user_id', $user->id)
                                    // ->where('status', 'archive')
                                    ->orderBy('id', 'desc')
                                    ->get();
                                    $key = 0;
                            @endphp
                            <div class="accordion-item border-0">
                                <div id="collapse"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="heading" data-bs-parent="#accordionStaff" style="">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var time = 0;

    function setTimeoutAwait(e) {
        clearTimeout(time);
        time = setTimeout(() => {
            $(e).parent().submit();
        }, 1000);
    }
</script>