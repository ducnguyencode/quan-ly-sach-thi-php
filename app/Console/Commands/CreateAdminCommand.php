<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo tài khoản admin mới hoặc đặt một tài khoản hiện có làm admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('===== TẠO TÀI KHOẢN ADMIN =====');

        // Kiểm tra xem đã có admin trong hệ thống chưa
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount > 0) {
            if (!$this->confirm('Đã có ' . $adminCount . ' tài khoản admin trong hệ thống. Bạn vẫn muốn tạo thêm tài khoản admin?', false)) {
                $this->info('Hủy tạo tài khoản admin.');
                return;
            }
        }

        // Hỏi người dùng muốn tạo admin mới hay đặt một tài khoản hiện có làm admin
        $choice = $this->choice(
            'Bạn muốn làm gì?',
            ['Tạo tài khoản admin mới', 'Đặt một tài khoản hiện có làm admin'],
            0
        );

        if ($choice === 'Tạo tài khoản admin mới') {
            // Sử dụng AdminSeeder để tạo tài khoản admin mới
            $name = $this->option('name');
            $email = $this->option('email');
            $password = $this->option('password');

            $args = [];
            if ($name) $args['--name'] = $name;
            if ($email) $args['--email'] = $email;
            if ($password) $args['--password'] = $password;

            $args['--class'] = 'Database\\Seeders\\AdminSeeder';

            Artisan::call('db:seed', $args);
            $this->line(Artisan::output());
        } else {
            $this->setExistingUserAsAdmin();
        }
    }

    /**
     * Đặt một tài khoản hiện có làm admin
     */
    private function setExistingUserAsAdmin()
    {
        $this->info('Danh sách tài khoản người dùng:');

        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            $this->error('Không có tài khoản người dùng thường nào trong hệ thống!');
            return;
        }

        // Hiển thị danh sách người dùng
        $this->table(
            ['ID', 'Tên', 'Email'],
            $users->map(function ($user) {
                return [$user->id, $user->name, $user->email];
            })
        );

        // Chọn ID người dùng để đặt làm admin
        $userId = $this->ask('Nhập ID của người dùng cần đặt làm admin');

        $user = User::find($userId);

        if (!$user) {
            $this->error('Không tìm thấy người dùng với ID ' . $userId);
            return;
        }

        if ($user->role === 'admin') {
            $this->error('Người dùng ' . $user->name . ' đã có quyền admin!');
            return;
        }

        // Cập nhật quyền của người dùng thành admin
        $user->role = 'admin';
        $user->save();

        $this->info('Tài khoản ' . $user->name . ' đã được đặt làm admin thành công!');
    }
}
