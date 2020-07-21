<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @version 1
 * api response for v1
 */

Route::get('ujians/{jadwal}/banksoal/{banksoal}/capaian-siswa/excel', 'Api\v1\UjianController@getCapaianSiswaExcel');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function() {
    Route::post('login', 'AuthController@login');
    Route::get('login/oauth', 'AuthController@oauth');
    Route::get('login/sso', 'AuthController@sso');
    Route::get('login/callback', 'AuthController@callback');
    Route::get('settings/auth', 'SettingController@getSetAuth');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user-authenticated', 'UserController@getUserLogin');
        Route::get('user-lists', 'UserController@userLists');
        Route::post('user/change-password', 'UserController@changePassword');
        Route::post('users/upload', 'UserController@import');
        Route::apiResource('users', 'UserController');

        Route::get('agamas', 'AgamaController@index');
        
        Route::get('jurusans/all', 'JurusanController@allData');
        Route::apiResource('jurusans', 'JurusanController');

        Route::get('pesertas/login', 'PesertaController@getPesertaLogin');
        Route::delete('pesertas/{peserta}/login', 'PesertaController@resetPesertaLogin');
        Route::post('pesertas/upload', 'PesertaController@import');
        Route::apiResource('pesertas', 'PesertaController');

        Route::get('matpels/all', 'MatpelController@allData');
        Route::post('matpels/upload', 'MatpelController@import');
        Route::apiResource('matpels', 'MatpelController');

        Route::get('banksoals/{banksoal}/analys', 'BanksoalController@getAnalys');
        Route::get('banksoals/all', 'BanksoalController@allData');
        Route::apiResource('banksoals', 'BanksoalController');

        Route::get('soals/{soal}', 'SoalController@show');
        Route::post('soals', 'SoalController@store');
        Route::post('soals/paste', 'SoalController@storePaste');
        Route::post('soals/{soal}/edit', 'SoalController@update');
        Route::delete('soals/{soal}', 'SoalController@destroy');
        Route::get('soals/banksoal/{banksoal}', 'SoalController@getSoalByBanksoal');
        Route::post('soals/banksoal/{banksoal}/upload', 'SoalController@import');
        Route::get('soals/banksoal/{banksoal}/all','SoalController@getSoalByBanksoalAll');
        Route::get('soals/banksoal/{banksoal}/analys', 'SoalController@getSoalByBanksoalAnalys');

        Route::post('directory/filemedia', 'DirectoryController@storeFilemedia');
        Route::post('file/upload', 'DirectoryController@uploadFile');
        Route::post('upload/file-audio', 'DirectoryController@uploadAudio');
        Route::delete('directory/filemedia/{filemedia}', 'DirectoryController@deleteFilemedia');
        Route::get('directory/banksoal/{filemedia}', 'DirectoryController@getDirectoryBanksoal');
        Route::apiResource('directory', 'DirectoryController');

        Route::post('ujians/{jadwal}/sesi-change', 'UjianAktifController@changeSesi');
        Route::get('ujians/active', 'UjianAktifController@index');
        Route::get('ujians/sesi', 'UjianAktifController@sesi');
        Route::post('ujians/token-release', 'UjianAktifController@releaseToken');
        Route::post('ujians/token-change', 'UjianAktifController@changeToken');
        Route::get('ujians/token-get', 'UjianAktifController@getToken');
        Route::get('ujians/{jadwal}/peserta', 'UjianAktifController@getPesertas');
        Route::get('ujians/peserta/{peserta}/reset', 'UjianAktifController@resetUjianPeserta');
        Route::get('ujians/peserta/{peserta}/close', 'UjianAktifController@closePeserta');

        Route::get('ujians/esay/exists', 'UjianController@getExistEsay');
        Route::post('ujians/esay/input', 'UjianController@storeNilaiEsay');
        Route::get('ujians/esay/{banksoal}/koreksi', 'UjianController@getExistEsayByBanksoal');
        Route::get('ujians/{jadwal}/result', 'UjianController@getResult');
        Route::get('ujians/{jadwal}/result/banksoal', 'UjianController@getBanksoalByJadwal');
        Route::get('ujians/{jadwal}/banksoal/{banksoal}/capaian-siswa', 'UjianController@getCapaianSiswa');
        Route::get('ujians/{jadwal}/banksoal/{banksoal}/capaian-siswa/excel', 'UjianController@getCapaianSiswaExcel');
        Route::get('ujians/all', 'UjianController@allData');
        Route::get('ujians/active-status', 'UjianController@getActive');
        Route::post('ujians/set-status', 'UjianController@setStatus');
        Route::apiResource('ujians', 'UjianController')->only('index','store','destroy');

        Route::get('events/all', 'EventController@allData');
        Route::apiResource('events', 'EventController');

        Route::get('settings/sekolah', 'SettingController@getSettingSekolah');
        Route::post('settings/sekolah', 'SettingController@storeSettingSekolah');
        Route::post('settings/sekolah/logo', 'SettingController@changeLogoSekolah');
        Route::get('settings', 'SettingController@getSetting');
        Route::post('settings', 'SettingController@setSetting');
    });
});

/*
|--------------------------------------------------------------------------
| API Routes Fo peserta
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'v2', 'namespace' => 'Api\v2'], function() {

    Route::post('logedin','PesertaLoginController@login');
    Route::group(['middleware' => 'peserta'], function() {
        Route::get('peserta-authenticated', 'PesertaLoginController@authenticated');
        Route::get('peserta/logout','PesertaLoginController@logout');
        Route::get('jadwals/peserta', 'JadwalController@getJadwalPeserta');
        Route::get('ujians/uncomplete','UjianAktifController@uncompleteUjian');
        Route::get('ujians/peserta', 'UjianAktifController@getUjianPesertaAktif');
        Route::post('ujians/start', 'UjianAktifController@startUjian');
        Route::post('ujians/start/time', 'UjianAktifController@startUjianTime');
        Route::get('ujians/filled', 'UjianAktifController@getJawabanPeserta');
        Route::post('ujian','UjianController@store');
        Route::post('/ujian/ragu-ragu', 'UjianController@setRagu');
        Route::post('/ujian/selesai', 'UjianController@selesai');
    });
});
