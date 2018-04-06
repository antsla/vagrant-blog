<?php



/* САЙТ */



// MainPage
Breadcrumbs::register('main', function ($oBreadcrumbs) {
    $oBreadcrumbs->push(Lang::get('layout.brcr_site_page'), route('MainPage'));
});

// MainPage > Article
Breadcrumbs::register('article.show', function($oBreadcrumbs, $sName) {
    $oBreadcrumbs->parent('main');
    $oBreadcrumbs->push(Lang::get('layout.brcr_article_show', ['name' => $sName]));
});



/* АДМИНКА */



// AdminPage
Breadcrumbs::register('admin::index', function($oBreadcrumbs){
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_admin_page'), route('admin::index'));
});

//> Группы статей
// AdminPage -> ArticlesCategories
Breadcrumbs::register('admin::articles_categories.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_articles_categories_index'), route('admin::articles_categories.index'));
});

// AdminPage -> ArticlesCategories -> Create
Breadcrumbs::register('admin::articles_categories.create', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::articles_categories.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_articles_categories_create'));
});

//AdminPage -> ArticlesCategories -> Edit
Breadcrumbs::register('admin::articles_categories.edit', function($oBreadcrumbs, $sName) {
    $oBreadcrumbs->parent('admin::articles_categories.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_articles_categories_edit', ['name' => $sName]));
});
//<

//> Статьи
// AdminPage -> Articles
Breadcrumbs::register('admin::articles.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_articles_index'), route('admin::articles.index'));
});

// AdminPage -> Articles -> CreateArticle
Breadcrumbs::register('admin::articles.create', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::articles.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_articles_create'));
});

// AdminPage -> Articles -> EditArticle
Breadcrumbs::register('admin::articles.edit', function($oBreadcrumbs, $sName) {
    $oBreadcrumbs->parent('admin::articles.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_articles_edit', ['name' => $sName]));
});
//<

// AdminPage -> Parsing
Breadcrumbs::register('admin::parsing.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_parsing_index'), route('admin::parsing.index'));
});

// AdminPage -> Parsing
Breadcrumbs::register('admin::parsing.processing', function($oBreadcrumbs, $sPostfix) {
    $oBreadcrumbs->parent('admin::parsing.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_parsing_processing', ['postfix' => $sPostfix]), route('admin::parsing.index'));
});

// AdminPage -> Settings
Breadcrumbs::register('admin::settings.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_settings_index'), route('admin::settings.index'));
});

//> Слайдер
// AdminPage -> Slider
Breadcrumbs::register('admin::slider.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_slider_index'), route('admin::slider.index'));
});
// AdminPage -> Slider -> CreateSlider
Breadcrumbs::register('admin::slider.create', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::slider.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_slider_create'), route('admin::slider.create'));
});
// AdminPage -> Slider -> EditSlider
Breadcrumbs::register('admin::slider.edit', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::slider.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_slider_edit'));
});
//<

// AdminPage -> Users
Breadcrumbs::register('admin::users.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_users_index'), route('admin::users.index'));
});

//> Отзывы
// AdminPage -> Feedback
Breadcrumbs::register('admin::feedback.index', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_feedback_index'), route('admin::feedback.index'));
});

// AdminPage -> Feedback -> SingleReview
Breadcrumbs::register('admin::feedback.show', function($oBreadcrumbs) {
    $oBreadcrumbs->parent('admin::feedback.index');
    $oBreadcrumbs->push(Lang::get('admin/layout.brcr_feedback_show'));
});
//<