<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function storeOrder(array $data);
}