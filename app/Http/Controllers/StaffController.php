<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function dashboard(){
        return view('staff/dashboard');
    }
    public function staffreg(){
        if (!Auth::check()){
            return redirect('/');
        }
        return view('staffreg');
    }

public function manage_staff(Request $req,$id='')
{

     if ($_POST) {
         if ($req->post('id') == '') {
            $data = new User;
            $data->name = $req->post('fname');
            $data->type = 'S';
            $data->email = $req->post('email');
            $data->password = Hash::make($req->post('password'));
            $data->save();
            $staff = new Staff;
         } else {
            $staff = Staff::find($req->post('id'));
            // print_r($staff->user_id);die;

            User::where('id', $staff->user_id)
                           ->update(['name' => $req->post('fname'), 'email' => $req->post('email'),'type' => 'S']);
         }

         if (!$req->post('id')) {
            $staff->user_id = $data->id;
         }
         $staff->fname = $req->post('fname');
         $staff->lname = $req->post('lname');
         $staff->gender = $req->post('gender');
         $staff->dob = strtotime($req->post('dob'));
         $staff->email = $req->post('email');
         $staff->phone = $req->post('phone');
        //  $staff->user_role = 'S';
         $staff->address1 = $req->post('address1');
         $staff->state = $req->post('state');
         $staff->address2 = $req->post('address2');
         $staff->postcode = $req->post('postcode');
         $staff->city = $req->post('city');
         $staff->country = $req->post('country');
         $staff->jobrole = $req->post('jobrole');
         $staff->date_of_joining = strtotime($req->post('doj'));
         if ($req->hasFile('staff_profile_image')) {
            if ($req->input('id')) {
                if (Storage::exists('staff_photo/' . $staff->staff_profile_image)) {
                    Storage::delete('staff_photo/' . $staff->staff_profile_image);
                } 
            }
            $extension = $req->file('staff_profile_image')->extension();
            $filename = rand() . '.' . $extension;
            $req->file('staff_profile_image')->storeAs('staff_photo', $filename);
            $staff->staff_profile_image = $filename;
        }
         $staff->save();
         if ($req->post('id')) {
             return Redirect::to('stafflist')->with('success','Update successfully!');
         } else {
             return Redirect::to('stafflist')->with('success','Add successfully!');
         }
     }
     if ($id) {
         $page_data['staff'] = Staff::find($id);
     }
    
     $page_data['menu'] = 'staff';

     return view('staffreg')->with($page_data);
    
}
    public function stafflist()
   {
    $page_data['menu'] = 'staff';
   		return view('stafflist')->with($page_data);
   }
   
   public function get_staff()
   {
       if (!Auth::check()) {return Redirect::to('/');}
       $users = Staff::orderBy('id','desc');
       return datatables()->eloquent($users)
       ->addIndexColumn()
       ->editColumn('date_of_joining',function ($f)
        {
            if (isset($f->date_of_joining)) {
                $detailes = $f->date_of_joining;
                $detailes = date('d-M-Y',$detailes);
            } else{
                $detailes = '';
            }
            return $detailes;
        })
      
       
       ->addColumn('action', function ($user) {
        $details = '<a href="'.url('/manage_staff').'/'.$user->id.'" class="fas fa-edit"></a>';
        $details.='<a href="'.url('/viewstaffprofileadmin').'/'.$user->id.'" class="fas fa-eye"></a>';

        $details.='  <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_modal" title="Delete" onclick=delete_confirm("/del_staff/'.$user->id.'")><i class="fas fa-trash"></i></a>';
        return $details;
    })

       ->make(true);
       }
       public function del_staff(Request $request, $id)
       {   
           if (!Auth::check()) {return Redirect::to('/');}
           $data = Staff::find($id);
           if ($data) {
               $data->delete();
               return Redirect::back()->with('success','Delete successfully!');
           } else {
               return Redirect::back()->with('error','Data Not Found');
           }
}
public function get_staff_permission()
{
    if (!Auth::check()) {return Redirect::to('/');}
    $users = Staff::orderBy('id','desc');
    return datatables()->eloquent($users)
        ->addIndexColumn()
        ->editColumn('permission', function ($d) {
                $permissionIds = json_decode($d->permission);

        if (!is_array($permissionIds)) {
            return '';
        }

        $permissionNames = Permission::whereIn('name', $permissionIds)
            ->pluck('name')
            ->implode(', ');

        if (!empty($permissionNames)) {
            return $permissionNames;
        } else {
            return 'No Permissions';
        }
    })
    ->addColumn('action',  function ($d)
    {
        $details=' <a href="'.url('/manage_permission').'/'.$d->id.'" title="Permission"><i class="fas fa-edit" style="color: #6c7293"></i></a>';
        return $details;
        
    })
    ->rawColumns(['position','action'])

    ->make(true);
}
public function staffpermissionlist($id=''){
    $permissions = Permission::all();
    return view('staffpermissionlist', compact('permissions'));
}
public function managestaffpermission(Request $request, $id = '') {
    // info("dfghjl");

    if ($request->isMethod('post')) {
        if ($request->input('id') == '') {
            $permission = new Permission();
        } else {
            $permission = Permission::find($request->input('id'));
        }

        // Retrieve batch details
        $permission->name = $request->input('permission_name');
        // info($permission);
        $permission->save();

        if ($request->input('id')) {
            return redirect('/staffpermissionlist')->with('success', 'Update successfully!');
        } else {
            return redirect('/staffpermissionlist')->with('success', 'Add successfully!');
        }
    }

    if ($id) {
        $permission = Permission::find($id);
    } else {
        
        return redirect('/staffpermissionlist')->with('error', 'Permission ID not provided.');
    }

    return view('staffpermissionlist', compact('permission'));
}


