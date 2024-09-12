<?php

use App\Http\Controllers\FriendsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('users', [FriendsController::class, 'getUsers']);
    Route::get('friends/{userId}', [FriendsController::class, 'getFriends']);
    Route::get('friends-of-friends/{userId}', [FriendsController::class, 'getFriendsOfFriends']);
    Route::post('friends', [FriendsController::class, 'addFriend']);
    Route::delete('friends/{userId}/{friendId}', [FriendsController::class, 'removeFriend']);
});
