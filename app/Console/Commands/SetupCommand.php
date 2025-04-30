<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thiết lập ứng dụng ban đầu với tài khoản admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('===== THIẾT LẬP ỨNG DỤNG =====');

        $this->info('Đang chạy migration...');
        Artisan::call('migrate:fresh');
        $this->info('Đã chạy migration thành công.');

        $this->info('===== TẠO TÀI KHOẢN ADMIN =====');

        $name = $this->ask('Nhập TÊN admin:', 'Admin');
        $email = $this->ask('Nhập EMAIL admin:');

        // Validate email
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email không hợp lệ!');
            $email = $this->ask('Nhập lại EMAIL admin:');
        }

        $password = $this->secret('Nhập MẬT KHẨU admin (ít nhất 8 ký tự):');

        // Validate password
        while (strlen($password) < 8) {
            $this->error('Mật khẩu phải có ít nhất 8 ký tự!');
            $password = $this->secret('Nhập lại MẬT KHẨU admin:');
        }

        // Tạo tài khoản admin trực tiếp
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Tài khoản admin đã được tạo thành công!');
        $this->info('Thông tin đăng nhập:');
        $this->info('- Email: ' . $email);
        $this->info('- Mật khẩu: (đã nhập)');

        $this->info('===== HOÀN THÀNH =====');
        $this->info('Ứng dụng đã được thiết lập thành công!');
        $this->info('Sử dụng thông tin admin ở trên để đăng nhập vào hệ thống.');
    }
}
