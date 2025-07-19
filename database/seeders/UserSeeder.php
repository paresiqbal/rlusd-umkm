<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ["role_name" => "freelancer"],
            ["role_name" => "partner"],
            ["role_name" => "admin"],
        ];

        DB::table("roles")->insert($roles);

        User::factory()->count(1)->admin()->create([
            "email" => "admin@example.org",
        ]);
        User::factory()->count(1)->partner()->create([
            "email" => "mitra@example.org",
        ]);
        User::factory()->count(1)->freelancer()->create(
            ["email" => "user@example.com"]
        );

        User::factory()->count(9)->freelancer()->create();

        User::factory()->count(1)->partner()->create();
    }
}
