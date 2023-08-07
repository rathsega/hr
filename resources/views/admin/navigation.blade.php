@php $current_route = Route::currentRouteName(); @endphp

<div class="sidebar">
  <div class="logo-details mt-4">
    <div class="img_wrapper">
      <img src="{{asset('public/assets/images/favicon.png')}}" alt="" style="width: 37px;" />
    </div>
    <span class="logo_name">WorkPlace</span>
  </div>
  <div class="closeIcon">
    <span><i class="bi bi-x-circle"></i></span>
  </div>
  <ul class="nav-links">
    <!-- menu starts here -->
    
    <li class="nav-links-li @if($current_route == 'admin.task_manager') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="{{ route('admin.task_manager') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Task Manager
          </span>
        </a>
      </div>
    </li>

    <!-- menu starts here -->
    <li class="nav-links-li @if($current_route == 'admin.attendance') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="{{ route('admin.attendance') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Attendance
          </span>
        </a>
      </div>
    </li>
    
    <li class="nav-links-li @if($current_route == 'admin.timesheet') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="{{ route('admin.timesheet') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Timesheet
          </span>
        </a>
      </div>
    </li>

    <!--<li class="nav-links-li @if($current_route == 'admin.timesheet' || $current_route == 'admin.task_manager') showMenu @endif">-->
    <!--  <div class="iocn-link">-->
    <!--    <a class="w-100" href="#">-->
    <!--      <div class="sidebar_icon">-->
    <!--        <?xml version="1.0"?><svg-->
    <!--          fill="#000000"-->
    <!--          xmlns="http://www.w3.org/2000/svg"-->
    <!--          viewBox="0 0 24 24"-->
    <!--          width="48px"-->
    <!--          height="48px"-->
    <!--        >-->
    <!--          <path-->
    <!--            d="M 6 2 C 4.9057453 2 4 2.9057453 4 4 L 4 20 C 4 21.094255 4.9057453 22 6 22 L 18 22 C 19.094255 22 20 21.094255 20 20 L 20 8 L 14 2 L 6 2 z M 6 4 L 13 4 L 13 9 L 18 9 L 18 20 L 6 20 L 6 4 z M 8 12 L 8 14 L 16 14 L 16 12 L 8 12 z M 8 16 L 8 18 L 16 18 L 16 16 L 8 16 z"-->
    <!--          />-->
    <!--        </svg>-->
    <!--      </div>-->
    <!--      <span class="link_name">Tasks</span>-->
    <!--    </a>-->
    <!--    <span class="arrow">-->
    <!--      <svg-->
    <!--        xmlns="http://www.w3.org/2000/svg"-->
    <!--        width="4.743"-->
    <!--        height="7.773"-->
    <!--        viewBox="0 0 4.743 7.773"-->
    <!--      >-->
    <!--        <path-->
    <!--          id="navigate_before_FILL0_wght600_GRAD0_opsz24"-->
    <!--          d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"-->
    <!--          fill="#fff"-->
    <!--          opacity="1"-->
    <!--        />-->
    <!--      </svg>-->
    <!--    </span>-->
    <!--  </div>-->
    <!--  <ul class="sub-menu">-->
    <!--    <li><a class="link_name" href="#">Tasks</a></li>-->
    <!--    <li><a class="@if($current_route == 'admin.task_manager') active @endif" href="{{ route('admin.task_manager') }}">Task Manager</a></li>-->
    <!--    <li><a class="@if($current_route == 'admin.timesheet') active @endif" href="{{ route('admin.timesheet') }}">Timesheet</a></li>-->
    <!--  </ul>-->
    <!--</li>-->

    <!-- menu starts here -->
    <li class="nav-links-li @if($current_route == 'admin.staff') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="{{ route('admin.staff') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Staff
          </span>
        </a>
      </div>
    </li>

    <!-- menu starts here -->
    <li class="nav-links-li @if($current_route == 'admin.assessment') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="{{ route('admin.assessment') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Assessment
          </span>
        </a>
      </div>
    </li>

    <li class="nav-links-li @if($current_route == 'admin.assessment.team.report' || $current_route == 'admin.assessment.daily.report') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="#">
          <div class="sidebar_icon">
            <?xml version="1.0"?><svg
              fill="#000000"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="48px"
              height="48px"
            >
              <path
                d="M 6 2 C 4.9057453 2 4 2.9057453 4 4 L 4 20 C 4 21.094255 4.9057453 22 6 22 L 18 22 C 19.094255 22 20 21.094255 20 20 L 20 8 L 14 2 L 6 2 z M 6 4 L 13 4 L 13 9 L 18 9 L 18 20 L 6 20 L 6 4 z M 8 12 L 8 14 L 16 14 L 16 12 L 8 12 z M 8 16 L 8 18 L 16 18 L 16 16 L 8 16 z"
              />
            </svg>
          </div>
          <span class="link_name">Assessment</span>
        </a>
        <span class="arrow">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="4.743"
            height="7.773"
            viewBox="0 0 4.743 7.773"
          >
            <path
              id="navigate_before_FILL0_wght600_GRAD0_opsz24"
              d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
              fill="#fff"
              opacity="1"
            />
          </svg>
        </span>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Assessment</a></li>
        <li><a class="@if($current_route == 'admin.assessment.daily.report') active @endif" href="{{ route('admin.assessment.daily.report') }}">Daily Report</a></li>
        <li><a class="@if($current_route == 'admin.assessment.team.report') active @endif" href="{{ route('admin.assessment.team.report') }}">Team report</a></li>
      </ul>
    </li>

    {{-- <li class="nav-links-li">
      <div class="iocn-link">
        <a class="w-100" href="#">
          <div class="sidebar_icon">
            <?xml version="1.0"?><svg
              fill="#000000"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="48px"
              height="48px"
            >
              <path
                d="M 6 2 C 4.9057453 2 4 2.9057453 4 4 L 4 20 C 4 21.094255 4.9057453 22 6 22 L 18 22 C 19.094255 22 20 21.094255 20 20 L 20 8 L 14 2 L 6 2 z M 6 4 L 13 4 L 13 9 L 18 9 L 18 20 L 6 20 L 6 4 z M 8 12 L 8 14 L 16 14 L 16 12 L 8 12 z M 8 16 L 8 18 L 16 18 L 16 16 L 8 16 z"
              />
            </svg>
          </div>
          <span class="link_name">Tasks</span>
        </a>
        <span class="arrow">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="4.743"
            height="7.773"
            viewBox="0 0 4.743 7.773"
          >
            <path
              id="navigate_before_FILL0_wght600_GRAD0_opsz24"
              d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
              fill="#fff"
              opacity="1"
            />
          </svg>
        </span>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Tasks</a></li>
        <li><a class="@if($current_route == 'admin.task_manager') active @endif" href="{{ route('admin.task_manager') }}">Task Manager</a></li>
        <li><a class="@if($current_route == 'admin.timesheet') active @endif" href="{{ route('admin.timesheet') }}">Timesheet</a></li>
      </ul>
    </li> --}}

  </ul>
</div>