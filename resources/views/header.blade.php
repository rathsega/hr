<div class="home-header">
    <div class="row w-100 justify-content-between align-items-center">
        <div class="col-auto">
            <div class="sidebar_menu_icon">
                <div class="menuList">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12">
                        <path id="Union_5" data-name="Union 5" d="M-2188.5,52.5v-2h15v2Zm0-5v-2h15v2Zm0-5v-2h15v2Z" transform="translate(2188.5 -40.5)" fill="#6e6f78" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-auto d-xl-block d-none me-auto">
            <div class="header_notification d-flex align-items-center text-dark fw-600">
                {{get_settings('website_title')}}
            </div>
        </div>
        <div class="col-auto">
            <div class="header-menu">
                <ul>

                    <li class="user-profile">
                        <div class="btn-group">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                aria-expanded="false">
                                <div class="">
                                    <img src="{{ get_image('uploads/user-image/' . auth()->user()->photo) }}" height="42px" />
                                </div>
                                <div class="px-2 text-start">
                                    <span class="user-name">{{ auth()->user()->name }}</span>
                                    <span class="user-title text-capitalize">{{ auth()->user()->role }}</span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end eDropdown-menu" aria-labelledby="defaultDropdown">
                                <li class="user-profile user-profile-inner">
                                    <button class="btn w-100 d-flex align-items-center" type="button">
                                        <div class="">
                                            <img class="radious-5px" src="{{ get_image('uploads/user-image/' . auth()->user()->photo) }}" height="42px" />
                                        </div>
                                        <div class="px-2 text-start">
                                            <span class="user-name">{{ auth()->user()->name }}</span>
                                            <span class="user-title text-capitalize">{{ auth()->user()->role }}</span>
                                        </div>
                                    </button>
                                </li>
                                <li>
                                    @php
                                        if (auth()->user()->role == 'admin') {
                                            $my_profile = route('admin.my.profile');
                                        } else {
                                            $my_profile = route('staff.my.profile');
                                        }
                                    @endphp
                                    <a class="dropdown-item" href="{{ $my_profile }}">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13.275" height="14.944" viewBox="0 0 13.275 14.944">
                                                <g id="user_icon" data-name="user icon" transform="translate(-1368.531 -147.15)">
                                                    <g id="Ellipse_1" data-name="Ellipse 1" transform="translate(1370.609 147.15)" fill="none" stroke="#181c32" stroke-width="2">
                                                        <ellipse cx="4.576" cy="4.435" rx="4.576" ry="4.435" stroke="none" />
                                                        <ellipse cx="4.576" cy="4.435" rx="3.576" ry="3.435" fill="none" />
                                                    </g>
                                                    <path id="Path_41" data-name="Path 41" d="M1485.186,311.087a5.818,5.818,0,0,1,5.856-4.283,5.534,5.534,0,0,1,5.466,4.283"
                                                        transform="translate(-115.686 -149.241)" fill="none" stroke="#181c32" stroke-width="2" />
                                                </g>
                                            </svg>
                                        </span>
                                        My Profile
                                    </a>
                                </li>
                                <li>
                                    @php
                                        if (auth()->user()->role == 'admin') {
                                            $change_password = route('admin.change.password');
                                        } else {
                                            $change_password = route('staff.change.password');
                                        }
                                    @endphp
                                    <a class="dropdown-item" href="{{$change_password}}">
                                        <i class="fi-br-key-skeleton-left-right"></i>
                                        Change password
                                    </a>
                                </li>

                                @if(auth()->user()->role == 'admin')
                                    <li>
                                        <a class="dropdown-item" href="{{route('admin.system.settings')}}">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14.602" height="14.636" viewBox="0 0 14.602 14.636">
                                                    <g id="Setting_icon" data-name="Setting icon" transform="translate(-215.957 -39.599)">
                                                        <path id="Path_387" data-name="Path 387"
                                                            d="M8.332,3.961a1.254,1.254,0,0,1,2.439,0,1.254,1.254,0,0,0,1.873.778,1.257,1.257,0,0,1,1.725,1.73,1.259,1.259,0,0,0,.775,1.877,1.259,1.259,0,0,1,0,2.445,1.259,1.259,0,0,0-.776,1.878,1.257,1.257,0,0,1-1.725,1.73,1.254,1.254,0,0,0-1.872.777,1.254,1.254,0,0,1-2.439,0A1.254,1.254,0,0,0,6.459,14.4a1.257,1.257,0,0,1-1.725-1.73,1.259,1.259,0,0,0-.775-1.877,1.259,1.259,0,0,1,0-2.445,1.259,1.259,0,0,0,.776-1.878A1.257,1.257,0,0,1,6.46,4.738a1.254,1.254,0,0,0,1.872-.777Z"
                                                            transform="translate(213.707 37.349)" fill="none" stroke="#181c32" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" />
                                                        <circle id="Ellipse_2" data-name="Ellipse 2" cx="1.689" cy="1.689" r="1.689"
                                                            transform="translate(221.57 45.415)" fill="none" stroke="#181c32" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" />
                                                    </g>
                                                </svg>
                                            </span>
                                            System Settings
                                        </a>
                                    </li>
                                @endif

                                <!-- Logout Button -->
                                <li>
                                    <a class="btn eLogut_btn" href="{{ route('logout') }}">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14.046" height="12.29" viewBox="0 0 14.046 12.29">
                                                <path id="Logout"
                                                    d="M4.389,42.535H2.634a.878.878,0,0,1-.878-.878V34.634a.878.878,0,0,1,.878-.878H4.389a.878.878,0,0,0,0-1.756H2.634A2.634,2.634,0,0,0,0,34.634v7.023A2.634,2.634,0,0,0,2.634,44.29H4.389a.878.878,0,1,0,0-1.756Zm9.4-5.009-3.512-3.512a.878.878,0,0,0-1.241,1.241l2.015,2.012H5.267a.878.878,0,0,0,0,1.756H11.05L9.037,41.036a.878.878,0,1,0,1.241,1.241l3.512-3.512A.879.879,0,0,0,13.788,37.525Z"
                                                    transform="translate(0 -32)" fill="#fff" />
                                            </svg>
                                        </span>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
