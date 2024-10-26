<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Address;

/**
 * Class AddressRepositoryEloquent.
 */
class AddressRepositoryEloquent extends Repository implements AddressRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return Address::class;
    }
}
