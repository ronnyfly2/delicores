<?php

namespace App\Repositories\Api;

use App\Repositories\RepositoryBase;
use App\User;

use Illuminate\Support\Facades\Hash;

class UserRepository extends RepositoryBase
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct()
    {
        $this->model = new User;
    }

    // Get all instances of model
    public function index()
    {
        return request()->user();
    }

    // create a new record in the database
    public function store(array $data)
    {

        try {

            $data['password'] = Hash::make($data['password']);
            return $this->model->create($data);

        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function login(array $data)
    {
        try {
            $user =  $this->model->where('email', $data['email'])->first();

            if(!$user)
                throw new \Exception(_i("Usuario y/o contraseña inválida."), 400);

            if(!Hash::check($data['password'], $user->password))
                    throw new \Exception(_i("Usuario y/o contraseña inválida."), 400);

            $user->bearer_token = $user->createToken($user->name)->accessToken;

            return $user;

        } catch(\Exception $e) {
            throw $e;
        }
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model-findOrFail($id);
    }

}
