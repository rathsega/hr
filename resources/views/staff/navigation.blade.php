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
    <li class="nav-links-li @if($current_route == 'staff.timesheet') showMenu @endif">
      <div class="iocn-link">
        <a href="{{ route('staff.timesheet') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Timesheet
          </span>
        </a>
      </div>
    </li>

    <!-- menu starts here -->
    <li class="nav-links-li @if($current_route == 'staff.attendance') showMenu @endif">
      <div class="iocn-link">
        <a href="{{ route('staff.attendance') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Attendance
          </span>
        </a>
      </div>
    </li>

    <!-- menu starts here -->
    <li class="nav-links-li @if($current_route == 'staff.assessment') showMenu @endif">
      <div class="iocn-link">
        <a class="w-100" href="{{ route('staff.assessment') }}">
          <div class="sidebar_icon">
            <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="48" height="48"><path d="M11,14H5a5.006,5.006,0,0,0-5,5v5H3V19a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v5h3V19A5.006,5.006,0,0,0,11,14Z"></path><path d="M8,12A6,6,0,1,0,2,6,6.006,6.006,0,0,0,8,12ZM8,3A3,3,0,1,1,5,6,3,3,0,0,1,8,3Z"></path><polygon points="21 10 21 7 18 7 18 10 15 10 15 13 18 13 18 16 21 16 21 13 24 13 24 10 21 10"></polygon></svg>
          </div>
          <span class="link_name">
            Assessment
          </span>
        </a>
      </div>
    </li>

    <!-- menu ends here -->
  </ul>
</div>