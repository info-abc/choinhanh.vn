<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// $collection = Pages::all();

// Sitemap::addCollection($collection, 'url-prefix');

// return Response::make(Sitemap::getSitemapXml())
//     ->header('Content-Type', 'text/xml');
App::missing(function($exception)
{
	if(Request::segment(3) && strpos(Request::url(), '/games/')){
		$errorType = ERROR_TYPE_MISSING;
	} else {
		$errorType = ERROR_TYPE_404;
	}
    // Log::error( Request::url() );
    return CommonLog::logErrors($errorType);
});

Route::get('/trang-khong-ton-tai', 'SiteController@returnPage404');

Route::group(['prefix' => 'admin'], function () {

	Route::get('/login', array('uses' => 'AdminController@login', 'as' => 'admin.login'));
	Route::post('/login', array('uses' => 'AdminController@doLogin'));
	Route::get('/logout', array('uses' => 'AdminController@logout', 'as' => 'admin.logout'));
	Route::resource('/', 'AdminController');

	Route::get('/manager/changepassword/{id}', array('uses' => 'ManagerController@changePassword', 'as' => 'admin.manager.chanpassword'));
	Route::post('/manager/updatePassword/{id}', array('uses' => 'ManagerController@updatePassword'));
	Route::get('/manager/search', array('uses' => 'ManagerController@search', 'as' => 'admin.manager.search'));
	Route::get('/manager/searchHistory', array('uses' => 'ManagerController@searchHistory', 'as' => 'admin.manager.search'));
	Route::get('/manager/search/{id}', array('uses' => 'ManagerController@history', 'as' => 'admin.manager.history'));
	Route::post('/manager/search/{id}', array('uses' => 'ManagerController@deleteHistory', 'as' => 'admin.manager.history.delete'));
	Route::resource('/manager', 'ManagerController');

	Route::get('/category_parent/content/create', array('uses' => 'CategoryParentController@contentCreate', 'as' => 'content.create'));
	Route::get('/category_parent/content/edit/{id}', array('uses' => 'CategoryParentController@contentedit', 'as' => 'content.edit'));
	Route::get('/category_parent/content', array('uses' => 'CategoryParentController@contentIndex', 'as' => 'content.index'));
	Route::resource('/category_parent', 'CategoryParentController');

	Route::resource('/category', 'CategoryController');

	Route::get('/games/Searchstatistic', array('uses' => 'AdminGameController@searchStatisticGame', 'as' => 'admin.games.statistic'));
	Route::get('/games/statistic', 'AdminGameController@statisticGame');
	Route::post('/games/deleteSelected', 'AdminGameController@deleteSelected');
	Route::post('/games/updateIndexData', 'AdminGameController@updateIndexData');
	Route::get('/games/search', array('uses' => 'AdminGameController@search', 'as' => 'admin.games.search'));
	Route::get('/games/history/{id}', array('uses' => 'AdminGameController@history', 'as' => 'admin.games.history'));
	Route::post('/games/history/{id}', array('uses' => 'AdminGameController@deleteHistory', 'as' => 'admin.games.history.delete'));
	Route::resource('/games', 'AdminGameController');

	Route::get('/gametype/search', array('uses' => 'GameTypeController@search', 'as' => 'admin.gametype.search'));
	Route::resource('/gametype', 'GameTypeController');

	Route::resource('/tags', 'AdminTagController');

	Route::resource('/newstype', 'NewsTypeController');

	Route::post('/news/history/{id}', array('uses' => 'NewsController@deleteHistory', 'as' => 'admin.news.history.delete'));
	Route::get('/news/history/{id}', array('uses' => 'NewsController@history', 'as' => 'admin.news.history'));
	Route::get('/news/search', array('uses' => 'NewsController@search', 'as' => 'admin.news.search'));
	Route::resource('/news', 'NewsController');

	Route::post('/relation/ajax', 'RelationController@ajax');
	Route::post('/relation/ajaxedit/{id}', array('uses' => 'RelationController@ajaxedit', 'as' => 'ajax.edit'));
	Route::resource('/relation', 'RelationController');

	Route::get('/comment/search', array('uses' =>  'CommentController@search', 'as' => 'admin.comment.search'));
	Route::post('/comment/deleteSelected', 'CommentController@deleteSelected');
	Route::post('/comment/updateIndexData', 'CommentController@updateIndexData');
	Route::post('/comment/updateCommentInactive', 'CommentController@updateCommentInactive');
	Route::resource('/comment', 'CommentController');

	Route::post('/score/updateScore', 'ScoreManagerController@updateScore');
	Route::get('/score/search', array('uses' =>  'ScoreManagerController@search', 'as' => 'admin.score.search'));
	Route::resource('/score', 'ScoreManagerController');


	Route::get('/advertise_child', 'AdvertiseController@indexChild');
	Route::get('/create/advertise_child', 'AdvertiseController@createChild');
	Route::post('/create/advertise_child', 'AdvertiseController@storeChild');
	Route::get('/edit/advertise_child/{id}/{model_id}', 'AdvertiseController@editChild');
	Route::put('/edit/advertise_child/{id}/{model_id}', 'AdvertiseController@updateChild');
	Route::delete('/delete/advertise_child/{id}', 'AdvertiseController@destroyChild');
	Route::resource('/advertise', 'AdvertiseController');

	Route::post('/feedback/updateIndexData', 'FeedbackController@updateIndexData');
	Route::post('/feedback/updateInActive', 'FeedbackController@updateInActive');
	Route::get('/feedback/search', array('uses' =>  'FeedbackController@search', 'as' => 'admin.feedback.search'));
	Route::resource('/feedback', 'FeedbackController');

	Route::post('/feedback_game/updateIndexData', 'FeedbackGameController@updateIndexData');
	Route::post('/feedback_game/updateInActive', 'FeedbackGameController@updateInActive');
	Route::get('/feedback_game/search', array('uses' =>  'FeedbackGameController@search', 'as' => 'admin.feedback_game.search'));
	Route::resource('/feedback_game', 'FeedbackGameController');

	Route::post('/errors/deleteErrors', 'ErrorsController@deleteErrors');
	Route::post('/errors/deleteAll', 'ErrorsController@deleteAllErrors');
	Route::get('/errors/search', array('uses' =>  'ErrorsController@search', 'as' => 'admin.errors.search'));
	Route::resource('/errors', 'ErrorsController');
	Route::get('/errors/logs/{id}', array('uses' => 'ErrorLogsController@log'));

	Route::get('/addseometa', 'SeoController@seoMeta');
	Route::post('/seo/addseometa', array('uses' => 'SeoController@addSeoMeta'));
	Route::get('/seo/addseometa/{id}', array('uses' => 'SeoController@editSeoMeta'));
	Route::put('/seo/addseometa/{id}', array('uses' => 'SeoController@doEditSeoMeta'));
	Route::resource('/seo', 'SeoController');

	Route::resource('/policy', 'PolicyController');
	Route::post('/image_slider/delete/{id}', 'AdminSlideController@deleteSlide');
	Route::get('/slider/search', array('uses' => 'AdminSlideController@search', 'as' => 'admin.slide.search'));
	Route::resource('/slider', 'AdminSlideController');

	Route::get('/user/chanpassword/{id}', array('uses' =>  'UserController@changePassword', 'as' => 'admin.user.chanpassword'));
	Route::get('/user/search', array('uses' =>  'UserController@search', 'as' => 'admin.user.search'));
	Route::resource('/user', 'UserController');

	

});

