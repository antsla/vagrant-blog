<?php

namespace App\Repositories;

use App\Models\ParsingList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ParsingListRepository extends Repository
{
    public function __construct(ParsingList $oParsingList)
    {
        parent::__construct();
        $this->oModel = $oParsingList;
    }

    /**
     * Удаление таблицы и записи о ней по id
     * @param integer $iId
     * @return string|\Exception
     */
    public function delete($iId)
    {
        try {
            $sPostfix = ParsingList::find($iId)->postfix;
            Schema::drop('parsing_temp_' . $sPostfix);
            DB::table('parsing_list_tables')->delete($iId);
            return $sPostfix;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Парсинг нового файла
     * @param string $sDate
     * @param array $aHeading названия колонок
     * @param array $aItems
     * @return boolean|\Exception
     */
    function addTable($sDate, $aHeading, $aItems)
    {
        $sTablename = 'parsing_temp_' . $sDate;
        DB::beginTransaction();
        try {
            Schema::create($sTablename, function($table) use ($aHeading)
            {
                $table->increments('id');
                foreach ($aHeading as $kHead => $vHead) {
                    $table->string($vHead);
                }
            });
            DB::table('parsing_list_tables')->insert(['postfix' => $sDate, 'created_at' => \Carbon\Carbon::now()]);
            DB::table($sTablename)->insert($aItems);
            DB::commit();
            return true;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

    /**
     * Получения данных таблицы по ее имени
     * @param string $sTableName
     * @return object
     */
    public function getTableItem($sTableName)
    {
        return DB::table($sTableName)->get();
    }

}