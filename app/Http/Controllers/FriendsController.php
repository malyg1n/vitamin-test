<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFriendRequest;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function getUsers()
    {
        return response()->json(User::all());
    }

    // Получить друзей пользователя
    public function getFriends(int $userId)
    {
        $user = User::query()->findOrFail($userId);
        $friends = $user->friends;

        return response()->json($friends);
    }

    // Получить друзей друзей
    public function getFriendsOfFriends(int $userId)
    {
        $user = User::query()->findOrFail($userId);
        $friendsOfFriends = $user->friendsOfFriends();

        return response()->json($friendsOfFriends);
    }

    // Добавить друга
    public function addFriend(CreateFriendRequest $request)
    {
        $user = User::query()->find($request->get('user_id'));

        if (!$user) {
            return response()->json(['status' => 'error'], 400);
        }

        $user->friends()->attach($request->get('friend_id'));
        return response()->json(['status' => 'success'], 200);
    }

    // удалить друга
    public function removeFriend(int $userId, int $friendId)
    {
        $result = Friend::query()->where('user_id', $userId)->where('friend_id', $friendId)->delete();
        if (!$result) {
            return response()->json(['status' => 'error'], 400);
        }

        return response()->json(['status' => 'success'], 200);
    }

}
