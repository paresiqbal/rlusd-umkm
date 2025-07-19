<?php
namespace Database\Factories;

use App\Models\Education;
use App\Models\EmploymentType;
use App\Models\JobType;
use App\Models\Sector;
use App\Models\Subdistrict;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostJob>
 */
class PostJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role'               => $this->faker->jobTitle(),
            'job_desc'           => $this->faker->paragraphs(2, true),
            'qualifications'     => $this->generateList(10),
            'employment_type_id' => EmploymentType::inRandomOrder()->pluck('employment_type_id')->first(),
            'job_type_id'        => JobType::inRandomOrder()->pluck('job_type_id')->first(),
            'job_category_id'    => Sector::inRandomOrder()->pluck('sector_id')->first(),
            'min_education_id'   => Education::inRandomOrder()->pluck('education_id')->first(),
            'subdistrict_id'     => $this->generateLocation(),
            'address'            => $this->faker->address(),
            'status'             => collect(['publish', 'closed', 'draft'])->random(),
            'number_sdm'         => $this->faker->numberBetween(1, 10),
            'service_type_id'    => $this->faker->numberBetween(1, 6),
            'genders'            => $this->faker->numberBetween(1, 3),

            // 'approved_at'=> now(),
            'created_by'         => User::where('role_id', '=', 2)->inRandomOrder()->pluck('user_id')->first(),

        ];
    }

    private function generateList($count = 3)
    {
        $result = [];

        for ($i = 0; $i < $count; $i++) {
            array_push($result, '- ' . $this->faker->sentence(3));
        }

        return implode(' ', $result);
    }

    private function generateSalary()
    {
        $step      = 100000;
        $minSalary = $this->faker->numberBetween(1, 50) * $step;
        $maxSalary = $minSalary + ($this->faker->numberBetween(1, 50) * $step);

        return [
            'min_salary'       => $minSalary,
            'max_salary'       => $maxSalary,
            'is_hidden_salary' => $this->faker->numberBetween(0, 1),
        ];
    }

    private function generateLocation()
    {
        $subdistrict = Subdistrict::inRandomOrder()->pluck('subdistrict_id')->first();

        return $subdistrict;
    }
}
