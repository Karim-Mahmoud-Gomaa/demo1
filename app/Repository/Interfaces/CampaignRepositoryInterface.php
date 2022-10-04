<?php

namespace App\Repository\Interfaces;
use App\Models\Campaign;
use Illuminate\Http\Request;

interface CampaignRepositoryInterface {
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Campaign;
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10,array $filter=[]);
    public function create(Request $request):int;
    public function update(int $id,Request $request):bool;
    public function delete(int $id):bool;
    //////////////////////////////////////////////////////
    public function AddImage(int $id,string $name):bool;
    public function RemoveImage(int $id,string $name):bool;
}