<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }
    public function save(array $data){
        $data['password'] = bcrypt($data['password']);
        return parent::save($data);
    }

    public function login(array $credentials){
        $token = auth()->attempt($credentials);
        if (!$token){
            throw new HttpResponseException(response('Password incorrect for: '. $credentials['email'], Response::HTTP_UNAUTHORIZED));
        }
        return [
            'token' => $token,
            'minutes_to_expire' => auth()->factory()->getTTL()
        ];
    }

    public function logout(){
        auth()->logout();
        return 'Successfully logged out';
    }

    public function refresh(){
        return [
            'token' => auth()->refresh(),
            'minutes_to_expire' => auth()->factory()->getTTL()
        ];
    }

}
