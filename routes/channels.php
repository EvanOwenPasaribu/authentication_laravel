<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('group.{id}', function ($user, $id) {
    return ['id' => $user->id, 'name' => $user->name];
    return true;
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence.1', function ($user) {
    // dd($user);
    return $user;
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('notification', function () {
    return true;
});