<?php

use App\Permission;
use Illuminate\Support\Facades\Auth;
use App\Staff;

$auth_user = Auth::user();
// $staff = Staff::where('user_id', Auth::user()->id)->first();
// info($staff);
// $decodedArray = json_decode($staff->permission);
// info($decodedArray);
// $permissions = Permission::pluck('name')->toArray();
?>


<ul class="sidebar-menu">
    <li class="{{ isset($menu) && $menu == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fire"></i> <span>Dashboard</span>
        </a>
    </li> 
    @if(App\Staff::permission($auth_user->type,'student',$auth_user->id))
       
       <li class="dropdown" <?php if(isset($menu) && $menu == 'student') { echo 'active'; } ?>>
         <a href="#" class="nav-link has-dropdown"><i class="far fa-user "></i> <span>Student</span></a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="{{route('studentlist')}}">Student List</a></li>
         </ul>
       </li>
      @endif
      @if(App\Staff::permission($auth_user->type,'staff',$auth_user->id))
       
      <li class="dropdown <?php if(isset($menu) && $menu == 'staff') { echo 'active'; } ?>">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user "></i> <span>Staff</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('stafflist')}}">Staff List</a></li>
          
          <li><a class="nav-link" href="{{route('permissionlist')}}">staffpermission</a></li>
        </ul>
      </li>
      @endif
      @if(App\Staff::permission($auth_user->type,'batch',$auth_user->id))
       
      <li class="dropdown <?php if(isset($menu) && $menu == 'staff') { echo 'active'; } ?>">
      <li class="dropdown" <?php if(isset($menu) && $menu == 'batch') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user "></i> <span>Batch Time Schedule</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('dayschedule')}}">Batch List</a></li>
        </ul>
      </li>
      </li>
      @endif
      @if(App\Staff::permission($auth_user->type,'attendence',$auth_user->id))
      <li class="dropdown" <?php if(isset($menu) && $menu == 'attendence') { echo 'active'; } ?>>
        <a href="" class="nav-link has-dropdown"><i class="fas fa-file-alt"></i> <span>Attendence</span></a>
        <ul class="dropdown-menu">
          <li><a href="{{route('attendenceday')}}">Calendar</a></li>
          <li><a href="{{route('admin.panel.att.listing')}}">View Attendance</a></li> 
          <li><a href="{{route('attendencestatus')}}">Attendance Status</a></li> 
        </ul>
      </li> 
       @endif
    
      @if(App\Staff::permission($auth_user->type,'course',$auth_user->id))
       
        <li class="dropdown" <?php if(isset($menu) && $menu == 'fees') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-file"></i> <span>Fee Details</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('courselist')}}">Course List</a></li>
          <li><a class="nav-link" href="{{route('productlist')}}">Product List</a></li>
        </ul>
      </li>
      @endif  
      
      @if(App\Staff::permission($auth_user->type,'invoice',$auth_user->id))

      <li class="dropdown" <?php if(isset($menu) && $menu == 'invoice') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Invoice</span></a>
        <ul class="dropdown-menu">
          <li><a href="{{route('billinglist')}}">Billing</a></li> 
          <li><a href="{{route('studentpaymenthistory')}}">Student Payment History</a></li> 

        </ul>
        @endif  
