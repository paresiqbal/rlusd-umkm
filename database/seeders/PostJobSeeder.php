<?php
namespace Database\Seeders;

use App\Models\PostJob;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PostJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = PostJob::factory()->count(25)->create();

        // add skill requirements

        if (Skill::count() > 0) {
            $jobs->each(function ($job) {
                $job->skills()->attach(Skill::inRandomOrder()->limit(4)->get());
            });
        }

    }
}
