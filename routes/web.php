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
/* service Container */

/* admin panel */
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {    // Ignores notices and reports all other kinds... and warnings    
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
/* get current location of user */
Route::get('get-location-from-ip',function(){
    $ip= \Request::ip();
    $data = \Location::get($ip);
    dd($data);
});
Route::group(['prefix' => 'admin'], function () {
	Auth::routes();
    Route::match(['get','post'],'/','admin\Home@login');
    Route::match(['get','post'],'','admin\Home@login');
	Route::match(['get','post'],'login','admin\Home@login');
	Route::get('logout','admin\Home@logout');
	Route::match(['get','post'],'register','admin\Home@register');

	Route::get('dashboard','admin\Dashboard@index');
	Route::get('cms/orderss','admin\Dashboard@home');
	Route::get('gift','admin\Cms@gift');
	Route::get('receivepayment','admin\Dashboard@receive');
	Route::post('cms/jobs/delete','admin\Cms@deleteJob');
	Route::get('cms/jobs/update/{id}','admin\Cms@editjob');

	/* setting */
	Route::match(['get','post'],'settings/profile','admin\Setting@profile');
	Route::match(['get','post'],'settings/website','admin\Setting@website');
	Route::get('settings/accounts','admin\Setting@accounts');
	Route::post('settings/mailgun/save','admin\Setting@saveMailgun');
	Route::post('settings/paypal/save','admin\Setting@savePaypal');

	/* user management */
	Route::match(['get','post'],'users/view','admin\Users@viewUsers');
	Route::match(['get','post'],'users/add','admin\Users@addEditUser');
	Route::match(['get','post'],'users/edit/{id}','admin\Users@addEditUser');
	Route::get('users/view/{id}','admin\Users@viewSingleUser');

	Route::delete('user/delete','admin\Users@deleteUser');
	
	Route::match(['get','post'],'users/company','admin\Users@companies');
	Route::match(['get','post'],'users/company/add','admin\Users@addEditCompany');
	Route::match(['get','post'],'users/company/edit/{id}','admin\Users@addEditCompany');
	Route::match(['get','post'],'users/company/editals/{id}','admin\Users@addEditCompanyals');
	Route::get('users/company/{id}','admin\Users@viewCompany');
	Route::delete('company/delete','admin\Users@deleteCompany');

	/* cms */
	/* job categories */
	Route::match(['get','post'],'cms/category','admin\Cms@viewCategories');
	Route::match(['get','post'],'cms/alljobs','admin\Cms@viewjobs');
	Route::match(['get','post'],'cms/publishjobs','admin\Cms@publishjobs');
	Route::match(['get','post'],'cms/draftjobs','admin\Cms@draftjobs');
	Route::post('cms/category/save','admin\Cms@saveCategory');
	Route::get('cms/category/get/{id}','admin\Cms@getCategory');
	Route::delete('cms/category/delete','admin\Cms@deleteCategory');
	Route::match(['get','post'],'cms/category/{id}','admin\Cms@viewSubCategories');
	Route::post('cms/sub-category/save','admin\Cms@saveSubCategory');
	Route::get('cms/sub-category/get/{id}','admin\Cms@getSubCategory');
	Route::delete('cms/sub-category/delete','admin\Cms@deleteSubCategory');
	Route::match(['get','post'],'cms/category/sub/{id}','admin\Cms@viewSubCategories2');
	Route::post('cms/sub-category/save2','admin\Cms@saveSubCategory2');
	Route::get('cms/sub-category/get/{id}/{id2}','admin\Cms@getSubCategory');
	Route::delete('cms/sub-category/delete','admin\Cms@deleteSubCategory');

	Route::post('cms/alljobs/save','admin\Cms@saveMainAD');
	Route::get('cms/alljobs/get/{id}','admin\Cms@getMainAD');

	/* job shift */
	Route::match(['get','post'],'cms/shift','admin\Cms@viewJobShift');
	Route::post('cms/shift/save','admin\Cms@saveJobShift');
	Route::get('cms/shift/get/{id}','admin\Cms@getJobShift');
	Route::delete('cms/shift/delete','admin\Cms@deleteJobShift');

	/* job shift */
	Route::match(['get','post'],'services','admin\Cms@viewservices');
	Route::post('services/save','admin\Cms@saveservices');
	Route::get('services/get/{id}','admin\Cms@getservices');
	Route::delete('services/delete','admin\Cms@deleteservices');

	/* job type */
	Route::match(['get','post'],'cms/jobtype','admin\Cms@viewJobType');
	Route::post('cms/jobtype/save','admin\Cms@saveJobType');
	Route::get('cms/jobtype/get/{id}','admin\Cms@getJobType');
	Route::delete('cms/jobtype/delete','admin\Cms@deleteJobType');

	/* Package Plan */
	Route::match(['get','post'],'cms/plan','admin\Cms@viewplan');
	Route::post('cms/plan/save','admin\Cms@saveplan');
	Route::get('cms/plan/get/{id}','admin\Cms@getplan');
	Route::delete('cms/plan/delete','admin\Cms@deleteplan');
	Route::get('cms/plan/get','admin\Cms@allpackage');
	Route::get('cms/plan/resume','admin\Cms@resumepackage');
	Route::get('cms/plan/jobpckg','admin\Cms@jobspackage');
	Route::post('cms/pckgstatupdate','admin\Cms@pckgstatupdate');
	
	/* upskill type */
	Route::match(['get','post'],'cms/upskilltype','admin\Cms@viewupskillType');
	Route::post('cms/upskilltype/save','admin\Cms@saveupskillType');
	Route::get('cms/upskilltype/get/{id}','admin\Cms@getupskillType');
	Route::delete('cms/upskill/delete','admin\Cms@deleteupskillType');

	/* pages */
	Route::get('cms/news','admin\Cms@viewPages');
	Route::match(['get','post'],'news/new','admin\Cms@addEditNews');
	Route::match(['get','post'],'cms/pages/edit/{id}','admin\Cms@addEditNews');
	Route::delete('cms/pages/delete','admin\Cms@deletePage');
	/* Aprove Writing*/
	Route::get('cms/aprovewriting','admin\Cms@writing');
	Route::post('cms/writestatupdate','admin\Cms@writestatupdate');
	Route::post('cms/jobstatupdate','admin\Cms@jobstatupdate');
	Route::post('cms/viewwriting','admin\Cms@viewwriting');
	Route::post('cms/deletewriting','admin\Cms@deletewriting');
	/*Aprove Upskills*/
	Route::get('cms/aproveskills','admin\Cms@upskills');
	Route::post('cms/viewskill','admin\Cms@viewskill');
	Route::post('cms/deleteskill','admin\Cms@deleteskill');
	Route::post('cms/upskillstatupdate','admin\Cms@upskillstatupdate');
	/*profile pic*/
	
});


Route::post('cropProfileImage','frontend\Home@changepropic');
Route::post('cropCompanyProfileImage','frontend\Home@changecompanypropic');

Route::match(['get','post'],'/','frontend\Home@accountLogin');
Route::match(['get','post'],'account/register','frontend\Home@accountRegister');
Route::get('account/logout','frontend\Home@logout');
Route::get('account/manage','frontend\Home@manageUser');

Route::group(['prefix' => 'account'], function () {
	/* generals */
	
	/*end evalutation routes*/
	Route::post('employer/savecompic','frontend\Home@savecompic');
	
Route::post('jobseeker/profile/picture','frontend\Jobseeker@profilePicture');
	
	Route::post('manage/removeProPic','frontend\Jobseeker@removeProPic');
	/* job seeker */
   
    Route::post('jobseeker/resume/personal/save','frontend\Jobseeker@savePersonalInfo');
    Route::get('get-state/{id}','frontend\Jobseeker@getState');
    Route::get('get-city/{id}','frontend\Jobseeker@getCity');
  

Route::get('jobseeker/userHome','frontend\Jobseeker@homefeed');
Route::post('addpost','frontend\Jobseeker@addpost');
Route::post('addcmt','frontend\Jobseeker@addcmt');
Route::post('replycmt','frontend\Jobseeker@replycmt');
Route::get('post','frontend\Jobseeker@post');
Route::post('delpost/{id}','frontend\Jobseeker@deletedata');
Route::post('delcmt/{id}','frontend\Jobseeker@deletecmt');
Route::get('editcmt/{id}','frontend\Jobseeker@editcmt');	
Route::post('like','frontend\Jobseeker@likepost');
Route::post('dislike/{id}','frontend\Jobseeker@dislike');
Route::get('post/{id}','frontend\Jobseeker@perpost');
Route::post('perlike','frontend\Jobseeker@perlikepost');
Route::post('perdislike/{id}','frontend\Jobseeker@perdislike');	
Route::post('addcmtper','frontend\Jobseeker@cmtperpost');	
Route::get('pereditcmt/{id}','frontend\Jobseeker@editcmt');	
Route::get('news','frontend\Jobseeker@news');
Route::get('news/{id}','frontend\Jobseeker@pernews');		


});
