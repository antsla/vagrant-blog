<?php

namespace App\Repositories;

use App\Models\Slider;
use Illuminate\Support\Facades\DB;

class SliderRepository extends Repository
{
    public function __construct(Slider $oSlider)
    {
        parent::__construct();
        $this->oModel = $oSlider;
    }

    /**
     * Добавление слайда
     *
     * @param string $sName
     * @param string $sDesc
     * @return boolean|\Exception
     */
    public function addSlide($sName, $sDesc)
    {
        try {
            $this->oModel->fill([
                'img' => $sName,
                'text' => trim(stripslashes(strip_tags($sDesc))),
                'sort' => DB::table('slider')->max('sort') + 1
            ])->push();
            return true;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Обновление слайда
     *
     * @param string $sName
     * @param string $sDesc
     * @param int $id
     * @return \App\Models\Article|\Exception
     */
    public function updSlide($sName, $sDesc, $id)
    {
        try {
            $oSlide = $this->oModel->findOrFail($id);
            $oSlide->img = $sName;
            $oSlide->text = trim(stripslashes(strip_tags($sDesc)));
            $oSlide->save();
            return $oSlide;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Удаление слайда
     *
     * @param int $id
     * @return bool|\Exception
     */
    public function delSlide($id)
    {
        try {
            $this->oModel->destroy($id);
            return true;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Сортировка слайдов
     *
     * @param integer $iId
     * @param string $sDirection направление сортировки
     * @return boolean|\Exception
     */
    public function order($iId, $sDirection)
    {
        DB::beginTransaction();
        try {
            $oSlide = $this->getOne($iId);
            if ($sDirection === 'up') {
                Slider::where(['sort' => $oSlide->sort - 1])->update(['sort' => $oSlide->sort]);
                $oSlide->sort--;
                $oSlide->save();
            } else if ($sDirection === 'down') {
                Slider::where(['sort' => $oSlide->sort + 1])->update(['sort' => $oSlide->sort]);
                $oSlide->sort++;
                $oSlide->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

}