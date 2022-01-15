<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition() {
        return [
            'is_published' => $this->faker->boolean(70),
            'title' => $this->faker->unique->realTextBetween(5, 30),
            'description' => $this->faker->realTextBetween(250, 500),
            'text' => $this->faker->realTextBetween(300, 1500),
            'published_at' => $this->faker->dateTimeBetween('-2 months', '+2 weeks')
        ];
    }
}
