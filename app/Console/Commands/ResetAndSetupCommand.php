<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetAndSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset và cài đặt lại ứng dụng từ đầu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('===== RESET VÀ CÀI ĐẶT LẠI ỨNG DỤNG =====');

        if (!$this->confirm('Bạn có chắc chắn muốn xóa toàn bộ dữ liệu và cài đặt lại ứng dụng từ đầu?', false)) {
            $this->info('Đã hủy thao tác.');
            return;
        }

        $this->info('Đang xóa database...');
        Artisan::call('db:wipe');
        $this->info('Đã xóa database.');

        $this->info('Đang chạy migration...');
        Artisan::call('migrate:fresh');
        $this->info('Đã chạy migration thành công.');

        $this->info('===== TẠO TÀI KHOẢN ADMIN =====');

        // Tạo tài khoản admin trực tiếp trong command này để có thể kiểm soát hiển thị
        $name = $this->ask('Nhập tên admin:', 'Admin');
        $email = $this->ask('Nhập email admin:');

        // Validate email
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email không hợp lệ!');
            $email = $this->ask('Nhập lại email admin:');
        }

        $password = $this->secret('Nhập mật khẩu admin (ít nhất 8 ký tự):');

        // Validate password
        while (strlen($password) < 8) {
            $this->error('Mật khẩu phải có ít nhất 8 ký tự!');
            $password = $this->secret('Nhập lại mật khẩu admin:');
        }

        // Sử dụng AdminSeeder với các tham số xác định
        $this->info('Đang tạo tài khoản admin...');
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\AdminSeeder',
            '--name' => $name,
            '--email' => $email,
            '--password' => $password
        ]);

        $this->info('Tài khoản admin đã được tạo thành công!');
        $this->info('Email đăng nhập: ' . $email);

        $this->info('===== HOÀN THÀNH =====');
        $this->info('Ứng dụng đã được cài đặt lại thành công!');
    }
}
