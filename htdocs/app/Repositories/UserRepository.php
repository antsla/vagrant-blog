<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $oUser)
    {
        parent::__construct();
        $this->oModel = $oUser;
    }

    /**
     * Изменить статус пользователя
     *
     * @param integer $iId
     * @param integer $iStatus тип операции
     * @return boolean|\Exception
     */
    public function chgStatus($iId, $iStatus)
    {
        try {
            $this->oModel->where('id', $iId)->update(['flag_banned' => (int)$iStatus]);
            return true;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }
}