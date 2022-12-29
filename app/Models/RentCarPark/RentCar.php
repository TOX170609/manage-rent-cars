<?php

namespace App\Models\RentCarPark;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentCar extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, bool>
     */
    protected $fillable = [
        'created_at',
        'updated_at',
        'brand',
        'yearProduce',
        'carMileage',
        'color',
        'active',
        'renovation',
        'rented',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rent_cars';
}
