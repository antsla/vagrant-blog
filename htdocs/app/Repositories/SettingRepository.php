<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends Repository
{
    public function __construct(Setting $oSetting)
    {
        parent::__construct();
        $this->oModel = $oSetting;
    }

    /**
     * Добавление настройки в БД
     *
     * @param \Illuminate\Http\Request $request
     * @return integer|\Exception
     */
    public function addSetting($request)
    {
        try {
            $oSetting = new Setting();
            $oSetting->name = $request->name;
            $oSetting->value = $request->value;
            $oSetting->save();
            return $oSetting->id;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Обновление настройки
     *
     * @param integer $iId
     * @param \Illuminate\Http\Request $request
     * @return integer|\Exception
     */
    public function updSetting($iId, $request)
    {
        try {
            $oSetting = Setting::find($iId);
            $oSetting->name = $request->name;
            $oSetting->value = $request->value;
            $oSetting->save();
            return $oSetting->id;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Удаление настройки
     *
     * @param integer $iId
     * @return boolean|\Exception
     */
    public function delSetting($iId)
    {
        try {
            Setting::destroy($iId);
            return true;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }
}