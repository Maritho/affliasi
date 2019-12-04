<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Auth;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Validator;

class CampaignController extends Controller
{
    public function all(Request $request)
    {
        $campaign = Campaign::select('campaigns.*', 'users.name as user_name')
            ->leftJoin('users', 'campaigns.created_by', '=', 'users.id');

        return DataTables::of($campaign)->make(true);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:500',
            'nama_campaign' => 'required',
            'landing_page' => 'required|url',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::toJson(null, Str::ucfirst($validator->errors()->first()), false);
        }

        $image = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaign/'.date('Y-d'), 'public');
            $image = url('storage').'/'.$path;
        }

        $campaign = new Campaign();
        $campaign->name = $request->nama_campaign;
        $campaign->landing_page = $request->landing_page;
        $campaign->image = $image;
        $campaign->status = $request->status;
        $campaign->created_by = Auth::user($request, true);
        $campaign->save();

        return Response::toJson($campaign);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_campaign' => 'required',
            'landing_page' => 'required|url',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::toJson(null, Str::ucfirst($validator->errors()->first()), false);
        }


        $campaign = Campaign::where('id', $request->id)->first();
        $image = $campaign->image;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaign/'.date('Y-d'), 'public');
            $image = url('storage').'/'.$path;
        }

        $campaign->name = $request->nama_campaign;
        $campaign->landing_page = $request->landing_page;
        $campaign->image = $image;
        $campaign->status = $request->status;
        $campaign->created_by = Auth::user($request, true);
        $campaign->save();

        return Response::toJson($campaign);
    }

    public function delete($id) {
        Campaign::where('id', $id)->delete();
        return Response::toJson();
    }

    public function detail($id) {
        $campaign = Campaign::where('id', $id)->first();
        return Response::toJson($campaign);
    }
}
