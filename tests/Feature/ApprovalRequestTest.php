<?php

use App\Models\ApprovalRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an approval request', function () {
    $user = User::factory()->create();

    $request = ApprovalRequest::create([
        'title' => 'Approve new supplier contract',
        'description' => 'Budget approval for Q2 vendor onboarding.',
        'status' => ApprovalRequest::STATUS_PENDING,
        'created_by' => $user->id,
    ]);

    expect($request)->toBeInstanceOf(ApprovalRequest::class)
        ->and($request->title)->toBe('Approve new supplier contract')
        ->and($request->description)->toBe('Budget approval for Q2 vendor onboarding.')
        ->and($request->status)->toBe(ApprovalRequest::STATUS_PENDING)
        ->and($request->created_by)->toBe($user->id);
});

it('approves a pending request', function () {
    $user = User::factory()->create();

    $request = ApprovalRequest::factory()->pending()->create();

    $request->approve($user->id);

    $request->refresh();

    expect($request->status)->toBe(ApprovalRequest::STATUS_APPROVED)
        ->and($request->approved_by)->toBe($user->id)
        ->and($request->approved_at)->not->toBeNull()
        ->and($request->rejected_by)->toBeNull()
        ->and($request->rejected_at)->toBeNull();
});

it('rejects a pending request', function () {
    $user = User::factory()->create();

    $request = ApprovalRequest::factory()->pending()->create();

    $request->reject($user->id);

    $request->refresh();

    expect($request->status)->toBe(ApprovalRequest::STATUS_REJECTED)
        ->and($request->rejected_by)->toBe($user->id)
        ->and($request->rejected_at)->not->toBeNull()
        ->and($request->approved_by)->toBeNull()
        ->and($request->approved_at)->toBeNull();
});

it('does not approve a non-pending request', function () {
    $user = User::factory()->create();

    $request = ApprovalRequest::factory()->approved()->create();

    $originalApprovedBy = $request->approved_by;
    $originalApprovedAt = $request->approved_at;

    $request->approve($user->id);

    $request->refresh();

    expect($request->status)->toBe(ApprovalRequest::STATUS_APPROVED)
        ->and($request->approved_by)->toBe($originalApprovedBy)
        ->and($request->approved_at?->toDateTimeString())->toBe($originalApprovedAt?->toDateTimeString());
});
