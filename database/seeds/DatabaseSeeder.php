<?php

use Illuminate\Database\Seeder;
use App\Service\Acl\Role\Role;
use App\Domain\League\League;
use App\Service\Acl\User\User;
use App\Service\Acl\UserRole\UserRole;
use App\Service\Acl\Permission\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedAcl();
    }

    private function seedAcl()
    {
        $changeUserRole = factory(Permission::class)->create(['name' => 'change_user_role']);
        $publishArticle = factory(Permission::class)->create(['name' => 'publish_article']);
        
        $adminRole = factory(Role::class)->create(['name' => 'admin'])
            ->givePermission($changeUserRole)
            ->givePermission($publishArticle);

        $publisherRole = factory(Role::class)->create(['name' => 'publisher'])
            ->givePermission($publishArticle);

        $league = factory(League::class)->create(['name' => 'Example League']);

        $adminUser = factory(User::class)
            ->create(['name' => 'Gruppen Admin', 'email' => 'admin@test.de', 'password' => bcrypt('123456')])
            ->join($league);
        factory(UserRole::class)->create(['user_id' => $adminUser->id, 'role_id' => $adminRole->id, 'league_id' => $league->id]);

        $publisherUser = factory(User::class)
            ->create(['name' => 'Gruppen Publisher', 'email' => 'publisher@test.de', 'password' => bcrypt('123456')])
            ->join($league);
        factory(UserRole::class)->create(['user_id' => $publisherUser->id, 'role_id' => $publisherRole->id, 'league_id' => $league->id]);
    }
}
