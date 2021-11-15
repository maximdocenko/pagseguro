<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Listing;
use App\Models\ListingPlan;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $listings = Listing::where(['user_id' => $user->id])->get();
        return view('content.listing.index', ['listings' => $listings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $plan = UserPlan::where(['user_id' => $user->id])->first()->plan;
        return view('content.listing.create', ['plan' => $plan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $data['user_id'] = $user->id;

        $data['status'] = 'active';

        $plan = UserPlan::where(['user_id' => $user->id])->first()->plan;

        if($plan->type == 'one_time' && $plan->price > 0) {
            $data['status'] = 'pending';
        }

        if($plan->type == 'subscription' && $plan->price > 0) {
            try {
                $agreement = Agreement::where(['user_id' => $user->id])->first()->code;
                if ($agreement) {
                    if ($agreement->status == 'active') {
                        $data['status'] = 'active';
                    }
                }
            }catch (\Throwable $exception) {

                $data['status'] = 'pending';

            }
        }

        $listing = Listing::create($data);

        ListingPlan::create(['listing_id' => $listing->id, 'plan_id' => $user->user_plan->plan_id]);

        return back()->with('success', 'Listing created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
