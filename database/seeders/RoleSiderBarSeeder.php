<?php

namespace Database\Seeders;

use App\Models\RoleSiderBarJoin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSiderBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 1, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 2, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 3, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 4, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 5, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 6, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 7, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 8, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 9, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 10, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 11, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 12, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 13, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 14, 
            'permission' => true
        ]);
        RoleSiderBarJoin::create([
            'role_id' => 1, 
            'siderbar_id' => 15, 
            'permission' => true
        ]);
    }
}
