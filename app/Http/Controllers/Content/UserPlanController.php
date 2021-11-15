<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserPlanController extends Controller
{
    public function select($id) {

        if (Auth::check()) {

            $user = Auth::user();

            $plan = Plan::find($id);

            if(!isset($user->user_plan)) {
                UserPlan::create(['user_id' => $user->id, 'plan_id' => $id]);
                Session::put('plan_id', $id);
            }else{
                if($user->user_plan->plan->type == 'one_time' && $plan->type == 'one_time') {
                    UserPlan::where(['user_id' => $user->id])->update(['plan_id' => $id]);
                    Session::put('plan_id', $id);
                }elseif($user->user_plan->plan->type == 'one_time' && $plan->type == 'subscription') {
                    return back()->with('message', 'You cannot select a subscription plan');
                }elseif($user->user_plan->plan->type == 'subscription' && $plan->type == 'one_time') {
                    return back()->with('message', 'You cannot select a one time plan');
                }elseif($user->user_plan->plan->type == 'subscription' && $plan->type == 'subscription') {
                    return back()->with('message', 'You cannot change your subscription plan right now');
                }else{
                    return back()->with('message', 'There was some error. Please try again later');
                }
            }

            return redirect(route('listing.create'));

        } else {

            Session::put('plan_id', $id);

            return redirect(route('register'));

        }



    }

    public function test() {
        var_dump(Session::get('plan_id'));
    }

}