// $games = Game::all();
//  foreach ($games as $key => $value) {
//  	if($value->start_date) {
//  		$startDate = convertDateTime($value->start_date);
//  		$value->update(array('start_date' => $startDate));
//  	}
//  }
// dd(12);

// FRONTEND
// return json for mobile app
Route::get('/sitemap.xml', 'SiteMapController@index');
Route::resource('/sitemap', 'SiteMapController');

// Route::resource('/testgame', 'TestGameController');
Route::get('/testgame', array('uses' =>  'TestGameController@index', 'as' => 'admin.testgame.index'));
Route::post('/testgame/{testId}', array('uses' =>  'TestGameController@updateTest', 'as' => 'admin.testgame.update'));

Route::get('/api/list', array('uses' => 'ApiController@index', 'as' => 'api'));
Route::get('/api/search', array('uses' => 'ApiController@search', 'as' => 'api_search'));

Route::get('/api/search', array('uses' => 'ApiController@search', 'as' => 'api_search'));

Route::get('/changepassword', array('uses' => 'PasswordController@changePass', 'as' => 'password.changepass'));
Route::resource('/resetpassword', 'PasswordController', array('only'=>array('store', 'index')));

Route::post('/vote-game', array('uses' => 'GameController@voteGame', 'as' => 'vote-game'));
Route::post('/count-play', array('uses' => 'GameController@countPlay', 'as' => 'count-play'));
Route::post('/count-download', array('uses' => 'GameController@countDownload', 'as' => 'count-download'));
Route::post('/score-gname', array('uses' => 'GameController@score', 'as' => 'score-gname'));

