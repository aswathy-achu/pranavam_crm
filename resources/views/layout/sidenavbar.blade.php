<?php
use Illuminate\Support\Facades\Auth;
use App\Staff;


$auth_user = Auth::user();
$user_id= Auth::User()->id;
$user_type= Auth::User()->type;
$staff = Staff::where('user_id',$user_id)->first();
info("sssssssss".$staff);
?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{route('dashboard')}}">PRANAVAM</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    </div>
    <ul class="sidebar-menu">
    @if(Auth::user()->type == 'A')
      @include('layout.admin_sidenavbar')
    @else
      @include('layout.staff_sidenavbar')
    @endif
  </ul>
      </li>           
    </div>        
  </aside>
</div>