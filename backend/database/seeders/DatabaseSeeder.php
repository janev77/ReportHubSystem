<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name'       => 'Admin User',
            'email'      => 'admin@company.com',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'department' => 'IT',
            'is_active'  => true,
        ]);

        // Manager
        User::create([
            'name'       => 'Jane Manager',
            'email'      => 'manager@company.com',
            'password'   => Hash::make('password'),
            'role'       => 'manager',
            'department' => 'HR',
            'is_active'  => true,
        ]);

        // 10 employees
        foreach (range(1, 10) as $i) {
            User::create([
                'name'       => "Employee {$i}",
                'email'      => "employee{$i}@company.com",
                'password'   => Hash::make('password'),
                'role'       => 'employee',
                'department' => ['Engineering','HR','Sales','Finance','IT'][array_rand([0,1,2,3,4])],
                'is_active'  => true,
            ]);
        }

        // Categories
        $categories = [
            ['name' => 'General', 'color' => '#6366f1'],
            ['name' => 'HR',      'color' => '#10b981'],
            ['name' => 'IT',      'color' => '#3b82f6'],
            ['name' => 'Events',  'color' => '#f59e0b'],
            ['name' => 'Policy',  'color' => '#ef4444'],
            ['name' => 'Urgent',  'color' => '#dc2626'],
        ];

        foreach ($categories as $cat) {
            Category::create([...$cat, 'is_active' => true]);
        }

        // Announcements
        $admin = User::where('email', 'admin@company.com')->first();
        $cats  = Category::pluck('id', 'name');

        $announcements = [
            [
                'title'      => 'Welcome to ReportHubSystem',
                'content'    => 'This is your internal announcements feed. Stay tuned for updates from management.',
                'category_id'=> $cats['General'],
                'is_pinned'  => true,
                'target'     => ['all'],
            ],
            [
                'title'      => 'Office closed on Monday',
                'content'    => 'The office will be closed on Monday due to a public holiday. Enjoy your long weekend!',
                'category_id'=> $cats['HR'],
                'is_pinned'  => false,
                'target'     => ['all'],
            ],
            [
                'title'      => 'System maintenance scheduled',
                'content'    => 'IT will perform scheduled maintenance this Saturday from 10PM to 2AM. Expect brief downtime.',
                'category_id'=> $cats['IT'],
                'is_pinned'  => false,
                'target'     => ['all'],
            ],
            [
                'title'      => 'New expense policy',
                'content'    => 'Please review the updated expense reimbursement policy attached to your email.',
                'category_id'=> $cats['Policy'],
                'is_pinned'  => false,
                'target'     => ['all'],
            ],
            [
                'title'      => 'Company summer event',
                'content'    => 'Join us for the annual summer gathering on July 15th. Details will follow via email.',
                'category_id'=> $cats['Events'],
                'is_pinned'  => false,
                'target'     => ['all'],
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::create([
                ...$data,
                'created_by' => $admin->email,
                'is_active'  => true,
                'status'     => 'regular',
            ]);
        }
    }
}
