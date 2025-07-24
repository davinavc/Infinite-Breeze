<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\ReferalController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\JadwalStaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\RegistrasiJadwalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RegistrasiTenantController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\TransaksiTenantController;
use App\Http\Controllers\ReportController;


Route::get('/', [BlogController::class, 'welcome'])->name('blog.home');
Route::get('/show', [BlogController::class, 'show'])->name('blog.show');
Route::get('/upcoming/event', [BlogController::class, 'upcoming'])->name('blog.upcoming');
Route::get('/ongoing/event', [BlogController::class, 'ongoing'])->name('blog.ongoing');
Route::get('/tips', [BlogController::class, 'tips'])->name('blog.tips');
Route::get('/highlight/event', [BlogController::class, 'event'])->name('blog.event');
Route::get('/news', [BlogController::class, 'news'])->name('blog.news');
Route::get('/aboutus', [BlogController::class, 'aboutus'])->name('blog.aboutus');
// details
Route::get('/detail/upcoming/event/{id}', [BlogController::class, 'detailupcoming'])->name('blog.detailupcoming');
Route::get('/detail/ongoing/event/{id}', [BlogController::class, 'detailongoing'])->name('blog.detailongoing');
Route::get('/detail/tips/{id}', [BlogController::class, 'detailtips'])->name('blog.detailtips');
Route::get('/detail/highlight/event/{id}', [BlogController::class, 'detailevent'])->name('blog.detailevent');
Route::get('/detail/news/{id}', [BlogController::class, 'detailnews'])->name('blog.detailnews');

// Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if ($user->role == 'Admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role == 'Staff') {
            return redirect()->route('dashboard.staff');
        } elseif ($user->role == 'Tenant') {
            return redirect()->route('dashboard.tenant');
        }

        abort(403, 'Unauthorized');
    })->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tenant/formData', [TenantController::class, 'create'])->name('tenant.formData');
    Route::post('/tenant/formData', [TenantController::class, 'store'])->name('tenant.store.profile');
});

