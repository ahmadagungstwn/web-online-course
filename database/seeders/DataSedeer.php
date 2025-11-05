<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

class DataSedeer extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === USERS ===
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Administrator',
            'photo' => 'admin.jpg',
        ]);

        $student = User::create([
            'name' => 'Siswa 1',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Mahasiswa',
            'photo' => 'student.jpg',
        ]);

        $mentorUser = User::create([
            'name' => 'Mentor Hebat',
            'email' => 'mentor@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Mentor',
            'photo' => 'mentor.jpg',
        ]);

        // === CATEGORY (3 kategori) ===
        $categories = [
            ['name' => 'Pemrograman Web', 'slug' => 'pemrograman-web'],
            ['name' => 'Data Science', 'slug' => 'data-science'],
            ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Ambil ulang kategori untuk digunakan
        $categories = Category::all();

        // === COURSE (total 5) ===
        $courseData = [
            ['name' => 'Belajar Laravel Dasar', 'category' => 'Pemrograman Web'],
            ['name' => 'ReactJS untuk Pemula', 'category' => 'Pemrograman Web'],
            ['name' => 'Dasar Data Science dengan Python', 'category' => 'Data Science'],
            ['name' => 'UI/UX Fundamental', 'category' => 'UI/UX Design'],
            ['name' => 'Machine Learning 101', 'category' => 'Data Science'],
        ];

        foreach ($courseData as $index => $data) {
            $category = $categories->where('name', $data['category'])->first();

            $course = Course::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'thumbnail' => 'course-' . ($index + 1) . '.jpg',
                'about' => 'Kelas "' . $data['name'] . '" membantu Anda menguasai keterampilan praktis.',
                'is_popular' => $index % 2 == 0,
                'category_id' => $category->id,
            ]);

            // === BENEFITS ===
            CourseBenefit::insert([
                ['name' => 'Akses seumur hidup', 'course_id' => $course->id],
                ['name' => 'Sertifikat kelulusan', 'course_id' => $course->id],
                ['name' => 'Forum diskusi mentor', 'course_id' => $course->id],
            ]);

            // === SECTIONS ===
            $section1 = CourseSection::create([
                'name' => 'Pengenalan ' . $data['name'],
                'position' => 1,
                'course_id' => $course->id,
            ]);

            $section2 = CourseSection::create([
                'name' => 'Materi Lanjutan ' . $data['name'],
                'position' => 2,
                'course_id' => $course->id,
            ]);

            // === SECTION CONTENT ===
            SectionContent::insert([
                [
                    'name' => 'Dasar ' . $data['name'],
                    'content' => 'Materi pengantar untuk memahami konsep dasar.',
                    'course_section_id' => $section1->id,
                ],
                [
                    'name' => 'Studi Kasus ' . $data['name'],
                    'content' => 'Latihan praktis membuat proyek nyata.',
                    'course_section_id' => $section2->id,
                ],
            ]);

            // === MENTOR ===
            CourseMentor::create([
                'user_id' => $mentorUser->id,
                'course_id' => $course->id,
                'is_active' => true,
                'about' => 'Mentor berpengalaman dalam bidang ' . $data['category'] . '.',
            ]);

            // === STUDENT ===
            CourseStudent::create([
                'name' => $student->name,
                'user_id' => $student->id,
                'course_id' => $course->id,
            ]);
        }

        // === PRICING ===
        $pricing = Pricing::create([
            'name' => 'Paket Premium',
            'duration' => 30,
            'price' => 250000,
        ]);

        // === TRANSACTION ===
        Transaction::create([
            'name' => 'Pembelian Paket Premium',
            'booking_trx_id' => strtoupper(Str::random(10)),
            'user_id' => $student->id,
            'pricing_id' => $pricing->id,
            'sub_total_amount' => 250000,
            'grand_total_amount' => 275000,
            'total_tax_amount' => 25000,
            'is_paid' => true,
            'payment_type' => 'Transfer Bank',
            'proof' => 'bukti-pembayaran.jpg',
            'started_at' => now(),
            'ended_at' => now()->addDays(30),
        ]);
    }
}
