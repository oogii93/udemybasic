<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //blade deer message-ee oruulaad end funciton door ni with ashiglaad messagetei hamt ywuulna
        $notification=array(
            'message'=>'user logout successfully',
            'alert-type'=>'success'
        );


        return redirect('/login')->with($notification);
    }
    //end method

    public function Profile()
    {
        //newtersen hereglegchiin id awch baina
        $id=Auth::user()->id;
        //olson idgaaraa user dotroos ali user newtersen baigaag olj baina
        $adminData=User::find($id);
        //tegeed olson medeelelee compactaar url ruu duudaj baina
        return view('admin.admin_profile_view',compact('adminData'));
        //$adminData-g blade deer <h4 class="card-title">User Name : {{ $adminData->username }} </h4> ene mayagaar butsaagaad duudaj baina

        //negent user modeltei holbogson bolohoor hvssen medeelelee awch bolj baina {{ $editData->created_at }},  value="{{ $editData->id }}"  geh met
    }

    public function EditProfile()
    {
        $id=Auth::user()->id;
        $editData=User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));

    }
    public function StoreProfile(Request $request)
    {
        //oloood
        $id=Auth::user()->id;
        $data=User::find($id);

        //haana haana yaj hadgalahiig zaaj baina
        $data->name=$request->name;
        $data->email=$request->email;
        $data->username=$request->username;

        //harin end herwee zurag baiwal baigaa nereer ni db hadgalaad bas public/upload/admin_images folder dotor hadgalna
        if($request->file('profile_image'))
        {
            $file=request()->file('profile_image');

            $filename=date('YmdHi').$file->getClientOriginalName();

            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_image']=$filename;

        }
        $data->save();

        $notification=array(
            'message'=>'admin profile updated successfully',
            'alert-type'=>'success'

        );
        return redirect()->route('admin.profile')->with($notification);
    }

    public function ChangePassword()
    {
        return view('admin.admin_change_password');
    }





    //ene validation-iig sain har mash chuhal
    public function UpdatePassword(Request $request)
    {
        //validation hiihed ingej hiine (-> call gej ene sumiig tawihaar yu yug duudahaa hoinoos ni bichseneer teriig eniig duudna geh meteer ashiglana)
        $validateData=$request->validate([
            'oldpassword'=>'required',
            'newpassword'=>'required',
            'confirm_password'=>'required|same:newpassword',//ene 3 dahi deer ni |same: ashiglaad omnoh newpasswordtoi adilhan baina gesen nohtsol tawij baina

        ]);
        $hashedPassword=Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashedPassword))
        {
            $users=User::find(Auth::id());
            $users->password=bcrypt($request->newpassword);

            $users->save();

            session()->flash('message','Password updated successfully');
            return redirect()->back();
        }
        else{
            session()->flash('message','Old password is not match');
            return redirect()->back();
        }
    }
}
