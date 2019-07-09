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
Route::get('/map', 'MapController@index')->name('map');
Route::get('/location', 'AreaController@index')->name('location');
Route::get('/inventory', 'InventoryController@index')->name('inventory');
Route::get('/mobfight', 'MobController@fightPageIndex')->name('mobfight');

//profile
Route::get('/profile', 'ProfileController@index');
Route::get('/profile/{name}', 'ProfileController@indexByName');
//edit profile
Route::get('/editprofile', 'ProfileController@editIndex');
Route::post('editprofile', 'ProfileController@updateAvatar');
Route::post('/updatedesc', 'ProfileController@updateDescription')->name("updateDesc");
//titles
Route::get('/titles', 'TitleController@titlesIndex');
Route::post('selecttitle', 'TitleController@selectTitle');
Route::post('removetitle', 'TitleController@removeTitle');
//combat settings
Route::get('/settings', 'ProfileController@settings');
Route::post('/combatfocus', "ProfileController@setCombatFocus")->name('setCombatFocus');;
//inventory
Route::post('/swapslot', "ItemController@swapSlot");
Route::post('/getiteminfo', 'ItemController@getInfo');
Route::post('/unequip', 'InventoryController@unequipItem');
Route::post('/useitem', 'InventoryController@useItem');
Route::post('/destroyitem', 'InventoryController@destroyItem');
//bank
Route::get('/bank', 'BankController@index');
//skilling
Route::post("/useskillspot",["uses" => "SkillSpotController@useSpot", "as"=>"skillspot.use"]);
//mobs/fighting
Route::post("/attackmob",["uses" => "MobController@startMobFight", "as"=>"attack.mob"]);
Route::post("/claimloot",["uses" => "MobController@claimLoot", "as"=>"claim.loot"]);
Route::post("/removefight",["uses" => "MobController@removeFight", "as"=>"remove.fight"]);
Route::post("/cancelfight",["uses" => "MobController@cancelFight", "as"=>"cancel.fight"]);
Route::post("/claimloot",["uses" => "MobController@claimLoot", "as"=>"claim.loot"]);
Route::post("/updatefight", "MobController@updateFight");
//map
Route::post('/travel', ["uses" => "MapController@travel", "as"=>"travel"]);
//npc
Route::post('/npcinteract', ["uses" => "NpcController@interact", "as"=>"npc.interact"]);
//dialogue
Route::post("/enddialogue", "NpcController@endDialogue");
//objects
Route::post('/objectinteract', ["uses" => "ObjectController@interact", "as"=>"object.interact"]);
//skillactions
Route::get('/skillaction', 'SkillActionController@index')->name('skillaction');
Route::post('/action', ["uses" => "SkillActionController@startAction", "as"=>"start.action"]);
Route::post('/completeaction', ["uses" => "SkillActionController@completeAction", "as"=>"completeaction"]);
Route::post('/selectaction', ["uses" => "SkillActionController@selectAction", "as"=>"selectaction"]);
//shops
Route::post('/buyshopitem', ["uses" => "ShopController@buyItem", "as"=>"shop.buy"]);
Route::post('/sellshopitem', ["uses" => "ShopController@sellItem", "as"=>"shop.sell"]);
Route::get('/shop/{shopId}', 'ShopController@shopIndex');
//market
Route::get('/market', 'MarketController@index');
Route::get('/newlisting', 'MarketController@newListingIndex');
Route::post("/searchmarket", "MarketController@search");
Route::post("/buylisting", "MarketController@buyListing");
Route::post("/collectlisting", "MarketController@collectListing");
Route::post("/cancellisting", "MarketController@cancelListing");
Route::post("/submitlisting", "MarketController@submitListing");
//highscores
Route::get('/highscores/', 'HighscoresController@redirect');
Route::get('/highscores/{pageNum}', 'HighscoresController@index');
Route::get('/highscores/{skillname}/{pageNum}', 'HighscoresController@skillIndex');
Route::post('/highscores', ["uses" => "HighscoresController@getPage", "as"=>"highscores.getPage"]);

