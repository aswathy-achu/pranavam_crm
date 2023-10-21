<ul class="sidebar-menu">
      <li class="<?php if(isset($menu) && $menu == 'dashboard') { echo 'active'; } ?>"><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
      <li class="dropdown" <?php if(isset($menu) && $menu == 'student') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user "></i> <span>Student</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('studentlist')}}">Student List</a></li>
        </ul>
      </li>
      
      <li class="dropdown <?php if(isset($menu) && $menu == 'staff') { echo 'active'; } ?>">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user "></i> <span>Staff</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('stafflist')}}">Staff List</a></li>
          
          <li><a class="nav-link" href="{{route('permissionlist')}}">Staff Permission</a></li>
        </ul>
      </li>
      <li class="dropdown" <?php if(isset($menu) && $menu == 'batch') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user "></i> <span>Batch Time Schedule</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('dayschedule')}}">Batch List</a></li>

        </ul>
      </li>
      <li class="dropdown" <?php if(isset($menu) && $menu == 'attendence') { echo 'active'; } ?>>
        <a href="" class="nav-link has-dropdown"><i class="fas fa-file-alt"></i> <span>Attendence</span></a>
        <ul class="dropdown-menu">
          <li><a href="{{route('attendenceday')}}">Calendar</a></li>
          <li><a href="{{route('admin.panel.att.listing')}}">View Attendance</a></li> 
          <li><a href="{{route('attendencestatus')}}">Attendance Status</a></li> 
        </ul>
      </li>           
        <li class="dropdown" <?php if(isset($menu) && $menu == 'fees') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-file"></i> <span>Fee Details</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('courselist')}}">Course List</a></li>
          <li><a class="nav-link" href="{{route('productlist')}}">Product List</a></li>
        </ul>
      </li>
      <li class="dropdown" <?php if(isset($menu) && $menu == 'invoice') { echo 'active'; } ?>>
        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Invoice</span></a>
        <ul class="dropdown-menu">
          <li><a href="{{route('billinglist')}}">Billing</a></li> 
          <li><a href="{{route('studentpaymenthistory')}}">Student Payment History</a></li> 

        </ul>