<?php

use Illuminate\Support\Facades\Route;
 
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
Route::get('/', 'HomeController@show')->name('home');
Route::get('about', 'AboutController@show');
Route::get('faq', 'FAQController@show');
Route::get('contacts', 'ContactsController@show');
Route::get('browse', 'BrowseController@show')->name('browse.search');

// User Profile
Route::get('user/{user_id}', 'UserController@show')->name('user.show');
Route::get('/user/{user_id}/delete', 'UserController@delete')->name('user.delete');

//User Edit
Route::get('user/{user_id}/edit', 'EditUserController@index')->name('edit.show');
Route::post('user/{user_id}/edit', 'EditUserController@update')->name('user.update');


//User Create Event
Route::get('user/{user_id}/create_event', 'EventController@index')->name('create.show');
Route::post('user/{user_id}/create_event', 'EventController@create')->name('create');

// User Invite
Route::get('user/{user_id}/invite/{invite_id}', 'InviteController@index')->name('create.show');
Route::post('user/{user_id}/invite/{invite_id}', 'InviteController@create')->name('create');

// User Events
Route::get('user/{user_id}/my_events', 'MyEventsController@index');

// User Participations
Route::get('user/{user_id}/my_participations',/*view my participations controller*/);

// Event
Route::get('event/{event_id}', 'EventController@show')->name('event.show');
Route::get('event/{event_id}/delete', 'EventController@delete')->name('event.delete'); 

// Event Edit
Route::get('event/{event_id}/edit', 'EditEventController@show')->name('edit.show');
Route::post('event/{event_id}/edit', 'EditEventController@update')->name('event.update');

// Event Cancel
Route::get('event/{event_id}/cancel', 'EventController@cancel')->name('event.cancel');

//Hosts add participant to event 
Route::get('event/{event_id}/addparticipant', 'EventController@addparticipant')->name('event.addparticipant');

// Report Event
Route::get('event/{event_id}/report', 'ReportEventController@index')->name('create.show');
Route::post('event/{event_id}/report', 'ReportEventController@create')->name('create');

// Announcement Event
Route::get('event/{event_id}/announcement', 'AnnouncementEventController@index')->name('create.show');
Route::post('event/{event_id}/announcement', 'AnnouncementEventController@create')->name('create');
Route::post('event/{event_id}/announcement', 'AnnouncementEventController@announcement')->name('event.announcement');

// Comment Event
Route::get('event/{event_id}/comment', 'CommentEventController@index')->name('create.show');
Route::post('event/{event_id}/comment', 'CommentEventController@create')->name('create');
Route::post('event/{event_id}/comment', 'CommentEventController@comment')->name('event.comment');

// Event Invite
Route::get('event/{event_id}/invite', 'InvitationController@index')->name('invite.show');
Route::post('event/{event_id}/invite', 'InvitationController@invite')->name('invite');

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
Route::get('admin/create_report','AdminReportController@index')->name('create.show');
Route::post('admin/create_report','AdminReportController@create')->name('create');

// Admin manage user
Route::get('admin/user/{user_id}/', /* admin used edit page contoller */);
Route::get('admin/user/{user_id}/delete', 'AdminUserController@remove');

// Admin report
Route::get('admin/report/{report_id}/',/* see reports controller*/);
Route::get('admin/report/{report_id}/delete','AdminReportController@remove');
