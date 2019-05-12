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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/map', 'MapController@index')->name('map');
Route::get('/location', 'AreaController@index')->name('location');
Route::get('/inventory', 'InventoryController@index')->name('inventory');
Route::get('/mobfight', 'MobController@fightPageIndex')->name('mobfight');
Route::get('/useitem/{slot}', 'ItemController@useItem')->name('useitem');
Route::get('/destroyitem/{slot}', 'ItemController@destroyItem')->name('destroyitem');
Route::get('/unequip/{slot}', 'ItemController@unequipItem')->name('unequip');

Route::post('/swapslot', "ItemController@swapSlot");
Route::post("/useskillspot",["uses" => "SkillSpotController@useSpot", "as"=>"skillspot.use"]);
Route::post('/getiteminfo', 'ItemController@getInfo');
Route::post("/attackmob",["uses" => "MobController@startMobFight", "as"=>"attack.mob"]);
Route::post("/claimloot",["uses" => "MobController@claimLoot", "as"=>"claim.loot"]);
Route::post("/removefight",["uses" => "MobController@removeFight", "as"=>"remove.fight"]);
Route::post("/cancelfight",["uses" => "MobController@cancelFight", "as"=>"cancel.fight"]);
Route::post("/claimloot",["uses" => "MobController@claimLoot", "as"=>"claim.loot"]);
Route::post("/updatefight", "MobController@updateFight");
Route::post('/travel', ["uses" => "MapController@travel", "as"=>"travel"]);

