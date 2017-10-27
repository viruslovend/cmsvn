<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        // crud post
        $crudPost = new Permission();
        $crudPost->name = "crud-post";
        $crudPost->save();

        // update others post
        $updateOthersPost = new Permission();
        $updateOthersPost->name = "update-others-post";
        $updateOthersPost->save();

        // delete others post
        $deleteOthersPost = new Permission();
        $deleteOthersPost->name = "delete-others-post";
        $deleteOthersPost->save();

        // crud category
        $crudCategory = new Permission();
        $crudCategory->name = "crud-category";
        $crudCategory->save();

        // crud user
        $crudUser = new Permission();
        $crudUser->name = "crud-user";
        $crudUser->save();

        // attach roles permissions
        $admin = Role::whereName('admin')->first();
        $editor = Role::whereName('editor')->first();
        $author = Role::whereName('author')->first();
		
		
		// crud page
        $crudPage = new Permission();
        $crudPage->name = "crud-page";
        $crudPage->save();

        // update others page
        $updateOthersPage = new Permission();
        $updateOthersPage->name = "update-others-page";
        $updateOthersPage->save();

        // delete others page
        $deleteOthersPage = new Permission();
        $deleteOthersPage->name = "delete-others-page";
        $deleteOthersPage->save();
		
        $admin->detachPermissions([$crudPost, $updateOthersPost, $deleteOthersPost, $crudPage, $updateOthersPage, $deleteOthersPage, $crudCategory, $crudUser]);
        $admin->attachPermissions([$crudPost, $updateOthersPost, $deleteOthersPost, $crudPage, $updateOthersPage, $deleteOthersPage, $crudCategory, $crudUser]);

        $editor->detachPermissions([$crudPost, $updateOthersPost, $deleteOthersPost, $crudPage, $updateOthersPage, $deleteOthersPage, $crudCategory]);
        $editor->attachPermissions([$crudPost, $updateOthersPost, $deleteOthersPost, $crudPage, $updateOthersPage, $deleteOthersPage, $crudCategory]);

        $author->detachPermission($crudPost,$crudPage);
        $author->attachPermission($crudPost,$crudPage);
    }
}
