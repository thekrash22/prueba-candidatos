<?php

namespace Tests\Feature;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicantTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test verify create user
     * test create Applicant
     * verify creation
     */
    public function test_it_can_create_an_applicant(): void
    {
        $user = User::factory()->create();
        $applicant = Applicant::factory()->create([
            'created_by' => $user->id,
            'owner' => $user->id,
        ]);

        $this->assertDatabaseHas('applicants', [
            'id' => $applicant->id,
            'name' => $applicant->name,
            'source' => $applicant->source,
            'created_by' => $user->id,
            'owner' => $user->id,
        ]);
    }
}
