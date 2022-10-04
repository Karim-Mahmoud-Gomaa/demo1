<?php

namespace App\Repository\Services;

use \Illuminate\Support\Facades\Facade;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class UserService extends Facade
{
    protected $UserRepository;
    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):User{
        return $this->UserRepository->find($id,$columns,$relations,$appends);
    }
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10,array $filter=[]){
        return $this->UserRepository->index($columns,$relations,$appends,$paginate,$filter);
    }
    public function create(Request $request):int{
        return $this->UserRepository->create($request);
    }
    public function update(int $id,Request $request):bool{
        return $this->UserRepository->update($id,$request);
    }
    public function delete(int $id):bool{
        return $this->UserRepository->delete($id);
    }
    
    ////////////////////////////////////////////////////////////
    public function login(string $phone,string $password){
        return $this->UserRepository->login($phone,$password);
    }
    public function logout($model){
        return $this->UserRepository->logout($model);
    }

}