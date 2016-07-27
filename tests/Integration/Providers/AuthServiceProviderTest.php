<?php

namespace Test\Integration\Domain\User;

use TestCase;
use App\Domain\User\User;
use App\Domain\User\Role;
use App\Domain\User\Permission;
use App\Providers\AuthServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthServiceProviderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_checks_of_the_given_permission_is_associated_with_the_logged_in_user()
    {
        $permission = factory(Permission::class)->create();
        $forbidden = factory(Permission::class)->create();
        $user = $this->userWithPermission($permission);
        $this->actingAs($user);

        $authServiceProvider = new AuthServiceProvider('');
        $authServiceProvider->boot(app(Gate::class));

        $this->assertTrue(app(Gate::class)->allows($permission->name));
        $this->assertTrue(app(Gate::class)->denies($forbidden->name));
        $this->assertTrue($user->can($permission->name));
        $this->assertTrue($user->cannot($forbidden->name));
    }

    private function userWithPermission($permission)
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        
        $role->givePermission($permission);
        $user->addRole($role);

        return $user;
    }
}
