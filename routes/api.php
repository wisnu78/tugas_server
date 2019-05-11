<?php

Route::get('/mail/check/{id}','MailController@check');
Route::post('/mail','MailController@store');
Route::delete('/mail/{id}/destroy','MailController@destroy');
