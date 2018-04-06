<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SlideRequest;
use App\Models\Slider;
use App\Repositories\SliderRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class SliderController extends AdminController
{
    public function __construct(SliderRepository $oRep_s)
    {
        parent::__construct();
        $this->oRep_s = $oRep_s;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/slider/index')
            ->with([
                'sTitle' => Lang::get('admin/slider.title_index'),
                'sBreadcrumbs' => 'admin::slider.index',
                'oSlides' => $this->oRep_s->get('*', 'sort', 'asc')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('changeSlider', new Slider())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return view('admin/slider/create')
            ->with([
                'sTitle' => Lang::get('admin/slider.title_create'),
                'sBreadcrumbs' => 'admin::slider.create'
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SlideRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        if (Gate::denies('changeSlider', new Slider())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }
        try {
            if (Input::hasFile('sl_img')) {
                $oFile = Input::file('sl_img');
                $oImage = Image::make($oFile);
                $sNewName = str_random(20) . '.' . $oFile->getClientOriginalExtension();
                $oImage->heighten(300)->save('img/' . config('settings.user.slider_image_dir') . '/' . $sNewName);
                $oImage->widen(100)->save('img/' . config('settings.user.slider_image_dir') . '/thumb/' . $sNewName);
            } else {
                throw new \Exception('File not found!');
            }
        } catch (\Exception $oExc) {
            $oUser = Auth::user();
            if (isset($sNewName)) $this->deleteImages($sNewName);
            Log::error('Ошибка добавления слайда, пользователь [' . $oUser->id . ']' . $oUser->name . '.',
                [
                    'error_message' => $oExc->getMessage()
                ]
            );
            return redirect(route('admin::slider.index'))
                ->withErrors(['message' => Lang::get('admin/slider.error_add')]);
        }

        $oRes = $this->oRep_s->addSlide($sNewName, $request->sl_text);
        if ($oRes instanceof \Exception) {
            $oUser = Auth::user();
            $this->deleteImages($sNewName);
            Log::error('Ошибка добавления слайда, пользователь [' . $oUser->id . ']' . $oUser->name . '.',
                [
                    'error_message' => $oRes->getMessage()
                ]
            );
            return redirect(route('admin::slider.index'))
                ->withErrors(['message' => Lang::get('admin/slider.error_add')]);
        }

        return redirect(route('admin::slider.index'))
            ->with(['message' => Lang::get('admin/slider.success_add')]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('changeSlider', new Slider())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return view('admin/slider/edit')
            ->with([
                'oSlide' => $this->oRep_s->getOne($id),
                'sTitle' => Lang::get('admin/slider.title_edit'),
                'sBreadcrumbs' => 'admin::slider.edit'
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('changeSlider', new Slider())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oSlide = $this->oRep_s->getOne($id);
        } catch (ModelNotFoundException $oExc) {
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        try {
            if (Input::hasFile('sl_img')) {
                $oFile = Input::file('sl_img');
                $oImage = Image::make($oFile);
                $sNewName = str_random(20) . '.' . $oFile->getClientOriginalExtension();
                $oImage->heighten(300)->save('img/' . config('settings.user.slider_image_dir') . '/' . $sNewName);
                $oImage->widen(100)->save('img/' . config('settings.user.slider_image_dir') . '/thumb/' . $sNewName);
            }
        } catch (\Exception $oExc) {
            $oUser = Auth::user();
            Log::error('Ошибка обновления слайда, пользователь [' . $oUser->id . ']' . $oUser->name . '.',
                [
                    'error_message' => $oExc->getMessage()
                ]
            );
            return redirect(route('admin::slider.index'))
                ->withErrors(['message' => Lang::get('admin/slider.error_upd')]);
        }

        $oRes = $this->oRep_s->updSlide(isset($sNewName) ? $sNewName : $oSlide->img, $request->sl_text, $id);
        if ($oRes instanceof \Exception) {
            $oUser = Auth::user();
            if (isset($sNewName)) $this->deleteImages($sNewName);
            Log::error('Ошибка обновления слайда, пользователь [' . $oUser->id . ']' . $oUser->name . '.',
                [
                    'error_message' => $oRes->getMessage()
                ]
            );
            return redirect(route('admin::slider.index'))
                ->withErrors(['message' => Lang::get('admin/slider.error_upd')]);
        }

        if (isset($sNewName)) $this->deleteImages($oSlide->img);

        return redirect(route('admin::slider.index'))
            ->with(['message' => Lang::get('admin/slider.success_upd', ['id' => $oSlide->id])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('changeSlider', new Slider())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oSlide = $this->oRep_s->getOne($id);
        } catch (ModelNotFoundException $oExc) {
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        $oRes = $this->oRep_s->delSlide($id);
        if ($oRes instanceof \Exception) {
            $oUser = Auth::user();
            Log::error('Ошибка удаления слайда, пользователь [' . $oUser->id . ']' . $oUser->name . '.',
                [
                    'error_message' => $oRes->getMessage()
                ]
            );
            return redirect(route('admin::slider.index'))
                ->withErrors(['message' => Lang::get('admin/slider.error_add')]);
        }

        $this->deleteImages($oSlide->img);

        return redirect(route('admin::slider.index'))
            ->with(['message' => Lang::get('admin/slider.del_success', ['id' => $oSlide->id])]);
    }

    /**
     * Сортировка слайдов
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orderAjax(Request $request)
    {
        if (Gate::denies('changeSlider', new Slider())) {
            return Response::json(['result' => 'error', 'data' => $request->id]);
        }

        $oRes = $this->oRep_s->order((int) $request->id, $request->direction);

        if ($oRes instanceof \Exception) {
            return Response::json(['result' => 'error', 'data' => $request->id]);
        }

        return Response::json([
            'result' => 'success',
            'data' => view('admin/slider/_slides_table', ['oSlides' => $this->oRep_s->get('*', 'sort', 'asc')])->render()
        ]);
    }

    /**
     * Очистка файлов связанных со слайдом
     * @param string $sName название файла
     */
    private function deleteImages($sName)
    {
        if (File::exists('img/' . config('settings.user.slider_image_dir') . '/' . $sName)) {
            File::delete('img/' . config('settings.user.slider_image_dir') . '/' . $sName);
        }

        if (File::exists('img/' . config('settings.user.slider_image_dir') . '/thumb/' . $sName)) {
            File::delete('img/' . config('settings.user.slider_image_dir') . '/thumb/' . $sName);
        }
    }
}
