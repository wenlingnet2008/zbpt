<?php

namespace App\Policies;

use App\User;
use App\Room;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the room.
     *
     * @param  \App\User  $user
     * @param  \App\Room  $room
     * @return mixed
     */
    public function view(User $user, Room $room)
    {
        $room_roles = $room->roles;
        if($user->hasAnyRole($room_roles)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create rooms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the room.
     *
     * @param  \App\User  $user
     * @param  \App\Room  $room
     * @return mixed
     */
    public function update(User $user, Room $room)
    {
        //
    }

    /**
     * Determine whether the user can delete the room.
     *
     * @param  \App\User  $user
     * @param  \App\Room  $room
     * @return mixed
     */
    public function delete(User $user, Room $room)
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
