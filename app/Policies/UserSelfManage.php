<?php

namespace App\Policies;

use App\Models\User;

class UserSelfManage
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can manage the given user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $targetUser
     * @return bool
     */
    public function manage(User $user, User $targetUser)
    {
        return $user->id === $targetUser->id;
    }
}
