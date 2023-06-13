<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\DispensasiNikahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KependudukanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurveyController;

Route::middleware('guest')->group(function(){
    Route::get('/', function(){
        return view('login');
    })->name('login');
    Route::post('verify', [AuthController::class, 'verify'])->name('verify');
});

Route::middleware('auth')->group(function(){
    Route::name('logout')->get('logout', function(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    });

    Route::prefix('home')->group(function(){
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::prefix('absensi')->name('absensi.')->group(function(){
            Route::get('datatable', [HomeController::class, 'datatable'])->name('datatable');
            Route::get('print', [HomeController::class, 'print'])->name('print');
            Route::prefix("{type}")->group(function(){
                Route::get('keterangan', [HomeController::class, 'keterangan'])->name('keterangan');
                Route::post('store', [HomeController::class, 'store'])->name('store');
            });
            Route::get('pagi', [HomeController::class, 'absenPagi'])->name('pagi');
            Route::get('sore', [HomeController::class, 'absenSore'])->name('sore');
        });
    });

    Route::prefix('pegawai')->name('pegawai.')->group(function(){
        Route::get('/', [PegawaiController::class, 'index'])->name('index');
        Route::get('print', [PegawaiController::class, 'print'])->name('print');
        Route::get('/datatable', [PegawaiController::class, 'datatable']);
        Route::get('/create', [PegawaiController::class, 'create'])->name('create');
        Route::post('store', [PegawaiController::class, 'store'])->name('store');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [PegawaiController::class, 'edit'])->name('edit');
            Route::put('update', [PegawaiController::class, 'update'])->name('update');
            Route::get('delete', [PegawaiController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('desa')->name('desa.')->group(function(){
        Route::get('/', [DesaController::class, 'index'])->name('index');
        Route::get('print', [DesaController::class, 'print'])->name('print');
        Route::get('json', [DesaController::class, 'json'])->name('json');
        Route::get('/datatable', [DesaController::class, 'datatable']);
        Route::get('/create', [DesaController::class, 'create'])->name('create');
        Route::post('store', [DesaController::class, 'store'])->name('store');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [DesaController::class, 'edit'])->name('edit');
            Route::put('update', [DesaController::class, 'update'])->name('update');
            Route::get('delete', [DesaController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('service')->name('service.')->group(function(){
        Route::get('/', [LayananController::class, 'index'])->name('index');
        Route::get('print', [LayananController::class, 'print'])->name('print');
        Route::get('json', [LayananController::class, 'json'])->name('json');
        Route::get('/datatable', [LayananController::class, 'datatable']);
        Route::get('/create', [LayananController::class, 'create'])->name('create');
        Route::post('store', [LayananController::class, 'store'])->name('store');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [LayananController::class, 'edit'])->name('edit');
            Route::put('update', [LayananController::class, 'update'])->name('update');
            Route::get('delete', [LayananController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('pelayanan')->name('pelayanan.')->group(function(){
        Route::get('/', [PelayananController::class, 'index'])->name('index');
        Route::get('/datatable', [PelayananController::class, 'datatable']);
        Route::get('/print', [PelayananController::class, 'print']);
        Route::get('/create', [PelayananController::class, 'create'])->name('create');
        Route::post('store', [PelayananController::class, 'store'])->name('store');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [PelayananController::class, 'edit'])->name('edit');
            Route::put('update', [PelayananController::class, 'update'])->name('update');
            Route::get('delete', [PelayananController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('kehadiran')->name('kehadiran.')->group(function(){
        Route::get('/', [AbsensiController::class, 'index'])->name('index');
        Route::get('/datatable', [AbsensiController::class, 'datatable']);
        Route::get('print', [AbsensiController::class, 'print'])->name('print');
        Route::get('summary', [AbsensiController::class, 'summary'])->name('summary');
    });

    Route::prefix('dispensasi_nikah')->name('dispensasi_nikah.')->group(function(){
        Route::get('/', [DispensasiNikahController::class, 'index'])->name('index');
        Route::get('/datatable', [DispensasiNikahController::class, 'datatable']);
        Route::get('/print', [DispensasiNikahController::class, 'print']);
        Route::get('/create', [DispensasiNikahController::class, 'create'])->name('create');
        Route::post('store', [DispensasiNikahController::class, 'store'])->name('store');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [DispensasiNikahController::class, 'edit'])->name('edit');
            Route::put('update', [DispensasiNikahController::class, 'update'])->name('update');
            Route::get('delete', [DispensasiNikahController::class, 'delete'])->name('delete');
            Route::get('rekomendasi', [DispensasiNikahController::class, 'rekomendasi'])->name('rekomendasi');
        });
    });

    Route::prefix('survey')->name('survey.')->group(function(){
        Route::get('/', [SurveyController::class, 'index'])->name('index');
        Route::get('/datatable', [SurveyController::class, 'datatable']);
        Route::get('/print', [SurveyController::class, 'print']);
        Route::get('/evaluation', [SurveyController::class, 'evaluation']);
        Route::get('/create', [SurveyController::class, 'create'])->name('create');
        Route::post('store', [SurveyController::class, 'store'])->name('store');
        Route::get('/chart', [SurveyController::class, 'chart'])->name('chart');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [SurveyController::class, 'edit'])->name('edit');
            Route::put('update', [SurveyController::class, 'update'])->name('update');
            Route::get('delete', [SurveyController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('kependudukan')->name('kependudukan.')->group(function(){
        Route::get('/', [KependudukanController::class, 'index'])->name('index');
        Route::get('/datatable', [KependudukanController::class, 'datatable']);
        Route::get('/print', [KependudukanController::class, 'print']);
        Route::get('/create', [KependudukanController::class, 'create'])->name('create');
        Route::post('store', [KependudukanController::class, 'store'])->name('store');
        Route::prefix('{id}')->group(function(){
            Route::get('edit', [KependudukanController::class, 'edit'])->name('edit');
            Route::put('update', [KependudukanController::class, 'update'])->name('update');
            Route::get('delete', [KependudukanController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('report')->name('report.')->group(function(){
        Route::get('pegawai', [ReportController::class, 'pegawai'])->name('pegawai');
        Route::get('pegawai-datatable', [ReportController::class, 'pegawaiDatatable']);
        Route::get('pegawai-report', [ReportController::class, 'pegawaiReport']);
        Route::get('absensi', [ReportController::class, 'absensi'])->name('absensi');
        Route::get('absensi-datatable', [ReportController::class, 'absensiDatatable']);
        Route::get('absensi-report', [ReportController::class, 'absensiReport']);
        Route::get('absensi-summary', [ReportController::class, 'absensiSummary']);
        Route::get('kependudukan', [ReportController::class, 'kependudukan'])->name('kependudukan');
        Route::get('kependudukan-datatable', [ReportController::class, 'kependudukanDatatable']);
        Route::get('kependudukan-report', [ReportController::class, 'kependudukanReport']);
        Route::get('pelayanan', [ReportController::class, 'pelayanan'])->name('pelayanan');
        Route::get('pelayanan-datatable', [ReportController::class, 'pelayananDatatable']);
        Route::get('pelayanan-report', [ReportController::class, 'pelayananReport']);
        Route::get('dispensasi', [ReportController::class, 'dispensasi'])->name('dispensasi');
        Route::get('dispensasi-datatable', [ReportController::class, 'dispensasiDatatable']);
        Route::get('dispensasi-report', [ReportController::class, 'dispensasiReport']);
        Route::get('survey', [ReportController::class, 'survey'])->name('survey');
        Route::get('survey-datatable', [ReportController::class, 'surveyDatatable']);
        Route::get('survey-report', [ReportController::class, 'surveyReport']);
        Route::get('survey-evaluation', [ReportController::class, 'surveyEvaluation']);
    });
});