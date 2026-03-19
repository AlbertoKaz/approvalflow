<?php

namespace Database\Factories;

use App\Models\ApprovalRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApprovalRequest>
 */
class ApprovalRequestFactory extends Factory
{
    protected $model = ApprovalRequest::class;

    public function definition(): array
    {
        $status = fake()->randomElement([
            ApprovalRequest::STATUS_PENDING,
            ApprovalRequest::STATUS_APPROVED,
            ApprovalRequest::STATUS_REJECTED,
        ]);

        $approvedAt = $status === ApprovalRequest::STATUS_APPROVED ? fake()->dateTimeBetween('-30 days') : null;
        $rejectedAt = $status === ApprovalRequest::STATUS_REJECTED ? fake()->dateTimeBetween('-30 days') : null;

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status' => $status,
            'created_by' => User::query()->inRandomOrder()->value('id'),
            'approved_by' => $status === ApprovalRequest::STATUS_APPROVED ? User::query()->inRandomOrder()->value('id') : null,
            'approved_at' => $approvedAt,
            'rejected_by' => $status === ApprovalRequest::STATUS_REJECTED ? User::query()->inRandomOrder()->value('id') : null,
            'rejected_at' => $rejectedAt,
            'decision_note' => $status !== ApprovalRequest::STATUS_PENDING
                ? fake()->sentence()
                : null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => ApprovalRequest::STATUS_PENDING,
            'approved_by' => null,
            'approved_at' => null,
            'rejected_by' => null,
            'rejected_at' => null,
            'decision_note' => null,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn () => [
            'status' => ApprovalRequest::STATUS_APPROVED,
            'approved_by' => User::query()->inRandomOrder()->value('id'),
            'approved_at' => now()->subDays(rand(1, 15)),
            'rejected_by' => null,
            'rejected_at' => null,
            'decision_note' => fake()->sentence(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn () => [
            'status' => ApprovalRequest::STATUS_REJECTED,
            'approved_by' => null,
            'approved_at' => null,
            'rejected_by' => User::query()->inRandomOrder()->value('id'),
            'rejected_at' => now()->subDays(rand(1, 15)),
            'decision_note' => fake()->sentence(),
        ]);
    }
}