// Admin Navigation
Route::prefix('/dashboard/admin')->group(function () {
    Route::get('/', [AdminEventController::class, 'dashboard']
    )->name('dashboard.admin');

    Route::get('/registrations/verify', [RegistrasiTenantController::class, 'indexAdmin']
    )->name('dashboard.admin.registration');

    Route::get('/transaction/verify', [TransaksiTenantController::class, 'adminIndex']
    )->name('dashboard.admin.transaction');

    Route::get('/blog', [BlogController::class, 'index'] 
    )->name('dashboard.admin.blog');

    Route::get('/blog/create', [BlogController::class, 'create'] 
    )->name('dashboard.admin.addblog');

    Route::get('/event', [AdminEventController::class, 'index'] 
    )->name('dashboard.admin.event');

    Route::get('/add/event', [AdminEventController::class, 'create'] 
    )->name('dashboard.admin.addevent');

    Route::get('/staff', [StaffController::class, 'index'] 
    )->name('dashboard.admin.staff');

    Route::get('/add/staff', [StaffController::class, 'create'] 
    )->name('dashboard.admin.addstaff');

    Route::get('/tenant', [TenantController::class, 'index'] 
    )->name('dashboard.admin.tenant');

    Route::get('/department', [DeptController::class, 'index'] 
    )->name('dashboard.admin.dept');

    Route::get('/add/department', [DeptController::class, 'create'] 
    )->name('dashboard.admin.adddept');

    Route::get('/verify/schedule', [JadwalStaffController::class, 'index'])
    ->name('dashboard.admin.schedule');

    Route::get('/view/schedule', [JadwalStaffController::class, 'view'])
    ->name('dashboard.admin.viewschedule');

    Route::get('/add/schedule', [JadwalStaffController::class, 'create'])
    ->name('dashboard.admin.addschedule');

    Route::get('/history/event', [AdminEventController::class, 'history']
    )->name('dashboard.admin.eventhist');

    Route::get('/history/transaction', [TransaksiTenantController::class, 'history']
    )->name('dashboard.admin.transactionhist');

    Route::get('/history/staff', [StaffController::class, 'history']
    )->name('dashboard.admin.staffhist');

    Route::get('/history/tenant', [TenantController::class, 'history']
    )->name('dashboard.admin.tenanthist');

    Route::get('/komisi', [KomisiController::class, 'index'])
    ->name('dashboard.admin.komisi');

    Route::get('/setting/edit', [AdminController::class, 'edit'])
    ->name('dashboard.admin.setting');

    Route::get('/report/event', [ReportController::class, 'repevent']
    )->name('dashboard.admin.repevent');

    Route::get('/report/transaction', [ReportController::class, 'reptransaksi']
    )->name('dashboard.admin.reptransaction');

    Route::get('/report/commision', [ReportController::class, 'repkomisi']
    )->name('dashboard.admin.repkomisi');

    Route::get('/report/tenant', [ReportController::class, 'reptenant']
    )->name('dashboard.admin.reptenant');


    // Admin function
    Route::post('/blog/store', [BlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::post('/blog/update', [BlogController::class, 'update'])->name('admin.blog.update');
    Route::get('/blog/detail/{id}', [BlogController::class, 'show'])->name('admin.blog.detail');

    //Departemen
    Route::post('/dept/store', [DeptController::class, 'store'])->name('admin.dept.store');
    Route::post('/department/{id}/toggle', [DeptController::class, 'toggleStatus'])->name('admin.dept.toggle');
    Route::get('/department/{id}/edit', [DeptController::class, 'edit'])->name('department.edit');
    Route::post('/department/update', [DeptController::class, 'update'])->name('department.update');

    //Staff
    Route::post('/staff/store', [StaffController::class, 'store'])->name('admin.staff.store');
    Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('admin.staff.edit');
    Route::post('/staff/update', [StaffController::class, 'update'])->name('admin.staff.update');
    Route::post('/setting{id}/update', [AdminController::class, 'update'])->name('admin.setting.update');
    Route::get('/staff/detail/{id}', [StaffController::class, 'show'])->name('admin.staff.detail');

    //event
    Route::post('/event/store', [AdminEventController::class, 'store'])->name('admin.event.store');
    Route::get('/event/edit/{id}', [AdminEventController::class, 'edit'])->name('admin.event.edit');
    Route::get('/event/edithist/{id}', [AdminEventController::class, 'edithist'])->name('admin.event.edithist');
    Route::post('/event/update', [AdminEventController::class, 'update'])->name('admin.event.update');
    Route::get('/event/detail/{id}', [AdminEventController::class, 'show'])->name('admin.event.detail');
    Route::post('/event/{id}/send-reminder', [AdminEventController::class, 'sendReminderToStaff'])->name('event.sendReminder');

    //komisi
    Route::get('/komisi/{id}/show', [KomisiController::class, 'show'])->name('admin.komisi.detail');

    //tenant
    Route::get('/tenant/detail/{id}', [TenantController::class, 'show'])->name('admin.tenant.detail');
    Route::post('/transaksi/{id}/follow-up', [TenantController::class, 'followUp'])->name('transaksi.follow-up');

    //schedule
    Route::get('/schedule/create', [JadwalStaffController::class, 'create'])->name('admin.schedule.create');
    Route::post('/schedule/store', [JadwalStaffController::class, 'store'])->name('admin.schedule.store');
    Route::post('/schedule/update', [JadwalStaffController::class, 'update'])->name('admin.schedule.update');
    Route::get('/schedule/edit/{id}', [JadwalStaffController::class, 'edit'])->name('admin.schedule.edit');
    Route::get('/schedule/{schedule_id}/staff', [JadwalStaffController::class, 'showRegistrants'])->name('admin.schedule.registrants');
    Route::post('/schedule/{id}/accept', [JadwalStaffController::class, 'accept'])->name('admin.schedule.accept');
    Route::post('/schedule/{id}/reject', [JadwalStaffController::class, 'reject'])->name('admin.schedule.reject');

    //registrasi tenant
    Route::get('/registration/view', [RegistrasiTenantController::class, 'viewadmin'])->name('dashboard.admin.viewregist');
    Route::post('/registrations/{id}/accept', [RegistrasiTenantController::class, 'accept'])->name('admin.registration.accept');
    Route::post('/registrations/{id}/reject', [RegistrasiTenantController::class, 'reject'])->name('admin.registration.reject');
    Route::get('/registration/{id}/show', [RegistrasiTenantController::class, 'show'])->name('admin.regist.detail');

    //transaksi
    Route::get('/transaction/view', [TransaksiTenantController::class, 'viewadmin'])->name('dashboard.admin.viewtransaction');
    Route::post('/transaction/{id}/accept', [TransaksiTenantController::class, 'accept'])->name('admin.transaction.accept');
    Route::post('/transaction/{id}/reject', [TransaksiTenantController::class, 'reject'])->name('admin.transaction.reject');
    Route::get('/transaksi/{id}/show', [TransaksiTenantController::class, 'show'])->name('admin.transaksi.show');

    //report
    Route::get('/report/event/{id}', [ReportController::class, 'reportevent'])->name('admin.report.event');
    Route::get('/report/commission/{id}', [ReportController::class, 'reportkomisi'])->name('admin.report.komisi');
    Route::get('/report/transaction/{id}', [ReportController::class, 'reporttransaksi'])->name('admin.report.transaksi');
    Route::get('/report/detail/transaction/{id}', [ReportController::class, 'detailtransaksi'])->name('admin.detail.reptransaksi');
    Route::get('/report/tenant/{id}', [ReportController::class, 'reporttenant'])->name('admin.report.tenant');
    Route::get('/invoice/tenant/{tenantId}/event/{eventId}', [ReportController::class, 'invoice'])->name('admin.report.invoice');
    Route::get('/report/All/event', [ReportController::class, 'allevent'])->name('admin.report.allevent');
    Route::get('/report/All/commission', [ReportController::class, 'allkomisi'])->name('admin.report.allkomisi');
    Route::get('/report/All/transaction/', [ReportController::class, 'alltransaksi'])->name('admin.report.alltransaksi');
    Route::get('/report/All/tenant', [ReportController::class, 'alltenant'])->name('admin.report.alltenant');
});

// Staff Navigation
Route::prefix('/dashboard/staff')->group(function () {
    Route::get('/', [EventController::class, 'dashboardStaff']
    )->name('dashboard.staff');
    
    Route::get('schedule', [RegistrasiJadwalController::class, 'index'] 
    )->name('dashboard.staff.schedule');

    Route::get('event', [EventController::class, 'index'] 
    )->name('dashboard.staff.event');

    Route::get('tenant', [TenantController::class, 'index'] 
    )->name('dashboard.staff.tenant');

    Route::get('department', [DeptController::class, 'index'] 
    )->name('dashboard.staff.dept');

    Route::get('eventhist', [EventController::class, 'history']
    )->name('dashboard.staff.eventhist');

    Route::get('komisi', [KomisiController::class, 'index'])
    ->name('dashboard.staff.komisi');

    Route::get('setting', [StaffController::class, 'setting'])
    ->name('dashboard.staff.setting');

    // Staff function
    // setting
    Route::post('store', [StaffController::class, 'store'])->name('store');
    Route::get('edit/{id}', [StaffController::class, 'edit'])->name('edit');
    Route::post('update', [StaffController::class, 'update'])->name('update');

    // event
    Route::get('/event/detail/{id}', [EventController::class, 'show'])->name('staff.event.detail');
    Route::get('/event/{id}/register', [RegistrasiJadwalController::class, 'register'])->name('event.register');

    // schedule
    Route::post('/register/schedule/{jadwal_id}', [RegistrasiJadwalController::class, 'daftar'])->name('register.schedule');
    Route::post('register/schedule/cancel/{id}', [RegistrasiJadwalController::class, 'cancel'])->name('register.cancel');
    Route::get('/schedule/detail/{id}', [EventController::class, 'show'])->name('staff.detail.schedule');

});

// Tenant Navigation
Route::prefix('/dashboard/tenant')->group(function () {
    Route::get('/', [EventController::class, 'dashboardTenant']
    )->name('dashboard.tenant');

    Route::get('registration', [RegistrasiTenantController::class, 'showRegistrations']
    )->name('dashboard.tenant.registration');

    Route::get('transaction', [TransaksiTenantController::class, 'index']
    )->name('dashboard.tenant.transaction');

    Route::get('event', [EventController::class, 'index']
    )->name('dashboard.tenant.event');

    Route::get('transaction/history', [TransaksiTenantController::class, 'history'])
    ->name('dashboard.tenant.transactionhist');

    Route::get('setting', [TenantController::class, 'setting'])
    ->name('dashboard.tenant.setting');

    // tenant function
    Route::post('store', [TenantController::class, 'store'])->name('tenant.store');
    Route::post('update', [TenantController::class, 'update'])->name('tenant.update');
    Route::post('register', [TenantController::class, 'update'])->name('tenant.event.register');
    Route::get('event/detail/{id}', [EventController::class, 'show'])->name('tenant.event.detail');
    
    // Registrasi
    Route::post('registration/confirm/{id}', [RegistrasiTenantController::class, 'confirm'])->name('tenant.event.confirm');
    Route::post('registration/cancel/{id}', [RegistrasiTenantController::class, 'cancel'])->name('tenant.registration.cancel');
    
    // Transaksi
    Route::post('transaksi/start/{id}', [TransaksiTenantController::class, 'startFromRegistrasi'])->name('tenant.transaksi.start');
    Route::get('transaksi/create', [TransaksiTenantController::class, 'create'])->name('tenant.transaksi.create');
    Route::post('transaksi/store', [TransaksiTenantController::class, 'store'])->name('tenant.transaction.store');
    Route::put('transaksi/cancel/{id}', [TransaksiTenantController::class, 'cancel'])->name('tenant.transaksi.cancel');
    Route::put('transaksi/paid/{id}', [TransaksiTenantController::class, 'markAsPaid'])->name('tenant.transaksi.paid');
    Route::get('transaksi/{id}/edit', [TransaksiTenantController::class, 'edit'])->name('tenant.transaksi.edit');
    Route::put('transaksi/{id}', [TransaksiTenantController::class, 'update'])->name('tenant.transaksi.update');
    Route::get('transaksi/invoice/{tenantId}/{eventId}', [ReportController::class, 'invoicetenant'])->name('tenant.transaksi.invoice');

});

require __DIR__.'/auth.php';