public function manage_permission(Request $request,$id='')
{
    $page_data['permissions'] = Permission::get();
        if ($_POST) {
            $permission = $request->input('checkbox');
        //   info($permission);
        if($permission)
        {
            $json = json_encode($permission);
            // info($json);
        } else {
            $json = '';
        }
        $val = Staff::find($request->post('id'));
        info($request->post('id'));
        if($val)
        {
            $data = Staff::where('id',$request->post('id'))->update(['permission'  => $json]);
            return redirect()->route('permissionlist')->with('success', 'Permission Granted');
        } else{
            return redirect()->route('permissionlist')->with('error', 'Data Not Found');

        }
        }
        if ($id) {
        $page_data['staff'] = $staff = Staff::find($id);
        $page_data['items'] = json_decode($staff->permission);

        }

        return view('staffpermissionlist')->with($page_data);
    }
    public function permissionlist(){
        $page_data['menu'] = 'staff';
        return view('permissionlist')->with($page_data);
    // return view('permissionlist');
    }
    public function staffprofile(Request $request, $id = '')
    {
        info($request->all());
    
        $auth_user = Auth::user();
        $user_id= Auth::User()->id;
        $user_type= Auth::User()->type;
        $admin = Staff::where('user_id',$user_id)->first();
        info("sssde".$admin);
    
        return view('staffprofile', compact('admin'));
    }
    
    
    public function editstaffprofile(Request $req,$id=''){
        $user_id= Auth::User()->id;
        // return $user_id;
        $staff=Staff::where('user_id',$user_id)->first();
        return view('editstaffprofile', compact('staff'));
    }
    public function viewstaffprofileadmin(Request $req, $id = '')
    {
        $auth_user = Auth::user();
        $user_id = Auth::User()->id;
        // $user_type = Auth::User()->type;
        $staff = Staff::where('id', $id)->first();
        return view('viewstaffprofileadmin', compact('staff'));
    }
    
    public function edit_manage_staff(Request $req,$id='')
{

     if ($_POST) {
         if ($req->post('id') == '') {
            $data = new User;
            $data->name = $req->post('fname');
            $data->type = 'S';
            $data->email = $req->post('email');
            $data->password = Hash::make($req->post('password'));
            $data->save();
            $staff = new Staff;
         } else {
            $staff = Staff::find($req->post('id'));
            // print_r($staff->user_id);die;

            User::where('id', $staff->user_id)
                           ->update(['name' => $req->post('fname'), 'email' => $req->post('email'),'type' => 'S']);
         }

         if (!$req->post('id')) {
            $staff->user_id = $data->id;
         }
         $staff->fname = $req->post('fname');
         $staff->lname = $req->post('lname');
         $staff->gender = $req->post('gender');
         $staff->dob = strtotime($req->post('dob'));
         $staff->email = $req->post('email');
         $staff->phone = $req->post('phone');
        //  $staff->user_role = 'S';
         $staff->address1 = $req->post('address1');
         $staff->state = $req->post('state');
         $staff->address2 = $req->post('address2');
         $staff->postcode = $req->post('postcode');
         $staff->city = $req->post('city');
         $staff->country = $req->post('country');
         $staff->jobrole = $req->post('jobrole');
         $staff->date_of_joining = strtotime($req->post('doj'));
         if ($req->hasFile('staff_profile_image')) {
            if ($req->input('id')) {
                if (Storage::exists('staff_photo/' . $staff->staff_profile_image)) {
                    Storage::delete('staff_photo/' . $staff->staff_profile_image);
                } 
            }
            $extension = $req->file('staff_profile_image')->extension();
            $filename = rand() . '.' . $extension;
            $req->file('staff_profile_image')->storeAs('staff_photo', $filename);
            $staff->staff_profile_image = $filename;
        }
         $staff->save();
         if ($req->post('id')) {
             return Redirect::to('dashboard')->with('success','Update successfully!');
         } else {
             return Redirect::to('dashboard')->with('success','Add successfully!');
         }
     }
     if ($id) {
         $page_data['staff'] = Staff::find($id);
     }
    
     $page_data['menu'] = 'staff';

     return view('editstaffprofile')->with($page_data);
    
}
public function manage_reset_user_password(Request $request)
{
    $user = User::where('email', $request->input('email'))->first();
    if (!$user) {
        return redirect()->back()->with('error', 'User not found!');
    }
    $user->password = Hash::make($request->input('password'));
    $user->save();
    return redirect()->back()->with('success', 'User password has been updated.');
}

    
}