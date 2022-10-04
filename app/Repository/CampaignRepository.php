<?php

namespace App\Repository;

use App\Models\Campaign;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CampaignRepository implements CampaignRepositoryInterface
{
    // use AuthCampaignRepository;
    /**
    * @var Model
    */
    protected $model;
    
    /**
    * BaseRepository constructor.
    *
    * @param Model $model
    */
    public function __construct(Campaign $model)
    {
        $this->model = $model;
    }
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Campaign{
        return $this->model->select($columns)->with($relations)->find($id)->append($appends);
    }
    
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10,array $filter=[]){
        $data= $this->model->select($columns)->with($relations)
        ->when(isset($filter['from']),function($q) use($filter){
            $q->whereDate('created_at','>=',Carbon::create($filter['from'])->format('Y-m-d'));
        })
        ->when(isset($filter['to']),function($q) use($filter){
            $q->whereDate('created_at','<=',Carbon::create($filter['to'])->format('Y-m-d'));
        });
        
        if($paginate>0){$data=$data->paginate($paginate);}else{$data=$data->get();}
        if($appends){foreach ($data as $value) {$value->append($appends);}}
        return $data;
    }
    public function create(Request $request):int{
        $model=$this->model->create([
            'name'=>$request->name,
            'total'=>$request->total,
            'user_id'=>$request->user()->id,
            'from'=>Carbon::create($request->from),
            'daily_budget'=>$request->daily_budget,
            'to'=>($request->to)?Carbon::create($request->to):null,
        ]);
        return $model->id; 
    }
    public function update(int $id,Request $request):bool{
        $model=$this->model->find($id);
        $model->update([
            'name'=>($request->name)?$request->name:$model->name,
            'total'=>($request->total)?$request->total:$model->total,
            'to'=>($request->to)?Carbon::create($request->to):$model->to,
            'from'=>($request->from)?Carbon::create($request->from):$model->from,
            'daily_budget'=>($request->daily_budget)?$request->daily_budget:$model->daily_budget,
        ]);
        return true; 
    }
    
    public function delete(int $id):bool{
        
        $model=$this->model->find($id);
        return ($model->delete())?true:false;
    }
    
    public function AddImage(int $id,string $name):bool{
        $model=$this->model->find($id);
        $images=($model->images)?$model->images:[];
        array_push($images,$name);
        $model->update(['images'=>$images]);
        return true;
    }
    public function RemoveImage(int $id,string $name):bool{
        $model=$this->model->find($id);
        $images=($model->images)?$model->images:[];
        $new=[];
        foreach ($images as $image) {
            if($image!=$name){
                array_push($new,$image);
            }
        }
        $model->update(['images'=>$new]);
        return true;
    }
    
}