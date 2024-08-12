<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Division;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'user_id' => str::uuid(),
            'name' => 'Test User',
            'username' => 'admin',
            'email' => 'test@example.com',
            'phone' => 123456789101,
            'password' => Hash::make('pastibisa'),
        ]);

        $divisionsData = [
            [
                "division_id" => str::uuid(),
                "name" => "Mobile Apps",
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                "division_id" => str::uuid(),
                "name" => "Qa",
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

            ],
            [
                "division_id" => str::uuid(),
                "name" => "Full Stack",
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                "division_id" => str::uuid(),
                "name" => "Backend",
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                "division_id" => str::uuid(),
                "name" => "Frontend",
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                "division_id" => str::uuid(),
                "name" => "UI/UX Designer",
                
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],


        ];
        Division::insert($divisionsData);



        $frontendDivisionId = Division::where('name','Frontend')->first()->division_id;
        $backendDivisionId = Division::where('name','Backend')->first()->division_id;
        $uiUxDivisionId = Division::where('name','UI/UX Designer')->first()->division_id;

        $employesData = [
            [
                "employee_id" => str::uuid(),
                "name" => "John Doe",
                'position' => "Front End Developer",
                'phone'=> 123456789101,
                'image'=> "https://via.placeholder.com/150",
                "division_id" => $frontendDivisionId,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                "employee_id" => str::uuid(),
                "name" => "test emlpoyee",
                'position' => "Backend Developer",
                'phone'=> 123456789101,
                'image'=> "https://via.placeholder.com/150",
                "division_id" => $backendDivisionId,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            [
                "employee_id" => str::uuid(),
                "name" => "test emlpoyee",
                'position' => "UI/UX Designer",
                'phone'=> 123456789101,
                'image'=> "https://via.placeholder.com/150",
                "division_id" => $uiUxDivisionId,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
        ];

        \App\Models\Employee::insert($employesData);
    }

}
