<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\Category;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoteComparisonTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_candidate_comparison_page(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Ketua RT 01',
            'voting_start' => now()->subDay(),
            'voting_end' => now()->addDay(),
            'is_active' => true,
        ]);

        $candidateA = Candidate::create([
            'name' => 'Calon A',
            'photo' => null,
            'vision' => 'Mewujudkan lingkungan bersih',
            'mission' => 'Mengadakan gotong royong rutin',
            'category_id' => $category->id,
        ]);

        $candidateB = Candidate::create([
            'name' => 'Calon B',
            'photo' => null,
            'vision' => 'Meningkatkan keamanan warga',
            'mission' => 'Membangun pos ronda modern',
            'category_id' => $category->id,
        ]);

        Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $candidateA->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get(route('vote.category.compare', $category));

        $response->assertOk();
        $response->assertSeeText('Perbandingan Kandidat');
        $response->assertSeeText($candidateA->name);
        $response->assertSeeText($candidateB->name);
    }
}

