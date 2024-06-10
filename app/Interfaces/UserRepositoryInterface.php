<?php

namespace App\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function login(array $credentials);
    public function logout();
    public function refresh();
}
