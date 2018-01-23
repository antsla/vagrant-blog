<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//> Установка локали
Route::get('/setlocale/{locale}', function($sLocale) {
    if (in_array($sLocale, Config::get('settings.user.locales'))) {
        Cookie::queue('locale', $sLocale, 0);
    }
    return redirect()->back();
})->where('locale', '[a-z]{2}')->name('setLocale');
//<

// Главная страница
Route::get('/', ['uses' => 'IndexController@index', 'as' => 'MainPage']);
Route::get('/getFilterArticlesAjax', ['uses' => 'IndexController@getFilterArticlesAjax']);

// Статьи
Route::get('/articles/{id}', 'ArticlesController@show')->name('articles.show');
Route::post('/save_comment/{id}', 'ArticlesController@saveComment')->name('articles.save_comment');

// Комментарии
Route::put('/comment/{id}', ['uses' => 'CommentsController@restore', 'as' => 'articles.comments.restore']);
Route::delete('/comment/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'articles.comments.delete']);
Route::get('/getCommentAjax', ['uses' => 'CommentsController@getCommentAjax']);
Route::put('/updateCommentAjax', ['uses' => 'CommentsController@updateCommentAjax']);

// Обратная связь
Route::get('/feedback', ['uses' => 'FeedbackController@index', 'as' => 'feedback.index']);
Route::post('/feedbackSendAjax', ['uses' => 'FeedbackController@sendAjax']);

// Авторизация
Route::get('login',  ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'auth.login']);
Route::post('login', ['uses' => 'Auth\LoginController@login'])->name('login');
Route::get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'auth.logout']);
// Регистрация
Route::get('register', ['uses' => 'Auth\RegisterController@showRegistrationForm', 'as' => 'auth.register']);
Route::post('register', 'Auth\RegisterController@register')->name('register');

//> Админка
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => 'auth',
    'as' => 'admin::'
], function() {
    // Главная
    Route::get('/', ['uses' => 'MainController@index', 'as' => 'index']);

    //> Группы статей
    Route::resource('articles_groups', 'ArticlesGroupsController', [
        'names' => [
            'index' => 'articles.groups.index',
            'create' => 'articles.groups.create',
            'store' => 'articles.groups.save',
            'edit' => 'articles.groups.edit',
            'update' => 'articles.groups.update',
            'destroy' => 'articles.groups.delete',
        ],
        'except' => [
            'show',
        ]
    ]);
    //<

    //> Статьи
    Route::resource('articles', 'ArticlesController', [
        'names' => [
            'index' => 'articles.index',
            'create' => 'articles.new',
            'store' => 'articles.save',
            'edit' => 'articles.edit',
            'update' => 'articles.update',
            'destroy' => 'articles.delete',
        ],
        'except' => [
            'show',
        ]
    ]);
    //<

    //> Слайдер
    Route::resource('slider', 'SliderController', [
        'names' => [
            'index' => 'slider.index',
            'create' => 'slider.create',
            'store' => 'slider.store',
            'edit' => 'slider.edit',
            'update' => 'slider.update',
            'destroy' => 'slider.delete'
        ],
        'except' => [
            'show',
        ]
    ]);
    Route::get('/slider/order', 'SliderController@orderAjax');
    //<

    // Настройки
    Route::get('/settings', 'SettingsController@index')->name('settings.index');
    Route::get('/getSettingsAjax', 'SettingsController@getSettings');
    Route::post('/addSettingAjax', 'SettingsController@addSetting');
    Route::put('/updSettingAjax', 'SettingsController@updSetting');
    Route::delete('/delSettingAjax', 'SettingsController@delSetting');

    // Парсинг
    Route::get('/parsing', 'ParsingController@index')->name('parsing.index');
    Route::post('/parsing_result', 'ParsingController@handleFile')->name('parsing.parsing_result');
    Route::delete('/parsing_delete', 'ParsingController@deleteFile')->name('parsing.delete_file');

    // Пользователя
    Route::resource('/users', 'UsersController', [
        'names' => [
            'index' => 'users.index'
        ]
    ]);

    // Обратная связь
    Route::get('/feedback', ['uses' => 'FeedbackController@index', 'as' => 'feedback.index']);
    Route::get('/feedback/{id}', ['uses' => 'FeedbackController@show', 'as' => 'feedback.show']);
    Route::post('/feedback/response', ['uses' => 'FeedbackController@response', 'as' => 'feedback.response_to_user']);
});
//<
