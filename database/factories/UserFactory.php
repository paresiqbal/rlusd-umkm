<?php
namespace Database\Factories;

use App\Models\AdminProfile;
use App\Models\FreelancerProfile;
use App\Models\PartnerProfile;
use App\Models\Role;
use App\Models\Subdistrict;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected static Role $role;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username'          => fake()->userName(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'is_active'         => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): Factory
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function inactive(): Factory
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function freelancer(): Factory
    {
        return $this->selectRole("freelancer")->afterCreating(function ($user) {
            $freelancer               = new FreelancerProfile();
            $freelancer->gender       = $this->faker->numberBetween(1, 2);
            $freelancer->name         = $this->faker->name($freelancer->gender == 1 ? "male" : "female");
            $freelancer->birthplace   = $this->faker->city();
            $freelancer->birthdate    = $this->faker->dateTimeBetween('-50 years', '-20 years');
            $freelancer->phone_number = $this->faker->phoneNumber;
            extract($this->getRandomFullAddress());
            $freelancer->subdistrict_id = $subdistrict_id;
            $freelancer->address        = $address;
            $freelancer->postal_code    = $postal_code;
            $freelancer->about_me       = $this->faker->paragraph(5);
            $freelancer->rating         = 0;
            $freelancer->user_id        = $user->user_id;
            $freelancer->approved_at    = now();
            $freelancer->approved_by    = 1;
            $freelancer->save();
        });
    }

    public function partner(): Factory
    {
        return $this->selectRole("partner")->afterCreating(function ($user) {
            $partner               = new PartnerProfile();
            $partner->partner_name = $this->faker->company();
            $partner->phone_number = $this->faker->phoneNumber;
            extract($this->getRandomFullAddress());
            $partner->subdistrict_id    = $subdistrict_id;
            $partner->address           = $address;
            $partner->postal_code       = $postal_code;
            $partner->rating            = 0;
            $partner->business_class_id = $this->faker->numberBetween(1, 4);
            $partner->partner_sector_id = $this->faker->numberBetween(1, 69);
            $partner->user_id           = $user->user_id;
            $partner->approved_at       = now();
            $partner->organization_id   = $this->faker->numberBetween(1, 5);
            $partner->about_company     = $this->faker->words(15, true);
            $partner->pic_name          = $this->faker->name();
            $partner->pic_email         = $this->faker->email();
            $partner->pic_phone_number  = $this->faker->phoneNumber;
            $partner->pic_position      = $this->faker->jobTitle;
            $partner->approved_by       = 1;
            $partner->save();
        });
    }

    public function admin(): Factory
    {
        return $this->selectRole("admin")->afterCreating(function ($user) {
            $admin               = new AdminProfile();
            $admin->gender       = $this->faker->numberBetween(1, 2);
            $admin->name         = $this->faker->name($admin->gender == 1 ? "male" : "female");
            $admin->phone_number = $this->faker->phoneNumber;
            $admin->user_id      = $user->user_id;
            $admin->save();
        });
    }

    private function selectRole(string $role): Factory
    {
        if (! isset(UserFactory::$role) || (UserFactory::$role && UserFactory::$role?->role_name != $role)) {
            UserFactory::$role = Role::where("role_name", $role)->first();
        }
        // dd(UserFactory::$role);
        return $this->state(fn(array $attributes) => [
            'role_id' => UserFactory::$role->role_id,
        ]);
    }

    private function getRandomFullAddress()
    {
        $subdistrict = Subdistrict::inRandomOrder()->first();
        return [
            'subdistrict_id' => $subdistrict->subdistrict_id,
            "address"        => $this->faker->address,
            "postal_code"    => $this->faker->postcode,
        ];
    }
}
