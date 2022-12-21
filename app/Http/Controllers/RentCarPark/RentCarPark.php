<?php

namespace App\Http\Controllers\RentCarPark;

use App\Http\Controllers\Controller;
use App\Models\RentCarPark\RentCarParkStorage;
use Illuminate\Http\Request;

class RentCarPark extends Controller
{
    /**
     * @var Request
     */
    private Request $request;
    private RentCarParkStorage $carPark;

    public function __construct(Request $request, RentCarParkStorage $carPark)
    {
        $this->request = $request;
        $this->carPark = $carPark;
    }

    /**
     * Возвращает информацию о машине
     * @param $request
     * @return object
     */
    public function getInfo(): object
    {
        $request = $this->request;

        abort_if((integer)$request['id'] == 0, 400);

        return $this->carPark->getInfo((integer)$request['id']);

    }
}
