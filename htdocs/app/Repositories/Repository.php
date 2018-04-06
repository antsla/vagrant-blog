<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

abstract class Repository
{
    protected $oModel = false;
    protected $sTablePrefix;

    public function __construct()
    {
        $this->sTablePrefix = DB::getTablePrefix();
    }

    /**
     * Получение произвольных данных из БД
     *
     * @param mixed $mSelect необходимые поял в выборке
     * @param mixed $mOrder поле сортировки
     * @param string $sTypeOrder направление сортировки
     * @param bool $bPaginate наличие пагинации
     * @param int $iLimit количество выбираемых записей
     * @param mixed $mWith загружаемые отношения
     * @return object
     */
    public function get($mSelect = '*', $mOrder = false, $sTypeOrder = 'asc', $bPaginate = false, $iLimit = 0, $mWith = false)
    {
        $oBuilder = $this->oModel->select($mSelect);

        if ($mOrder) {
            $oBuilder->orderBy($mOrder, $sTypeOrder);
        }

        if ($mWith) {
            $oBuilder->with($mWith);
        }

        if ($bPaginate) {
            return $oBuilder->paginate($iLimit);
        }

        return $oBuilder->get();
    }

    /**
     * Получение модели по id
     *
     * @param int $id
     * @return object
     */
    public function getOne($id)
    {
        return $this->oModel->findOrFail($id);
    }
}