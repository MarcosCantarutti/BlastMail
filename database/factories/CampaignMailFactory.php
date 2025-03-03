<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignMailFactory extends Factory
{

    public function definition(): array
    {
        return [
            'campaign-id' => Campaign::factory(),
            'subscriber_id' => Subscriber::factory(),
            'sent_at' => fake()->dateTime,
            'clicks' => fake()->numberBetween(1, 10),
            'openings' => fake()->numberBetween(1, 10),
        ];
    }
}
