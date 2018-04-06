<?php

namespace App\Http\Controllers\Admin;

use App\Models\ParsingList;
use App\Repositories\ParsingListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Excel;
use Illuminate\Support\Facades\Validator;

class ParsingController extends AdminController
{
    public function __construct(ParsingListRepository $oRep_pl)
    {
        parent::__construct();
        $this->oRep_pl = $oRep_pl;
    }

    public function index()
    {
        if (Gate::denies('parsingFiles', new ParsingList())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return view('admin/parsing/index', array(
            'sTitle' => Lang::get('admin/parsing.title_index'),
            'sBreadcrumbs' => 'admin::parsing.index',
            'oTables' => $this->oRep_pl->get('*'),
        ));
    }

    public function show($id)
    {
        if (Gate::denies('parsingFiles', new ParsingList())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oParsingTable = $this->oRep_pl->getOne((int) $id)->postfix;
        } catch (\Exception $oExc) {
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }
        $oParsingTableFull = 'parsing_temp_' . $oParsingTable;
        try {
            $aItems = $this->oRep_pl->getTableItem($oParsingTableFull);
        } catch (\Exception $oExc) {
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }
        $aHeading = array_keys((array) $aItems[0]);

        return view('admin/parsing/handle_file', array(
            'sTitle' => Lang::get('admin/parsing.title_index'),
            'sBreadcrumbs' => 'admin::parsing.processing',
            'sTableName' => $oParsingTable,
            'items' => $aItems,
            'heading' => $aHeading
        ));
    }

    public function handleFile(Request $request)
    {
        if (Gate::denies('parsingFiles', new ParsingList())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        //> Валидация
        $oValidator = Validator::make($request->only('file'), [
            'file' => 'required|mimes:csv,txt'
        ], [
            'file.required' => Lang::get('admin/parsing.valid_req'),
            'file.mimes' => Lang::get('admin/parsing.valid_mimes'),
        ]);
        if ($oValidator->fails()) {
            return redirect(route('admin::parsing.index'))
                ->withErrors($oValidator->errors()->all());
        }
        //<

        //> Обработка файла
        $file = $request->file('file')->getRealPath();
        $oItems = Excel::load($file)->get()->toArray();

        $aItems = array();
        foreach ($oItems as $aitem) {
            $aItems[] = $aitem;
        }
        $aHeading = array_keys($aitem);
        //<

        //> Вставка данных в БД
        $sDate = date('Y_m_d-H_i_s');
        $this->oRep_pl->addTable($sDate, $aHeading, $aItems);
        //<

        return view('admin/parsing/handle_file', array(
            'sTitle' => Lang::get('admin/parsing.title_index'),
            'sBreadcrumbs' => 'admin::parsing.processing',
            'sTableName' => $sDate,
            'items' => $aItems,
            'heading' => $aHeading
        ));

    }

    /**
     * @param $iId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTable($iId)
    {
        $oRes = $this->oRep_pl->delete((int) $iId);

        if ($oRes instanceof \Exception) {
            return redirect(route('admin::parsing.index'))
                ->withErrors(['message' => Lang::get('admin/parsing.err_delete')]);
        }

        return redirect(route('admin::parsing.index'))
            ->with(['message' => Lang::get('admin/parsing.suc_delete', ['id' => $iId, 'postfix' => $oRes])]);
    }
}