Route::get('/dang-nhap', array('uses' => 'SiteController@login', 'as' => 'login'));
Route::post('/dang-nhap', array('uses' => 'SiteController@doLogin'));
Route::get('/dang-xuat', array('uses' => 'SiteController@logout', 'as' => 'logout'));

//login facebook
Route::get('/login_fb', 'LoginFacebookController@loginfb');
Route::get('/login-fb-callback', 'LoginFacebookController@callback');

//login google
Route::get('/login_google', 'GoogleController@logingoogle');

Route::get('/dang-ky', array('uses' => 'AccountController@create', 'as' => 'register'));
Route::post('/dang-ky', array('uses' => 'AccountController@store'));
Route::get('/thong-tin-tai-khoan', array('uses' => 'AccountController@account', 'as' => 'account'));
Route::put('/thong-tin-tai-khoan', array('uses' => 'AccountController@doAccount'));

Route::get('/gop-y', array('uses' => 'SiteFeedbackController@create', 'as' =>'feedback'));
Route::post('/gop-y', array('uses' => 'SiteFeedbackController@store'));
Route::post('/bao-loi-game', array('uses' => 'SiteFeedbackController@errorGame', 'as' =>'error_game'));
Route::put('/bao-loi-game', array('uses' => 'SiteFeedbackController@createErrorGame'));
Route::get('/chinh-sach', array('uses' => 'SiteFeedbackController@policy', 'as' =>'policy'));

Route::post('/send-error-game', array('uses' => 'SiteFeedbackController@sendErrorGame'));

Route::get('/tim-kiem-game', array('uses' => 'SearchGameController@index', 'as' => 'searchGame'));

Route::get('/tin-tuc/{slug}', array('uses' => 'SiteNewsController@show', 'as' =>'showNews'));
Route::get('/tin-tuc', array('uses' => 'SiteNewsController@index', 'as' => 'listNews'));

Route::put('/comment/{id}', array('uses' => 'SiteCommentController@update'));

Route::get('/game-android', 'GameController@getListGameAndroid');

Route::get('/game-binh-chon-nhieu', 'GameController@getListGameVote');

Route::get('/game-hay-nhat', 'GameController@getListGameplay');

Route::get('/game-moi-nhat', 'GameController@getListGamenew');

Route::post('/import-menu', 'GameController@importMenu');
Route::post('/import-bxh', 'GameController@importBxh');

Route::get('/list_g5', 'GameController@listGameHtml5');
Route::get('/list_flash', 'GameController@listGameFlash');

Route::get('/home', 'SiteIndexController@home');

Route::resource('/', 'SiteIndexController');

Route::get('/game-{slug}', 'GameController@listgame');

Route::get('/game-{type}/{slug}', 'GameController@detailGame');

Route::get('/{type}/{slug}/{word}', 'GameController@getPage404');
