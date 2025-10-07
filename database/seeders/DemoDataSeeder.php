<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Candidate;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rt = Category::firstOrCreate(['name' => 'Ketua RT']);
        $rw = Category::firstOrCreate(['name' => 'Ketua RW']);

        Candidate::firstOrCreate([
            'name' => 'Calon RT 1',
            'category_id' => $rt->id,
        ], [
            'vision' => 'Meningkatkan pelayanan warga.',
            'mission' => 'Transparansi dan gotong royong.',
        ]);

        Candidate::firstOrCreate([
            'name' => 'Calon RT 2',
            'category_id' => $rt->id,
        ], [
            'vision' => 'Lingkungan bersih dan aman.',
            'mission' => 'Program keamanan dan kebersihan.',
        ]);

        Candidate::firstOrCreate([
            'name' => 'Calon RW 1',
            'category_id' => $rw->id,
        ], [
            'vision' => 'Koordinasi antar RT yang solid.',
            'mission' => 'Sinergi program antar RT.',
        ]);
    }
}
