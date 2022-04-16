<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Coach;
use App\Models\Appointment;

class HomeController extends Controller
{

    public function redirect()
    {
    	if(Auth::id())
    	{
    		if(Auth::user()->usertype=='0')
    		{
                $coach = coach::all();

    			return view('user.home',compact('coach'));
    		}
    		else
    		{
    			return view('admin.home');
    		}

    	}
    	else 
    	{
    		return redirect()->back();

    	}
    } 

    public function index()
    {
        if(Auth::id())
        {
            return redirect('home');
        }
        else
        {
    


        $coach = coach::all();
    	return view('user.home',compact('coach'));
    }

    }




    public function login()
    {
    	return view('login');
	}
	public function register()
	{
    	return view('register');
	}


    public function appointment(Request $request)
    {
        
    


        $data = new appointment;
        $data->name=$request->name;
        $data->email=$request->email;

        $data->phone=$request->number;

        $data->note=$request->note;

        $data->date=$request->date;

        $data->coach=$request->coach;
        $data->status='In Progress';

        if(Auth::id())
        {

        $data->user_id=Auth::user()->id;

        }

        $data->save();

        return redirect()->back()->with('message','Request Successfull. You will be contacted soon');
    }


    public function myappointmentlist()
    {

        if(Auth::id())
        {

            $userid=Auth::user()->id;
            $appointlist=appointment::where('user_id',$userid)->get();

            return view('user.my_appointment_list',compact('appointlist'));
        }
        else
        {
            return redirect()->back();
        }

    }

    public function user_appoint_cancel($id)
    {

        $data=appointment::find($id);
        $data->delete();

        return redirect()->back();
    }

}