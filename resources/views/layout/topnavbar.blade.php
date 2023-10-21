

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <!-- <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button> -->
           
            </div>
          </div>
        </form>
        <?php
              use App\Staff;
              use App\Admin;
              use Illuminate\Support\Facades\Auth;

                  $user_id= Auth::User()->id;
                  $staff = Admin::where('user_id',$user_id)->first();
              ?>
        <ul class="navbar-nav navbar-right">
          
            </div>
          </li>
          <li class="dropdown">
         <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            @if(isset($staff) && isset($staff->admin_profile_image))
                <img class="img-xs rounded-circle" src="{{ asset('storage/app/admin_photo/' . $staff->admin_profile_image) }}" alt="">
            
            @else
                <img class="img-xs rounded-circle" src="{{ asset('storage/app/staff_photo/default.jpg') }}" alt="">
            @endif          
                     <div class="d-sm-none d-lg-inline-block">{{ auth()->user()->name }}</div></a>
           <div class="dropdown-menu dropdown-menu-right">
           @if(Auth::user()->type == 'S')
                <a href="{{ route('staffprofile', ['id' => Auth::user()->id]) }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
            @else
            <a href="{{route('adminprofileview')}}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
             
              @endif
              <!-- <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a> -->
              <div class="dropdown-divider"></div>
              <a href="{{route('logout')}}" class="dropdown-item preview-item">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>