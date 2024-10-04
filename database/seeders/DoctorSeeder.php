<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DoctorProfile;
class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'smith@example.com',
            'password' => '01234567892',
            'role' => 'admin',
        ]);


        $doctor = [
            'user_id' => $user->id,
            'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'smith@example.com',
                'mobile' => '01234567892',
                'gender' => 'Female',
                'bmdc_number' => 'BM654321',
                'blood_group' => 'A+',
                'date_of_birth' => '1985-05-15',
                'nid' => '987654321098',
                'specialist' => 'Neurologist',
                'fee' => 600,
                'designation' => 'Consultant',
                'consultant_type' => 'Inpatient',
                'address' => '456 Elm Street, Othertown, Country',
                'description' => 'Expert neurologist specializing in neurodegenerative diseases.',
        ];
        DoctorProfile::create($doctor);

    }
}
