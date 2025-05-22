@php
    use App\Models\Expense;
    use App\Models\Payment;
    use App\Models\VendorPayment;
    use App\Models\SiteOpeningBalance;
    use App\Models\SiteExpense;

@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <marquee class="text-center text-success pl-4 text-bold d-sm-inline-block">বাংলাদেশ ধান গবেষণা ইনস্টিটিউট</marquee>

    <!-- Right navbar links -->

    {{-- <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="nav-link">Logout</button>
            </form>
        </li>
    </ul> --}}

    <ul class="navbar-nav ml-auto">
        <!-- Profile Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <!-- Profile Image -->
                <img src="{{ asset('image/admin_layout/avatar5.png') }}" class="profile-image" alt="User Profile">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- Display User or Employee Info -->
                @if (Auth::check())
                    <!-- Regular authenticated user -->
                    <div class="dropdown-item">
                        <strong>{{ Auth::user()->name }}</strong><br>
                        <small>{{ Auth::user()->email }}</small>
                    </div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @elseif(session()->has('employee_id'))
                    <!-- Employee user -->
                    @php
                        $employee = App\Models\Employee::where('id',session()->get('employee_id'))->first();
                    @endphp
                    @if ($employee)
                        <div class="dropdown-item">
                            <strong>{{ $employee->name }}</strong><br>
                            <small>{{ $employee->email }}</small>
                        </div>
                        <form action="{{ route('submitLogout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    @endif
                @else
                    <div class="dropdown-item text-muted">
                        Not logged in.
                    </div>
                @endif

                <div class="dropdown-divider"></div>
            </div>


        </li>
    </ul>

    <!-- Styles for circular profile image -->
    <style>
        .profile-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 5px;
        }
    </style>




</nav>
