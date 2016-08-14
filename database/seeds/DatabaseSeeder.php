<?php

use Illuminate\Database\Seeder;
use App\Service\Acl\Role\Role;
use App\Domain\League\League;
use App\Service\Acl\User\User;
use App\Service\Acl\UserRole\UserRole;
use App\Service\Acl\Permission\Permission;
use App\Domain\Activity\Activity;

class DatabaseSeeder extends Seeder
{
    private $chache = [];
    public function run()
    {
        Artisan::call('migrate:refresh');
        $this->seedAcl();
        $this->seedActivities();
    }

    private function seedActivities()
    {
        factory(Activity::class, 10)->create(['league_id' => $this->exampleLeague()->id]);
        factory(League::class, 5)->create()->each(function($league) {
            factory(Activity::class, 5)->create(['league_id' => $league->id]);
        });
    }

    private function seedAcl()
    {
        $adminUser = factory(User::class)
            ->create(['name' => 'Gruppen Admin', 'email' => 'admin@test.de', 'password' => bcrypt('123456')])
            ->join($this->exampleLeague());
        factory(UserRole::class)
            ->create(['user_id' => $adminUser->id, 'role_id' => $this->adminRole()->id, 'league_id' => $this->exampleLeague()->id]);

        $publisherUser = factory(User::class)
            ->create(['name' => 'Gruppen Publisher', 'email' => 'publisher@test.de', 'password' => bcrypt('123456')])
            ->join($this->exampleLeague());
        factory(UserRole::class)
            ->create(['user_id' => $publisherUser->id, 'role_id' => $this->publisherRole()->id, 'league_id' => $this->exampleLeague()->id]);
    }

    private function exampleLeague()
    {
        if (!isset($this->chache['exampleLeague'])) {
            $this->chache['exampleLeague'] = factory(League::class)->create(['name' => 'Example League']);
        }
        return $this->chache['exampleLeague'];
    }

    private function adminRole()
    {
        if (!isset($this->chache['adminRole'])) {
            $this->chache['adminRole'] = factory(Role::class)->create(['name' => 'admin'])
            ->givePermission($this->changeUserPermission())
            ->givePermission($this->publishArticlePermission());
        }
        return $this->chache['adminRole'];
    }

    private function publisherRole()
    {
        if (!isset($this->chache['publisherRole'])) {
            $this->chache['publisherRole'] = factory(Role::class)
                ->create(['name' => 'publisher'])
                ->givePermission($this->publishArticlePermission());
        }
        return $this->chache['publisherRole'];
    }

    private function changeUserPermission() {
        if (!isset($this->chache['changeUserPermission'])) {
            $this->chache['changeUserPermission'] = factory(Permission::class)->create(['name' => 'change_user_role']);
        }
        return $this->chache['changeUserPermission'];
    }

    private function publishArticlePermission() {
        if (!isset($this->chache['publishArticlePermission'])) {
            $this->chache['publishArticlePermission'] = factory(Permission::class)->create(['name' => 'publish_article']);
        }
        return $this->chache['publishArticlePermission'];
    }
}
