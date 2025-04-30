@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white py-3 text-center">
                    <h4 class="mb-0"><i class="fas fa-envelope-open-text me-2"></i>Xác thực Email</h4>
                </div>

                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <img src="{{ asset('images/email-verification.svg') }}" alt="Email Verification" class="img-fluid" style="max-width: 200px">
                    </div>
                    
                    <div class="verification-steps">
                        <div class="step-item active">
                            <span class="step-number">1</span>
                            <p>Vui lòng kiểm tra email của bạn để lấy liên kết xác minh</p>
                        </div>
                        <div class="step-item">
                            <span class="step-number">2</span>
                            <p>Nhấp vào liên kết trong email để xác thực tài khoản</p>
                        </div>
                        <div class="step-item">
                            <span class="step-number">3</span> 
                            <p>Đăng nhập để truy cập tài khoản của bạn</p>
                        </div>
                    </div>

                    <div class="alert alert-light border-left-info my-4" role="alert">
                        <i class="fas fa-info-circle text-info me-2"></i> Nếu bạn không nhận được email, vui lòng kiểm tra thư mục spam hoặc gửi lại email xác thực bên dưới.
                    </div>

                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-4">
                        @csrf
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ session('verification_email') ?? old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                            <label for="email"><i class="fas fa-at me-1"></i>Địa chỉ email</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi lại liên kết xác thực
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('login.show') }}" class="btn btn-link text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại trang đăng nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
}

.verification-steps {
    counter-reset: step;
    margin-bottom: 20px;
}

.step-item {
    position: relative;
    padding: 15px 20px 15px 60px;
    margin-bottom: 10px;
    border-radius: 8px;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.step-item.active {
    background-color: #e3f2fd;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.step-number {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    background-color: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.step-item p {
    margin-bottom: 0;
}

.border-left-info {
    border-left: 4px solid #17a2b8;
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

@media (max-width: 768px) {
    .step-item {
        padding-left: 50px;
    }
    
    .step-number {
        width: 28px;
        height: 28px;
        font-size: 14px;
    }
}
</style>
@endsection
