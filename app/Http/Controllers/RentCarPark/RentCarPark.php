<?php

namespace App\Http\Controllers\RentCarPark;

use App\Http\Controllers\Controller;
use App\Models\RentCarPark\RentCarParkStorage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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
     * Добавление нового автомобиля в базу данных
     * @return string
     */
    public function setCar(): string
    {
        $request = $this->request->all();
        abort_if(empty($request['brand']), 400, 'Не удалось добавить новый автомобиль - не была передана модель машины!');
        return $this->carPark->setCar($request['brand'], (integer)$request['yearProduce'], (integer)$request['carMileage'], $request['color']);
    }

    /**
     * Получение списка автомобилей, с возможностью выборки по состоянию автомобиля
     * (готов к аренде, в ремонте, уже в аренде)
     * @return Collection
     */
    public function list(): Collection
    {
        $request = $this->request->all();
        abort_if(empty($request['all']) || empty($request['param_id']), 400, 'Не удалось получить список автомобилей');
        if ($request['all'] == 'true') {
            return $this->carPark->list(true, false);
        } else {
            return $this->carPark->list(false, $request['param_id']);
        }

    }

    /**
     * Обновление данных об автомобиле
     * @return string
     */
    public function updateCar(): string
    {
        $request = $this->request->all();
        abort_if(empty($request['id']), 400, 'Обновить данные об автомобиле не удалось. Не передан идентификационный номер');
        $active = $request['active'] == 'true';
        $renovation = $request['renovation'] == 'true';
        $rented = $request['rented'] == 'true';
        return $this->carPark->updateCar((integer)$request['id'], $request['color'], $active, $renovation, $rented);
    }

    /**
     * Возвращает информацию о машине
     * @return object
     */
    public function getInfo(): object
    {
        $request = $this->request;
        abort_if((integer)$request['id'] == 0, 400, 'Не передан идентификационный номер автомобиля');
        return $this->carPark->getInfo((integer)$request['id']);
    }

    /**
     * Удаление машины из базы данных
     * @return string
     */
    public function deleteCar(): string
    {
        $request = $this->request->all();
        abort_if((integer)$request['id'] == 0, 400, 'Не передан идентификационный номер автомобиля');
        return $this->carPark->deleteCar((integer)$request['id']);
    }
}
