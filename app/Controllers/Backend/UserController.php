<?php

namespace App\Controllers\Backend;

use App\Core\BaseController;
use App\Core\Route;
use App\Models\User;

class UserController extends BaseController
{
    public function __construct(
        private User $user = new User
    ) {
    }

    #[Route('/admin/users', 'admin.users.index', ['GET'])]
    public function index(): void
    {
        $this->render('Backend/Users/index.php', [
            'users' => $this->user->findAll(),
            'meta' => [
                'title' => 'Administration des users',
            ]
        ]);
    }
}
