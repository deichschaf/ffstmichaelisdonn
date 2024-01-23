<?php

use App\Http\Controllers\ChangeLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EinsaetzeController;
use App\Http\Controllers\FahrzeugeController;
use App\Http\Controllers\FireRegisterController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Sanctum\LoginController;
use App\Http\Controllers\Sanctum\RegisterController;
use App\Http\Controllers\TermineController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\WachenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
const REG_EX_SLUG = '[a-zA-Z0-9\-\_]+';

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/me', [LoginController::class, 'me']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::get('/updateapi', [PageController::class, 'makeArtianCalls']);
Route::get('/clearcache/{redirect}', [PageController::class, 'makeCacheClear'])
    ->name('api.admin.clearcache');

Route::get('/checkOffline', [PageController::class, 'checkOffline'])->name('api.checkOffline');

#Route::group(['middleware' => 'auth:sanctum'], function () {
Route::group(['prefix' => '/admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardOverview'])->name('api.admin.dashboard');
    Route::group(['prefix' => '/todo'], function () {
        Route::get('/overview', [ToDoController::class, 'todoOverviewApi'])->name('api.admin.json.todo.overview');
        Route::get('/todoselects', [ToDoController::class, 'getToDoSelects'])->name('api.admin.json.todo.selects');
        Route::get('/data/{id}', [ToDoController::class, 'getToDo'])->name('api.admin.jsoon.todo.getdata');
        Route::post('/save', [ToDoController::class, 'setToDo'])->name('api.admin.json.todo.save');
        Route::group(['prefix' => '/area'], function () {
            Route::get('/overview', [ToDoController::class, 'todoAreaOverviewApi'])->name('api.admin.json.todo.area.overview');
            Route::get('/getParentAreas', [ToDoController::class, 'todoAreaParentAreas'])->name('api.admin.json.todo.area.getparentareas');
            Route::get('/data/{id}', [ToDoController::class, 'getToDoArea'])->name('api.admin.jsoon.todo.area.getdata');
            Route::post('/save', [ToDoController::class, 'setToDoArea'])->name('api.admin.json.todo.area.save');
        });
    });
    Route::group(['prefix' => '/page'], function () {
        Route::get('/overview', [PageController::class, 'pageOverviewApi'])
            ->name('api.admin.json.overview');
        Route::get('/data/{id}', [PageController::class, 'getData'])->name('api.page.getdata');
        Route::post('/save', [PageController::class, 'saveData'])->name('api.page.save');
    });

    Route::group(['prefix' => '/placeholder'], function () {
        Route::get('/overview', [PageController::class, 'placeholderOverview']);
        Route::get('/data/{id}', [PageController::class, 'getPlaceholder']);
        Route::post('/save', [PageController::class, 'setPlaceholder']);
    });

    Route::group(['prefix' => '/links'], function () {
        Route::get('/overview', [LinksController::class, 'getLinksOverview']);
        Route::get('/data/{id}', [LinksController::class, 'getAdminLinks']);
        Route::get('/check/{id}', [LinksController::class, 'checkUrlExists']);
        Route::post('/save', [LinksController::class, 'setAdminLinks']);
    });

    Route::group(['prefix' => '/changelog'], function () {
        Route::get('/overview', [ChangeLogController::class, 'changelogOverviewApi'])
            ->name('api.admin.json.changelog.overview');
        Route::get('/data/{id}', [ChangeLogController::class, 'getData'])->name('api.changelog.getdata');
        Route::post('/save', [ChangeLogController::class, 'saveData'])->name('api.changelog.save');
    });

    Route::group(['prefix' => '/news'], function () {
        Route::get('/overview', [NewsController::class, 'getNewsOverviewApi']);
        Route::get('/data/{id}', [NewsController::class, 'getData'])->name('api.news.getdata');
        Route::post('/save', [NewsController::class, 'saveData'])->name('api.news.save');
    });

    Route::group(['prefix' => '/emergency'], function () {
        Route::post('/getCoordinates', [EinsaetzeController::class, 'getGoogleCoordinates'])->name('api.json.emergency.getGoogleCoordinates');
        Route::get('/predata', [EinsaetzeController::class, 'preDataApi'])->name('api.admin.json.emergency.predata');
        Route::get('/lastEmergency', [EinsaetzeController::class, 'getLastEmergency'])->name('api.admin.json.emergency.lastEmergency');
        Route::get('/loadAlarm/{id}', [EinsaetzeController::class, 'getLastEmergency'])->name('api.admin.json.emergency.lastEmergency');
        Route::get('/data/{id}', [EinsaetzeController::class, 'getData'])->name('api.admin.json.emergency.getdata');
        Route::post('/save', [EinsaetzeController::class, 'saveData'])->name('api.admin.json.emergency.savedata');
        Route::get('/getAllEmergencys', [EinsaetzeController::class, 'getAllEmergencys']);
        Route::post('/saveEmergencyType', [EinsaetzeController::class, 'saveEmergencyType']);
        Route::get('/overview', [EinsaetzeController::class, 'emergencyOverviewApi'])
            ->name('api.admin.json.emergency.overview');
    });
    Route::group(['prefix' => '/termine'], function () {
        Route::get('/overview', [TermineController::class, 'getAdminTermineOverview']);
        Route::get('/predata', [TermineController::class, 'preDataApi'])->name('api.admin.json.emergency.predata');
        Route::get('/data/{id}', [TermineController::class, 'getAdminTermine']);
        Route::post('/save', [TermineController::class, 'saveData']);
    });
    Route::group(['prefix' => '/units'], function () {
        Route::get('/overview', [WachenController::class, 'unitOverview'])->name('api.admin.units.overview');
        Route::get('/data/{id}', [WachenController::class, 'getAdminUnits']);
        Route::get('/check/{id}', [WachenController::class, 'checkUrlExists']);
        Route::post('/save', [WachenController::class, 'setAdminUnits']);
    });
});
#});

