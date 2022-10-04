<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Facades\CampaignFacade as Campaign;
use App\Models\Campaign as CampaignModel;
use Illuminate\Support\Facades\File;

class CampaignsController extends Controller
{
    public $successStatus = 200;
    public function index(Request $request)
    {
        $filter=json_decode($request->filter?$request->filter:"{}", true);
        $success['campaigns']=Campaign::index(['*'],['created_by'],[],10,$filter);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:100',
            'from'=>'required|date',
            'to'=>'nullable|date',
            'total'=>'required',
            'daily_budget'=>'required',
        ]);
        
        $success=Campaign::create($request);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    /**
    * Update the specified resource in storage.
    *
    * @param    \Illuminate\Http\Request  $request
    * @param    \App\OrderDetail  $campaign
    * @return  \Illuminate\Http\Response
    */
    public function update(Request $request,CampaignModel $campaign)
    {
        $request->validate([
            'name'=>'required|max:100',
            'from'=>'required|date',
            'to'=>'nullable|date',
            'total'=>'required',
            'daily_budget'=>'required',
        ]);
        
        $success=Campaign::update($campaign->id,$request);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param    \App\OrderDetail  $campaign
    * @return  \Illuminate\Http\Response
    */
    public function destroy(CampaignModel $campaign)
    {
        $success=Campaign::delete($campaign->id);
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'campaign_id'=>'required|exists:campaigns,id',
            'file'=>'image|mimes:jpg,jpeg,png,gif,svg,webp',
        ]);
        
        $name=time().rand(1111,9999);
        $image=$request->file;
        $fullName = $name.'.'.$image->getClientOriginalExtension();
        $image->move(public_path("assets/images/campaigns/".$request->campaign_id), $fullName);
        Campaign::AddImage($request->campaign_id,$fullName);
        
        return response()->json(['success' => $fullName], $this->successStatus);
    }
    public function RemoveImage(Request $request)
    {
        $this->validate($request, [
            'campaign_id'=>'required|exists:campaigns,id',
            'image_name'=>'required',
        ]);

        $path='assets/images/campaigns/'.$request->campaign_id;
            if(File::exists(public_path($path))){
                File::delete(public_path($path.'/'.$request->image_name));
            }
        $success=Campaign::RemoveImage($request->campaign_id,$request->image_name);
        
        return response()->json(['success' => $success], $this->successStatus);
    }
    
}
