<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Coach;

use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;

use Notification;

use App\Notifications\EmailNotification;

class AdminController extends Controller
{
    public function addview()
    {

        if(Auth::id())
        {
            if(Auth::user()->usertype==1)
            {
                return view('admin.add_coach');
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect('login');
        }


    	
    }

    public function upload(Request $request)
    {

    	$coach=new coach;
    	$image=$request->file;

    	$imagename=time().'.'.$image->getClientOriginalExtension();

    	$request->file->move('coachimage',$imagename);
    	$coach->image=$imagename;

    	$coach->name=$request->name;
    	$coach->phone=$request->number;
    	$coach->time=$request->time;
    	$coach->type=$request->type;

    	$coach->save();


    	return redirect()->back()->with('message','Coach Added Successfully');

    }

    public function current_appointments(Request $request)
    {
        $showdata=appointment::all();
        return view('admin.current_appointments',compact('showdata'));
    }
    public function approved($id)
    {
        $data=appointment::find($id);

        $data->status='Approved';

        $data->save();

        return redirect()->back();
    }

    public function cancelled($id)
    {
        $data=appointment::find($id);

        $data->status='Cancelled';

        $data->save();

        return redirect()->back();
    }

    public function show_coaches(Request $request)
    {
        $showdata=coach::all();
        return view('admin.show_coaches',compact('showdata'));
    }

    public function deletecoach($id)
    {

        $data=coach::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function updatecoach($id)
    {
        $data=coach::find($id);
        return view('admin.update_coach',compact('data'));
    }

    public function editcoach(Request $request , $id)
    {
        $coach=coach::find($id);
        $coach->name=$request->name;
        $coach->phone=$request->phone;
        $coach->type=$request->type;
        $coach->time=$request->time;
        $image=$request->file;

        if($image)
        {

            
            $imagecurrent=time().'.'.$image->getClientOriginalExtension();

            $request->file->move('coachimage',$imagecurrent);

            $coach->image=$imagecurrent;

        }
        $coach->save();
        return redirect()->back()->with('message','Coach Information Updated Successfully');
    }

    public function sendemail($id)
    {
        $data=appointment::find($id);

        return view('admin.send_email_view',compact('data'));
    }

    public function emailnotify(Request $request, $id)
    {

        $data= appointment::find($id);
        $info=[
            'greeting'=>$request->greeting,
            'body'=>$request->body,
            'additionaltext'=>$request->additionaltext,
            'meetlink'=>$request->meetlink,
            'ending'=>$request->ending


        ];
        Notification::send($data,new EmailNotification($info));
        return redirect()->back();

    }


}
