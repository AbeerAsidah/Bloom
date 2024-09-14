<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;


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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// // Register private channel for chat
// Broadcast::channel('chat.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('private-chat.{type}.{id}', function ($user, $type, $id) {
    // return (int) $user->id === (int) $id;//
    Log::info('Authorization Check:', ['user' => $user, 'type' => $type, 'id' => $id]);

        return $user->id === (int) $id && $user->type === (string) $type;

});