Route::get('/links/check/{id}', [LinksController::class, 'checkLinkExists']);

Route::group(['prefix' => '/submit'], function () {
    Route::post('/fireregister', [FireRegisterController::class, 'fireregister']);
});

Route::group(['prefix' => '/download'], function () {
    Route::get('/get/{slug}', [DownloadController::class, 'getDownload'])->where(
        [
            'slug' => REG_EX_SLUG
        ]);
});

Route::group(['prefix' => '/get'], function () {
    Route::post('/pagedata', [PageController::class, 'getPagedataApi'])->name('api.json.get.pagedata');
    Route::post('/checkWarnings', [PageController::class, 'getWarningsApi'])->name('api.json.get.warnings');
    Route::get('/checkWarnings', [PageController::class, 'getWarningsApi'])->name('api.json.get.warnings');
    Route::group(['prefix' => '/fahrzeuge'], function () {
        Route::get('/overview', [FahrzeugeController::class, 'getOverview'])->name('api.json.fahrzeuge.overview');
    });

    Route::post('/{slug}/{param1}/{param2}/{param3}', [PageController::class, 'getContent'])
        ->where(
            [
                'slug' => REG_EX_SLUG,
                'param1' => REG_EX_SLUG,
                'param2' => REG_EX_SLUG,
                'param3' => REG_EX_SLUG
            ]
        );
    Route::post('/{slug}/{param1}/{param2}', [PageController::class, 'getContent'])
        ->where(
            [
                'slug' => REG_EX_SLUG,
                'param1' => REG_EX_SLUG,
                'param2' => REG_EX_SLUG
            ]
        );
    Route::post('/{slug}/{param1}', [PageController::class, 'getContent'])
        ->where(
            [
                'slug' => REG_EX_SLUG,
                'param1' => REG_EX_SLUG
            ]
        );
    Route::post('/{slug}', [PageController::class, 'getContent'])
        ->where(
            [
                'slug' => REG_EX_SLUG
            ]
        );

});
