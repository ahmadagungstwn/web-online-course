<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseBenefit;
use App\Models\CourseSection;
use App\Models\SectionContent;
use App\Models\CourseStudent;
use App\Models\CourseMentor;
use App\Models\Pricing;
use App\Models\Transaction;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // === USER ===
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Admin Sistem',
            'photo' => 'W8sKi6u8Ie9SBqnoX7tdQ7VoZhrflGFX65jZ8jmk.png'
        ]);

        $mentor = User::create([
            'name' => 'Mentor Satu',
            'email' => 'mentor@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Mentor',
            'photo' => 'W8sKi6u8Ie9SBqnoX7tdQ7VoZhrflGFX65jZ8jmk.png'
        ]);

        $student = User::create([
            'name' => 'Siswa Satu',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Mahasiswa',
            'photo' => 'W8sKi6u8Ie9SBqnoX7tdQ7VoZhrflGFX65jZ8jmk.png'
        ]);

        // === CATEGORY (2 kategori) ===
        $categories = [
            Category::create(['name' => 'Pemrograman Web', 'slug' => 'pemrograman-web']),
            Category::create(['name' => 'UI/UX Design', 'slug' => 'ui-ux-design']),
        ];

        // === COURSE (2 Course Dibagi Rata) ===
        $courseNames = ['Laravel Dasar', 'Figma untuk Pemula'];

        foreach ($courseNames as $i => $courseName) {

            $course = Course::create([
                'name' => $courseName,
                'slug' => Str::slug($courseName),
                'thumbnail' => 'course-' . ($i + 1) . '.jpg',
                'about' => $faker->sentence(12),
                'is_popular' => $i % 2 == 0,
                'category_id' => $categories[$i]->id,
            ]);

            // === BENEFIT (4 per course) ===
            $benefits = ['Akses Selamanya', 'Sertifikat', 'File Materi', 'Grup Diskusi'];
            foreach ($benefits as $benefit) {
                CourseBenefit::create([
                    'name' => $benefit,
                    'course_id' => $course->id,
                ]);
            }

            // === SECTION (2 per course) ===
            for ($s = 1; $s <= 2; $s++) {
                $section = CourseSection::create([
                    'name' => "Bagian $s",
                    'position' => $s,
                    'course_id' => $course->id,
                ]);

                // === CONTENT (3 per section) ===
                for ($c = 1; $c <= 3; $c++) {
                    SectionContent::create([
                        'name' => "Materi $s.$c",
                        'content' => $faker->sentence(8),
                        'course_section_id' => $section->id,
                    ]);
                }
            }

            // === MENTOR ===
            CourseMentor::create([
                'user_id' => $mentor->id,
                'course_id' => $course->id,
                'is_active' => true,
                'about' => 'Mentor berpengalaman.'
            ]);

            // === STUDENT (Enroll) ===
            CourseStudent::create([
                'is_active' => true,
                'user_id' => $student->id,
                'course_id' => $course->id,
            ]);
        }
    }
}
