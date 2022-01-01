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

// Home
Route::get('/', 'HomeController@show');
//Route::get('/home', 'HomeController@show');



// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


// Indiviual Profile
Route::get('user/{user_id}', /*view user profile controller*/);
Route::get('user/{user_id}/edit', /*user edit page form controller*/);


// Event
Route::get('event/{event_id}', /*view event controller*/);
Route::get('user/{user_id}/create_event', /*create event form*/);
Route::post('user/{user_id}/create_event', /*create event controller*/);
Route::get('event/{id}/edit', /*edit event form*/);
Route::post('event/{event_id}/edit', /*edit event controller*/);
Route::delete('event/{event_id}/', /*delete event controller*/);
Route::get('event/{event_id}/invite', /*invite to event form*/);
Route::post('event/{event_id}/invite', /*invite to event controller*/);
Route::get('user/{user_id}/invite/{invite_id}', /*invitation form*/);
Route::post('user/{user_id}/invite/{invite_id}', /*invitation controler*/);
Route::get('event/{event_id}/participants',/*participants controller*/);
Route::delete('event/{event_id}/participants/{participant_id}',/*delete participant controller*/);

//API

Route::get('api/events',/*search events controller*/);
Route::get('api/users',/*search users controller*/);


// Event Participation and Ownership
Route::get('user/{user_id}/my_events',/*view my events controller*/);
Route::get('user/{user_id}/my_participations',/*view my participations controller*/);

//Announcements and Comments
// TODO

// Static pages
Route::get('faq', /*FAQ CONTROLLER*/);
Route::get('about', /*about CONTROLLER*/);
Route::get('services', /*services CONTROLLER*/);
Route::get('contacts', /*contacts CONTROLLER*/);


// Admin
Route::get('admin/user/{user_id}/delete', /*delete user controller*/);
Route::get('admin/create_report',/*create report form*/);
Route::post('admin/create_report',/*create report form*/);
Route::get('admin/report/{report_id}/delete',/*delete report controller*/);
