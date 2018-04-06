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
Route::delete('/comment/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'articles.comments.delete'])->middleware('auth');;
Route::get('/getCommentAjax', ['uses' => 'CommentsController@getCommentAjax']);
Route::get('/updateCommentAjax', ['uses' => 'CommentsController@updateCommentAjax']);
Route::put('/updateCommentAjax', ['uses' => 'CommentsController@updateCommentAjax']);

// Обратная связь
Route::get('/feedback', ['uses' => 'FeedbackController@index', 'as' => 'feedback.index']);
Route::post('/feedbackSendAjax', ['uses' => 'FeedbackController@sendAjax']);

// Авторизация
Route::get('login',  ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'auth.login']);
Route::post('login', ['uses' => 'Auth\LoginController@login']);
Route::get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'auth.logout']);
// Регистрация
Route::get('register', ['uses' => 'Auth\RegisterController@showRegistrationForm', 'as' => 'auth.register']);
Route::post('register', 'Auth\RegisterController@register');

//> Админка
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => ['auth', 'ban'],
    'as' => 'admin::'
], function() {
    // Главная
    Route::get('/', ['uses' => 'IndexController@index', 'as' => 'index']);

    //> Группы статей
    Route::resource('articles_categories', 'ArticlesCategoriesController', [
        'names' => [
            'index' => 'articles_categories.index',
            'create' => 'articles_categories.create',
            'store' => 'articles_categories.save',
            'edit' => 'articles_categories.edit',
            'update' => 'articles_categories.update',
            'destroy' => 'articles_categories.delete',
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
            'create' => 'articles.create',
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
    Route::get('/getSettingsAjax', 'SettingsController@getSettingsAjax');
    Route::post('/addSettingAjax', 'SettingsController@addSettingAjax');
    Route::get('/addSettingAjax', 'SettingsController@addSettingAjax');
    Route::put('/updSettingAjax', 'SettingsController@updSettingAjax');
    Route::delete('/delSettingAjax', 'SettingsController@delSettingAjax');

    // Парсинг
    Route::get('/parsing', 'ParsingController@index')->name('parsing.index');
    Route::get('/parsing/{id}', 'ParsingController@show')->name('parsing.show');
    Route::post('/parsing_result', 'ParsingController@handleFile')->name('parsing.result');
    Route::delete('/parsing_delete/{id}', 'ParsingController@deleteTable')->name('parsing.delete');

    //> Пользователя
    Route::resource('/users', 'UsersController', [
        'names' => [
            'index' => 'users.index'
        ]
    ]);
    Route::put('/users/{id}/change_status/{type}', 'UsersController@changeStatus')
        ->name('users.change_status')->where(['type' => 'ban|unban']);
    //<

    // Обратная связь
    Route::get('/feedback', ['uses' => 'FeedbackController@index', 'as' => 'feedback.index']);
    Route::get('/feedback/{id}', ['uses' => 'FeedbackController@show', 'as' => 'feedback.show']);
    Route::post('/feedback/{id}/response', ['uses' => 'FeedbackController@response', 'as' => 'feedback.response_to_user']);
});
//<
