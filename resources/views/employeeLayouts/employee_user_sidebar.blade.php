<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link text-center">
        <b>{{ Session::get('company_name') }}</b><br>
        <small class="text-center">
            @if(auth()->user()->project_id != null)
            @php
                $project = App\Models\Project::where('id',auth()->user()->project_id)->first();
            @endphp
            {{$project->name}} @endif
        </small>
    </a>
    @php $user = auth()->user()->id;
    $userInstance = App\Models\User::find($user);
    @endphp

      @php

        use App\Models\MenuPermission;
        use App\Models\SubMenuPermission;

        $user = auth()->user()->role;
        $userInstance = App\Models\User::find($user);

        $menu_permission = MenuPermission::where('role', $user)->get()->toArray();

        $sub_menu_permission = SubMenuPermission::where('role', $user)->get()->toArray();

    @endphp

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('image/admin_layout/avatar5.png') }}" class="img-thumbnail elevation-2" alt="Admin Photo">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <b class="text-info">{{ (auth()->user()->name)?auth()->user()->name:'' }}</b>
                    <br/>@<small class="text-success">
                        @if (auth()->user()->role == 1)
                            DGM
                        @elseif (auth()->user()->role == 2)
                            Director
                        @elseif (auth()->user()->role == 3)
                            TO
                        @else
                           Stuff
                        @endif
                </small>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-home fa-lg "></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                 <li class="nav-item {{((isset($main_menu) && $main_menu=='employee-management')?'menu-open':'')}}">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-users "></i>
                      <p>
                        Employee Management
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('section-list')}}" class="nav-link {{((isset($child_menu) && $child_menu=='section-list')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Division</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('designation-list')}}" class="nav-link {{((isset($child_menu) && $child_menu=='designation-list')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Designation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('employee-create')}}" class="nav-link {{((isset($child_menu) && $child_menu=='employee-create')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Employee Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-employee') }}" class="nav-link {{((isset($child_menu) && $child_menu=='manage-employee')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Employee</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('manage-employee') }}" class="nav-link {{((isset($child_menu) && $child_menu=='manage-employee')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Driver</p>
                            </a>
                        </li>

                    </ul>
                </li>

                 <li class="nav-item {{((isset($main_menu) && $main_menu=='vehicle-management')?'menu-open':'')}}">
                    <a href="#" class="nav-link {{((isset($main_menu) && $main_menu=='vehicle-management')?'active':'')}}">
                      <i class="nav-icon fas fa-th-large "></i>
                      <p>
                        Vehicle Management
                      </p>
                      <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                         <li class="nav-item">
                            <a href="{{route('vehicle-types')}}" class="nav-link {{((isset($child_menu) && $child_menu=='vehicle-type')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vehicle Type</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                           <a href="{{route('vehicles-setup')}}" class="nav-link {{((isset($child_menu) && $child_menu=='setup-vehicle')?'active':'')}}">
                               <i class="far fa-circle nav-icon"></i>
                               <p>Setup-Vehicle</p>
                           </a>
                       </li>
                   </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                           <a href="{{route('vehicles')}}" class="nav-link {{((isset($child_menu) && $child_menu=='vehicle')?'active':'')}}">
                               <i class="far fa-circle nav-icon"></i>
                               <p>Vehicle</p>
                           </a>
                       </li>
                   </ul>
                </li>

                 {{-- {{-- @if (array_search('vendor', array_column($menu_permission, 'menu_slug')) !== false) --}}
                    <li class="nav-item {{((isset($main_menu) && $main_menu=='vehicle-requisition')?'menu-open':'')}}">
                    <a href="#" class="nav-link {{((isset($main_menu) && $main_menu=='vehicle-requisition')?'active':'')}}">
                      <i class="nav-icon fas fa-th-large "></i>
                      <p>
                        Vehicle Requisition
                      </p>
                      <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                         <li class="nav-item">
                            <a href="{{route('vehicle.requisition.form')}}" class="nav-link {{((isset($child_menu) && $child_menu=='vehicle-requisition-form')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Requisition</p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{route('vehicle.requisition.employee.list')}}" class="nav-link {{((isset($child_menu) && $child_menu=='vehicle-requisition-list')?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Requisition List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                 {{-- @endif --}}



               {{-- @if (auth()->user()->role == 'SuperAdmin' || auth()->user()->role == 'Admin' )  --}}
               {{-- @if (array_search('basic_settings', array_column($menu_permission, 'menu_slug')) !== false) --}}
                <li class="nav-item {{((isset($main_menu) && $main_menu=='basic_settings')?'menu-open':'')}}">

                    <a href="#" class="nav-link {{((isset($main_menu) && $main_menu=='basic_settings')?'active':'')}} ">
                      <i class="nav-icon fas fa-calculator "></i>
                      <p>
                        Basic Settings
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                        <ul class="nav nav-treeview">
                            <li>
                                <a href="{{ route('user-list') }}" class="nav-link {{((isset($child_menu) && $child_menu=='user')?'active':'')}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Admin</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('district')}}" class="nav-link {{((isset($child_menu) && $child_menu=='district')?'active':'')}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>District</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user-permission') }}" class="nav-link {{((isset($child_menu) && $child_menu=='user-permission')?'active':'')}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User Permission</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('company-list') }}" class="nav-link {{((isset($child_menu) && $child_menu=='company-list')?'active':'')}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Company Information</p>
                                </a>
                            </li>
                        </ul>
                  </li>
                 {{-- @endif --}}

                    <li class="nav-item" style="margin-top: 20px">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="nav-link"> <i class="fas fa-sign-out-alt mr-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
