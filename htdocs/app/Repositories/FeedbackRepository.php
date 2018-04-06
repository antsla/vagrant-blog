<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository extends Repository
{
    public function __construct(Feedback $oFeedback)
    {
        parent::__construct();
        $this->oModel = $oFeedback;
    }

    /**
     * Добавление отзыва
     *
     * @param array $request
     * @return bool успешность добавления отзыва
     */
    public function addFeedback($request)
    {
        $aData = [];
        $aData['name'] = htmlentities(strip_tags(trim($request['name'])));
        $aData['email'] = $request['email'];
        $aData['text'] = htmlentities(strip_tags(trim($request['text'])));
        $this->oModel->fill($aData);

        if ($this->oModel->push()) {
            return true;
        }
        return false;
    }
}