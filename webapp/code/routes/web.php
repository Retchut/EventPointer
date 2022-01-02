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

// Pages
Route::get('/', 'HomeController@show');
Route::get('about', 'AboutController@show');
Route::get('faq', 'FAQController@show');
Route::get('contacts', 'ContactsController@show');
Route::get('browse', 'BrowseController@show');

// User Profile
Route::get('user/{user_id}', 'UserController@show');

//User Edit
Route::get('user/{user_id}/edit', /*'UserController@edit'*/);
/* Cria-se novo controller para uma nova página para editar, onde se faz depois a edição, e aí sim, chama-se o método edit? */

//User Create Event
Route::get('user/{user_id}/create_event', /*create event form*/);
Route::post('user/{user_id}/create_event', /*create event controller*/);

// User Ivite
Route::get('user/{user_id}/invite/{invite_id}', /*invitation form*/);
Route::post('user/{user_id}/invite/{invite_id}', /*invitation controler*/);

// User Events
Route::get('user/{user_id}/my_events',/*view my events controller*/);

// User Participations
Route::get('user/{user_id}/my_participations',/*view my participations controller*/);

// Event
Route::get('event/{event_id}', 'EventController@show');
Route::delete('event/{event_id}/', 'EventController@delete'); /* Missing logic */

// Event Edit
Route::get('event/{event_id}/edit', /*edit event form*/);
Route::post('event/{event_id}/edit', /*edit event controller*/);

// Event Invite
Route::get('event/{event_id}/invite', /*invite to event form*/);
Route::post('event/{event_id}/invite', /*invite to event controller*/);

// Event Participants
Route::get('event/{event_id}/participants',/*participants controller*/);
Route::delete('event/{event_id}/participants/{participant_id}',/*delete participant controller*/);

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


//API
Route::get('api/events',/*search events controller*/);
Route::get('api/users',/*search users controller*/);

//Announcements and Comments
// TODO

// Admin Profile
Route::get('admin/{admin_id}', 'AdminController@show');

// Admin Create Report
Route::get('admin/create_report',/*create report form*/);
Route::post('admin/create_report',/*create report form*/);

// Admin manage user
Route::get('admin/user/{user_id}/', /* admin used edit page contoller */);
Route::get('admin/user/{user_id}/delete', /*delete user controller*/);

// Admin report
Route::get('admin/report/{report_id}/',/* see reports controller*/);
Route::get('admin/report/{report_id}/delete',/*delete report controller*/);
