<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kiểm tra xem đã có admin trong hệ thống chưa
        if (User::where('role', 'admin')->count() == 0) {
            // Lấy tham số từ command nếu có, nếu không thì yêu cầu nhập liệu
            if ($this->command->option('name') && $this->command->option('email') && $this->command->option('password')) {
                $name = $this->command->option('name');
                $email = $this->command->option('email');
                $password = $this->command->option('password');
            } else {
                // Yêu cầu nhập thông tin admin một cách rõ ràng
                $name = $this->command->ask('Nhập tên admin:', 'Admin');
                $email = $this->command->ask('Nhập email admin:');

                // Validate email
                while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->command->error('Email không hợp lệ!');
                    $email = $this->command->ask('Nhập lại email admin:');
                }

                $password = $this->command->secret('Nhập mật khẩu admin (ít nhất 8 ký tự):');

                // Validate password
                while (strlen($password) < 8) {
                    $this->command->error('Mật khẩu phải có ít nhất 8 ký tự!');
                    $password = $this->command->secret('Nhập lại mật khẩu admin:');
                }
            }

            // Tạo tài khoản admin
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $this->command->info('Tài khoản admin đã được tạo thành công!');
            $this->command->info('Email đăng nhập: ' . $email);
        } else {
            $this->command->info('Đã có tài khoản admin trong hệ thống!');
        }
    }
}
