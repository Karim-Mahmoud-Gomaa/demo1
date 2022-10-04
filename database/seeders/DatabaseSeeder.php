<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use Faker\Generator;
use \App\Models\{
    User,Category,Unit,Luxuries,Location,
    Owner,UnitStatus,UnitSource,Finish

};

class DatabaseSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@example.com',
        ]);

    }
}
