<?php

namespace App\Repository;

use App\Models\Address;

class AddressRepository
{
    public function create(array $data)
    {
        return Address::create($data);
    }
}
