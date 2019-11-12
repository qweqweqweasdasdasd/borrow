<?php

/**
 *	前台
 */

Route::get('jiekuan','Wap\JiekuanController@index');
Route::post('jiekuan/submit','Wap\JiekuanController@submit');