<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnwesenheitController;
use App\Http\Controllers\BilderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\CSSJSController;
use App\Http\Controllers\DBUpdateController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EinsaetzeController;
use App\Http\Controllers\FahrzeugeController;
use App\Http\Controllers\FeuerwehrController;
use App\Http\Controllers\FeuerwehrlexikonController;
use App\Http\Controllers\FirecardController;
use App\Http\Controllers\FlorianDithmarschenController;
use App\Http\Controllers\HeadImagesController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\KarteController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\LinkToFacebookController;
use App\Http\Controllers\MetatagsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SchiffstrafficController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\SystemToolsController;
use App\Http\Controllers\TermineController;
use App\Http\Controllers\TickerController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WetterController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\MitgliederController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/dbupdate', [DBUpdateController::class, 'checkLaravelColumns']);

Route::get('/clearcache', [PageController::class, 'ClearCache'])->name('admin.clearcache');
Route::get('/readcookie', [PageController::class, 'SetReadCookie'])->name('readcookie');
Route::group(['prefix' => '/intern/verwaltung'], function () {
    Route::get('/', [AdminController::class, 'overview'])->middleware(['auth'])->name('admin.dashboard');

    /**
     * Ajaxscripts
     */
    Route::group(['prefix' => '/ajax'], function () {
        Route::post('/loadContentByAjax', [AdminController::class, 'loadContentByAjax'])->middleware(['auth'])->name('admin.ajax.loadContentByAjax');
        Route::post('/pageoverview', [PageController::class, 'ajax_pageoverview'])->middleware(['auth'])->name('ajax.pageoverview');
        Route::post('/headimages/uploader', [HeadImagesController::class, 'uploader'])->middleware(['auth'])->name('intern.ajax.headimages.uploader');
    });

    Route::group(['prefix' => '/todo'], function () {
        Route::get('/', [TodoController::class, 'show_todos'])->middleware(['auth'])->name('admin.todo');
        Route::get('/add', [TodoController::class, 'add'])->middleware(['auth'])->name('admin.todo.status.add');
        Route::get('/edit/{id}', [TodoController::class, 'edit'])->middleware(['auth'])->name('admin.todo.status.edit')->where(['id' => '[0-9]+']);
        Route::get('/delete/{id}', [TodoController::class, 'delete'])->middleware(['auth'])->name('admin.todo.status.delete')->where(['id' => '[0-9]+']);
        Route::post('/delete', [TodoController::class, 'delete_post'])->middleware(['auth'])->name('admin.todo.status.delete.post');
        Route::post('/save', [TodoController::class, 'save'])->middleware(['auth'])->name('admin.todo.status.save');
    });

    Route::group(['prefix' => '/seitenbild'], function () {
        Route::get('/', [PageController::class, 'show_headimages'])->middleware(['auth'])->name('admin.pages.images');
        Route::get('/add', [PageController::class, 'add_headimages'])->middleware(['auth'])->name('admin.pages.images.add');
        Route::get('/edit/{id?}', [PageController::class, 'edit_headimages'])->middleware(['auth'])->name('admin.pages.images.edit');
        Route::get('/delete/{id?}', [PageController::class, 'delete_headimages'])->middleware(['auth'])->name('admin.pages.images.delete');
        Route::post('/delete', [PageController::class, 'delete_headimages_post'])->middleware(['auth'])->name('admin.pages.images.delete.post');
        Route::post('/save', [PageController::class, 'save_headimages'])->middleware(['auth'])->name('admin.pages.images.save.post');
        Route::post('/saveimage', [PageController::class, 'save_edit_headimages'])->middleware(['auth'])->name('admin.pages.images.save2.post');
    });

    Route::group(['prefix' => '/seiten'], function () {
        Route::get('/', [PageController::class, 'adminShow'])->middleware(['auth'])->name('admin.pages');
        Route::get('/sort', [PageController::class, 'admin_sort_show'])->middleware(['auth'])->name('admin.pages.sort');
        Route::get('/add', [PageController::class, 'add'])->middleware(['auth'])->name('admin.pages.add');
        Route::get('/edit/{id?}', [PageController::class, 'edit'])->middleware(['auth'])->name('admin.pages.edit');
        Route::get('/editheadline/{id?}', [PageController::class, 'editheadline'])->middleware(['auth'])->name('admin.pages.edit2');
        Route::get('/delete/{id?}', [PageController::class, 'delete'])->middleware(['auth'])->name('admin.pages.delete');
        Route::post('/delete', [PageController::class, 'delete_post'])->middleware(['auth'])->name('admin.pages.delete.post');
        Route::post('/save', [PageController::class, 'save'])->middleware(['auth'])->name('admin.pages.save.post');
        Route::post('/saveheadline', [PageController::class, 'saveheadline'])->middleware(['auth'])->name('admin.pages.save2.post');

        Route::group(['prefix' => '/placeholder'], function () {
            Route::get('/', [PageController::class, 'placeholder_overview'])->middleware(['auth'])->name('admin.page.placeholder');
            Route::get('/add', [PageController::class, 'placeholder_add'])->middleware(['auth'])->name('admin.page.placeholder.add');
            Route::get('/edit/{id?}', [PageController::class, 'placeholder_edit'])->middleware(['auth'])->name('admin.page.placeholder.edit');
            Route::get('/delete/{id?}', [PageController::class, 'placeholder_delete'])->middleware(['auth'])->name('admin.page.placeholder.delete');
            Route::post('/delete', [PageController::class, 'placeholder_delete_post'])->middleware(['auth'])->name('admin.page.placeholder.delete.post');
            Route::post('/save', [PageController::class, 'placeholder_save'])->middleware(['auth'])->name('admin.page.placeholder.save');
        });

        Route::group(['prefix' => '/ajax'], function () {
            Route::post('/imageupload', [PageController::class, 'uploadPageImages'])->middleware(['auth'])->name('admin.ajax.page.imageupload');
            Route::group(['prefix' => '/images'], function () {
                Route::get('/', [PageController::class, 'getPageImages'])->middleware(['auth'])->name('admin.ajax.page.images');
                Route::post('/post', [PageController::class, 'getPageImages'])->middleware(['auth'])->name('admin.ajax.page.images.post');
                Route::post('/delete/post', [PageController::class, 'deletePageImages'])->middleware(['auth'])->name('admin.ajax.page.delete.images.post');
                Route::post('/edit/post', [PageController::class, 'editPageImages'])->middleware(['auth'])->name('admin.ajax.page.edit.images.post');
            });
            Route::group(['prefix' => '/contenttext'], function () {
                Route::post('/getContentTexts', [PageController::class, 'getContentTexts'])->middleware(['auth'])->name('admin.ajax.page.contentext.getContentTexts');
                Route::get('/add', [PageController::class, 'content_add'])->middleware(['auth'])->name('admin.ajax.page.contentext.add');
                Route::get('/edit/{id?}', [PageController::class, 'content_edit'])->middleware(['auth'])->name('admin.ajax.page.contentext.edit');
                Route::get('/delete/{id?}', [PageController::class, 'content_delete'])->middleware(['auth'])->name('admin.ajax.page.contentext.delete');
                Route::post('/delete', [PageController::class, 'content_delete_post'])->middleware(['auth'])->name('admin.ajax.page.contentext.delete.post');
                Route::post('/save', [PageController::class, 'content_save'])->middleware(['auth'])->name('admin.ajax.page.contentext.save');
                Route::post('/pos', [PageController::class, 'content_pos'])->middleware(['auth'])->name('admin.ajax.page.contentext.pos');
            });
        });
    });

    Route::group(['prefix' => '/bilder'], function () {
        Route::get('/', [BilderController::class, 'adminShow'])->middleware(['auth'])->name('admin.images');
        Route::get('/add', [BilderController::class, 'adminAdd_gallery'])->middleware(['auth'])->name('admin.images.add');
        Route::get('/edit/{id?}', [BilderController::class, 'adminEdit_gallery'])->middleware(['auth'])->name('admin.images.edit');
        Route::get('/delete/{id?}', [BilderController::class, 'adminDelete_gallery'])->middleware(['auth'])->name('admin.images.delete');
        Route::post('/delete', [BilderController::class, 'adminDelete_gallery_post'])->middleware(['auth'])->name('admin.images.delete.post');
        Route::post('/save', [BilderController::class, 'adminSave_gallery'])->middleware(['auth'])->name('admin.images.save');
        Route::post('/uploader', [BilderController::class, 'admin_uploader'])->middleware(['auth'])->name('admin.image.multiple.upload');
    });


    Route::group(['prefix' => '/mitglieder'], function () {
        Route::get('/', [BilderController::class, 'adminShow'])->middleware(['auth'])->name('admin.mitglieder');
        Route::get('/add', [BilderController::class, 'adminAdd_gallery'])->middleware(['auth'])->name('admin.mitglieder.add');
        Route::get('/edit/{id?}', [BilderController::class, 'adminEdit_gallery'])->middleware(['auth'])->name('admin.mitglieder.edit');
        Route::get('/delete/{id?}', [BilderController::class, 'adminDelete_gallery'])->middleware(['auth'])->name('admin.mitglieder.delete');
        Route::post('/delete', [BilderController::class, 'adminDelete_gallery_post'])->middleware(['auth'])->name('admin.mitglieder.delete.post');
        Route::post('/save', [BilderController::class, 'adminSave_gallery'])->middleware(['auth'])->name('admin.mitglieder.save');
        Route::post('/uploader', [BilderController::class, 'admin_uploader'])->middleware(['auth'])->name('admin.mitglieder.multiple.upload');

        Route::group(['prefix' => '/vorstand'], function () {
            Route::get('/', [BilderController::class, 'adminShow'])->middleware(['auth'])->name('admin.mitglieder.vorstand');
            Route::get('/add', [BilderController::class, 'adminAdd_gallery'])->middleware(['auth'])->name('admin.mitglieder.vorstand.add');
            Route::get('/edit/{id?}', [BilderController::class, 'adminEdit_gallery'])->middleware(['auth'])->name('admin.mitglieder.vorstand.edit');
            Route::get('/delete/{id?}', [BilderController::class, 'adminDelete_gallery'])->middleware(['auth'])->name('admin.mitglieder.vorstand.delete');
            Route::post('/delete', [BilderController::class, 'adminDelete_gallery_post'])->middleware(['auth'])->name('admin.mitglieder.vorstand.delete.post');
            Route::post('/save', [BilderController::class, 'adminSave_gallery'])->middleware(['auth'])->name('admin.mitglieder.vorstand.save');
            Route::post('/uploader', [BilderController::class, 'admin_uploader'])->middleware(['auth'])->name('admin.mitglieder.vorstand.multiple.upload');
        });
    });


    Route::group(['prefix' => '/einsaetze'], function () {
        Route::get('/', [EinsaetzeController::class, 'adminShow'])->middleware(['auth'])->name('admin.einsaetze');
        Route::get('/add', [EinsaetzeController::class, 'adminAdd'])->middleware(['auth'])->name('admin.einsaetze.add');
        Route::get('/karte/{id?}', [KarteController::class, 'admin_einsatz'])->middleware(['auth'])->name('admin.einsaetze.karte.edit');
        Route::get('/edit/{id?}', [EinsaetzeController::class, 'adminEdit'])->middleware(['auth'])->name('admin.einsaetze.edit');
        Route::get('/delete/{id?}', [EinsaetzeController::class, 'adminDelete'])->middleware(['auth'])->name('admin.einsaetze.delete');
        Route::post('/delete', [EinsaetzeController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.einsaetze.delete.post');
        Route::post('/save', [EinsaetzeController::class, 'adminSave'])->middleware(['auth'])->name('admin.einsaetze.save');
    });

    Route::group(['prefix' => '/fahrzeuge'], function () {
        Route::get('/', [FahrzeugeController::class, 'adminShow'])->middleware(['auth'])->name('admin.fahrzeuge');
        Route::get('/add', [FahrzeugeController::class, 'adminAdd'])->middleware(['auth'])->name('admin.fahrzeuge.add');
        Route::get('/copy/{id?}', [FahrzeugeController::class, 'admin_copy'])->middleware(['auth'])->name('admin.fahrzeuge.copy');
        Route::get('/edit/{id?}', [FahrzeugeController::class, 'adminEdit'])->middleware(['auth'])->name('admin.fahrzeuge.edit');
        Route::get('/delete/{id?}', [FahrzeugeController::class, 'adminDelete'])->middleware(['auth'])->name('admin.fahrzeuge.delete');
        Route::post('/delete', [FahrzeugeController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.fahrzeuge.delete.post');
        Route::post('/save', [FahrzeugeController::class, 'adminSave'])->middleware(['auth'])->name('admin.fahrzeuge.save');
        Route::group(['prefix' => '/ajax'], function () {
            Route::post('/uploadurl', [FahrzeugeController::class, 'uploadCarImages'])->middleware(['auth'])->name('admin.fahrzeuge.ajax.imageupload');
            Route::post('/images', [FahrzeugeController::class, 'getCarImages'])->middleware(['auth'])->name('admin.fahrzeuge.ajax.images');
            Route::post('/images/post', [FahrzeugeController::class, 'getCarImages'])->middleware(['auth'])->name('admin.fahrzeuge.images.post');
            Route::post('/images/delete/post', [FahrzeugeController::class, 'deleteCarImages'])->middleware(['auth'])->name('admin.fahrzeuge.delete.images.post');
            Route::post('/images/edit/post', [FahrzeugeController::class, 'editCarImages'])->middleware(['auth'])->name('admin.fahrzeuge.edit.images.post');
        });
    });

    Route::group(['prefix' => '/wachen'], function () {
        Route::get('/', [FlorianDithmarschenController::class, 'adminShow'])->middleware(['auth'])->name('admin.wachen');
        Route::get('/add', [FlorianDithmarschenController::class, 'adminAdd'])->middleware(['auth'])->name('admin.wachen.add');
        Route::get('/copy/{id?}', [FlorianDithmarschenController::class, 'admin_copy'])->middleware(['auth'])->name('admin.wachen.copy');
        Route::get('/edit/{id?}', [FlorianDithmarschenController::class, 'adminEdit'])->middleware(['auth'])->name('admin.wachen.edit');
        Route::get('/delete/{id?}', [FlorianDithmarschenController::class, 'adminDelete'])->middleware(['auth'])->name('admin.wachen.delete');
        Route::post('/delete', [FlorianDithmarschenController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.wachen.delete.post');
        Route::post('/save', [FlorianDithmarschenController::class, 'adminSave'])->middleware(['auth'])->name('admin.wachen.save');
        Route::group(['prefix' => '/ajax'], function () {
            Route::post('/uploadurl', [FlorianDithmarschenController::class, 'uploadCarImages'])->middleware(['auth'])->name('admin.wachen.ajax.imageupload');
            Route::post('/images', [FlorianDithmarschenController::class, 'getCarImages'])->middleware(['auth'])->name('admin.wachen.ajax.images');
            Route::post('/images/post', [FlorianDithmarschenController::class, 'getCarImages'])->middleware(['auth'])->name('admin.wachen.images.post');
            Route::post('/images/delete/post', [FlorianDithmarschenController::class, 'deleteCarImages'])->middleware(['auth'])->name('admin.wachen.delete.images.post');
            Route::post('/images/edit/post', [FlorianDithmarschenController::class, 'editCarImages'])->middleware(['auth'])->name('admin.wachen.edit.images.post');
        });
    });

    Route::group(['prefix' => '/news'], function () {
        Route::get('/', [NewsController::class, 'adminShow'])->middleware(['auth'])->name('admin.news');
        Route::get('/add', [NewsController::class, 'adminAdd'])->middleware(['auth'])->name('admin.news.add');
        Route::get('/edit/{id?}', [NewsController::class, 'adminEdit'])->middleware(['auth'])->name('admin.news.edit');
        Route::get('/delete/{id?}', [NewsController::class, 'adminDelete'])->middleware(['auth'])->name('admin.news.delete');
        Route::post('/delete', [NewsController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.news.delete.post');
        Route::post('/save', [NewsController::class, 'adminSave'])->middleware(['auth'])->name('admin.news.save');
    });

    Route::group(['prefix' => '/headimages'], function () {
        Route::get('/', [HeadImagesController::class, 'adminShow'])->middleware(['auth'])->name('admin.headimages');
        Route::get('/add', [HeadImagesController::class, 'adminAdd'])->middleware(['auth'])->name('admin.headimages.add');
        Route::get('/edit/{id?}', [HeadImagesController::class, 'adminEdit'])->middleware(['auth'])->name('admin.headimages.edit');
        Route::get('/delete/{id?}', [HeadImagesController::class, 'adminDelete'])->middleware(['auth'])->name('admin.headimages.delete');
        Route::post('/delete', [HeadImagesController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.headimages.delete.post');
        Route::post('/save', [HeadImagesController::class, 'adminSave'])->middleware(['auth'])->name('admin.headimages.save');
    });
    Route::group(['prefix' => '/benutzer'], function () {
        Route::get('/', [UserController::class, 'index'])->middleware(['auth'])->name('admin.users');
        Route::get('/add', [UserController::class, 'adminuser_add'])->middleware(['auth'])->name('admin.users.add');
        Route::get('/edit/{id?}', [UserController::class, 'edit'])->middleware(['auth'])->name('admin.users.edit');
        Route::get('/delete/{id?}', [UserController::class, 'adminuser_delete'])->middleware(['auth'])->name('admin.users.delete');
        Route::post('/delete/{id?}', [UserController::class, 'destroy'])->middleware(['auth'])->name('admin.users.delete.post');
        Route::post('/save', [UserController::class, 'store'])->middleware(['auth'])->name('admin.users.save');
    });
    Route::group(['prefix' => '/downloads'], function () {
        Route::get('/', [DownloadController::class, 'adminShow'])->middleware(['auth'])->name('admin.downloads');
        Route::get('/add', [DownloadController::class, 'adminAdd'])->middleware(['auth'])->name('admin.downloads.add');
        Route::get('/edit/{id?}', [DownloadController::class, 'adminEdit'])->middleware(['auth'])->name('admin.downloads.edit');
        Route::get('/delete/{id?}', [DownloadController::class, 'adminDelete'])->middleware(['auth'])->name('admin.downloads.delete');
        Route::post('/delete', [DownloadController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.downloads.delete.post');
        Route::post('/save', [DownloadController::class, 'adminSave'])->middleware(['auth'])->name('admin.downloads.save');
        Route::group(['prefix' => '/kategorien'], function () {
            Route::get('/', [DownloadController::class, 'admin_kategorie_show'])->middleware(['auth'])->name('admin.downloads.kategorien');
            Route::get('/add', [DownloadController::class, 'admin_kategorie_add'])->middleware(['auth'])->name('admin.downloads.kategorien.add');
            Route::get('/edit/{id?}', [DownloadController::class, 'admin_kategorie_edit'])->middleware(['auth'])->name('admin.downloads.kategorien.edit');
            Route::get('/delete/{id?}', [DownloadController::class, 'admin_kategorie_delete'])->middleware(['auth'])->name('admin.downloads.kategorien.delete');
            Route::post('/delete', [DownloadController::class, 'admin_kategorie_delete_post'])->middleware(['auth'])->name('admin.downloads.kategorien.delete.post');
            Route::post('/save', [DownloadController::class, 'admin_kategorie_save'])->middleware(['auth'])->name('admin.downloads.kategorien.save');
        });
    });

    Route::group(['prefix' => '/headimages'], function () {
        Route::get('/', [HeadImagesController::class, 'show'])->middleware(['auth'])->name('admin.headimages');
        Route::get('/add', [HeadImagesController::class, 'adminAdd'])->middleware(['auth'])->name('admin.headimages.add');
        Route::get('/edit/{id?}', [HeadImagesController::class, 'adminEdit'])->middleware(['auth'])->name('admin.headimages.edit');
        Route::get('/delete/{id?}', [HeadImagesController::class, 'adminDelete'])->middleware(['auth'])->name('admin.headimages.delete');
        Route::post('/delete', [HeadImagesController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.headimages.delete.post');
        Route::post('/save', [HeadImagesController::class, 'adminSave'])->middleware(['auth'])->name('admin.headimages.save');
    });

    Route::group(['prefix' => '/partner'], function () {
        Route::get('/', [PartnerController::class, 'adminShow'])->middleware(['auth'])->name('admin.partner');
        Route::get('/add', [PartnerController::class, 'adminAdd'])->middleware(['auth'])->name('admin.partner.add');
        Route::get('/edit/{id?}', [PartnerController::class, 'adminEdit'])->middleware(['auth'])->name('admin.partner.edit');
        Route::get('/delete/{id?}', [PartnerController::class, 'adminDelete'])->middleware(['auth'])->name('admin.partner.delete');
        Route::post('/delete', [PartnerController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.partner.delete.post');
        Route::post('/save', [PartnerController::class, 'adminSave'])->middleware(['auth'])->name('admin.partner.save');
    });

    Route::group(['prefix' => '/links'], function () {
        Route::get('/', [LinksController::class, 'adminShow'])->middleware(['auth'])->name('admin.links');
        Route::get('/add', [LinksController::class, 'adminAdd'])->middleware(['auth'])->name('admin.links.add');
        Route::get('/edit/{id?}', [LinksController::class, 'adminEdit'])->middleware(['auth'])->name('admin.links.edit');
        Route::get('/delete/{id?}', [LinksController::class, 'adminDelete'])->middleware(['auth'])->name('admin.links.delete');
        Route::post('/delete', [LinksController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.links.delete.post');
        Route::post('/save', [LinksController::class, 'adminSave'])->middleware(['auth'])->name('admin.links.save');
        Route::group(['prefix' => '/kategorien'], function () {
            Route::get('/', [LinksController::class, 'admin_kategorien_show'])->middleware(['auth'])->name('admin.links.kategorien');
            Route::get('/add', [LinksController::class, 'admin_kategorien_add'])->middleware(['auth'])->name('admin.links.kategorien.add');
            Route::get('/edit/{id?}', [LinksController::class, 'admin_kategorien_edit'])->middleware(['auth'])->name('admin.links.kategorien.edit');
            Route::get('/delete/{id?}', [LinksController::class, 'admin_kategorien_delete'])->middleware(['auth'])->name('admin.links.kategorien.delete');
            Route::post('/delete', [LinksController::class, 'admin_kategorien_delete_post'])->middleware(['auth'])->name('admin.links.kategorien.delete.post');
            Route::post('/save', [LinksController::class, 'admin_kategorien_save'])->middleware(['auth'])->name('admin.links.kategorien.save');
        });
    });

    Route::group(['prefix' => '/metatags'], function () {
        Route::get('/', [MetatagsController::class, 'adminShow'])->middleware(['auth'])->name('admin.metatags');
        Route::get('/add', [MetatagsController::class, 'adminAdd'])->middleware(['auth'])->name('admin.metatags.add');
        Route::get('/edit/{id?}', [MetatagsController::class, 'adminEdit'])->middleware(['auth'])->name('admin.metatags.edit');
        Route::get('/delete/{id?}', [MetatagsController::class, 'adminDelete'])->middleware(['auth'])->name('admin.metatags.delete');
        Route::post('/delete', [MetatagsController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.metatags.delete.post');
        Route::post('/save', [MetatagsController::class, 'adminSave'])->middleware(['auth'])->name('admin.metatags.save');
    });
    /**
     * CSS + JS
     */
    Route::get('/css', [CSSJSController::class, 'css_admin'])->middleware(['auth'])->name('admin.css');
    //Route::get('/js', [CSSJSController::class, 'js_admin'])->middleware(['auth'])->name('admin.js');

    Route::group(['prefix' => '/termine'], function () {
        Route::get('/', [TermineController::class, 'adminShow'])->middleware(['auth'])->name('admin.termine');
        Route::get('/add', [TermineController::class, 'adminAdd'])->middleware(['auth'])->name('admin.termine.add');
        Route::get('/edit/{id?}', [TermineController::class, 'adminEdit'])->middleware(['auth'])->name('admin.termine.edit');
        Route::get('/show/{all?}', [TermineController::class, 'adminShow'])->middleware(['auth'])->name('admin.termine.show');
        Route::get('/delete/{id?}', [TermineController::class, 'adminDelete'])->middleware(['auth'])->name('admin.termine.delete');
        Route::post('/delete', [TermineController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.termine.delete.post');
        Route::post('/save', [TermineController::class, 'adminSave'])->middleware(['auth'])->name('admin.termine.save');
    });

    Route::group(['prefix' => '/ticker'], function () {
        Route::get('/', [TickerController::class, 'adminShow'])->middleware(['auth'])->name('admin.ticker');
        Route::get('/add', [TickerController::class, 'adminAdd'])->middleware(['auth'])->name('admin.ticker.add');
        Route::get('/edit/{id?}', [TickerController::class, 'adminEdit'])->middleware(['auth'])->name('admin.ticker.edit');
        Route::get('/delete/{id?}', [TickerController::class, 'adminDelete'])->middleware(['auth'])->name('admin.ticker.delete');
        Route::post('/delete', [TickerController::class, 'adminDeletePost'])->middleware(['auth'])->name('admin.ticker.delete.post');
        Route::post('/save', [TickerController::class, 'adminSave'])->middleware(['auth'])->name('admin.ticker.save');
    });

    /**
     * Ajaxscripts
     */
    Route::group(['prefix' => '/ajax'], function () {
        Route::post('/pageoverview', [PageController::class, 'ajax_pageoverview'])->middleware(['auth'])->name('ajax.pageoverview');
        Route::post('/headimages/uploader', [HeadImagesController::class, 'uploader'])->middleware(['auth'])->name('intern.ajax.headimages.uploader');
    });

    Route::group(['prefix' => '/system'], function () {
        Route::get('/logs', [LogViewerController::class, 'index'])->middleware(['auth'])->name('admin.logviewer');
        Route::get('/systeminfo', [SystemToolsController::class, 'systemtools_show'])->middleware(['auth'])->name('admin.systeminfo');
        Route::get('/changelog', [AdminController::class, 'show_change_log'])->middleware(['auth'])->name('admin.changelog');
    });
});

Route::get('/intern', [InternController::class, 'login'])->name('intern');
Route::post('/intern', [InternController::class, 'login_post'])->name('intern.login');
Route::get('/intern/password', [InternController::class, 'passwort'])->name('intern.password');
Route::post('/intern/password', [InternController::class, 'passwort_post'])->name('intern.password.post');
Route::get('/intern/password/lost', [InternController::class, 'password_lost'])->name('intern.password.lost');
Route::post('/intern/password/lost', [InternController::class, 'password_lost_post'])->name('intern.password.lost.post');

Route::get('/download', [DownloadController::class, 'download_show'])->name('download');
Route::get('/download/{file?}', [DownloadController::class, 'getfile'])->name('download.file');
Route::get('/image/{size}/{file}', [ImageController::class, 'getImage']);

/**
 * App to Website
 */
Route::group(
    ['prefix' => '/app'],
    function () {
        Route::group(['prefix' => '/einsaetze'], function () {
            Route::get('/save', [EinsaetzeController::class, 'save'])->name('admin.einsaetze.save');
        });
        Route::group(['prefix' => '/anwesenheit'], function () {
            Route::get('/', [AnwesenheitController::class, 'show_start'])->name('app.anwesenheit.home');
            Route::get('/einsatz', [AnwesenheitController::class, 'einsatz'])->name('app.anwesenheit.einsatz');
            Route::get('/uebung', [AnwesenheitController::class, 'uebung'])->name('app.anwesenheit.uebung');
            Route::get('/absicherung', [AnwesenheitController::class, 'absicherung'])->name('app.anwesenheit.absicherung');
            Route::get('/hydranten', [AnwesenheitController::class, 'hydranten'])->name('app.anwesenheit.hydranten');
            Route::post('/speichern', [AnwesenheitController::class, 'anwesenheit_speichern'])->name('app.anwesenheit.speichern');
            Route::post('/mitglieder', [AnwesenheitController::class, 'getMitglieder'])->name('app.anwesenheit.mitglieder');
        });

        Route::group(
            ['prefix' => '/firecard'],
            function () {
                Route::get('/', [FirecardController::class, 'overview'])->name('firecard.overview');
                Route::group(
                    ['prefix' => '/admin'],
                    function () {
                        Route::get('/', [FirecardController::class, 'admin_overview'])->name('admin.firecard.overview');
                        Route::get('/add', [FirecardController::class, 'adminAdd'])->name('admin.firecard.add');
                        Route::get('/edit/{id}', [FirecardController::class, 'adminEdit'])->name('admin.firecard.edit');
                        Route::get('/delete/{id}', [FirecardController::class, 'adminDelete'])->name('admin.firecard.delete');
                        Route::post('/delete', [FirecardController::class, 'adminDeletePost'])->name('admin.firecard.delete.post');
                        Route::post('/save', [FirecardController::class, 'adminSave'])->name('admin.firecard.save');
                    }
                );
                Route::get('/fetch', [FirecardController::class, 'readUrls'])->name('firecard.fetch');
            }
        );
    }
);

/**
 * API
 */
Route::group(
    ['prefix' => '/api'],
    function () {
        Route::get('/termine', [TermineController::class, 'show_ics'])->name('intern.api.termine');
        Route::get('/cronjob_birthday', [CronJobController::class, 'cron_birthday'])->name('intern.api.cronjob.birthday');
        Route::get('/facebooktermine', [TermineController::class, 'show_facebooktermine'])->name('intern.api.facebooktermine');
        Route::get('/probealarm', function () {
            Artisan::call('probealarm:senden');
        });
        Route::get('/checkalarmmail', function () {
            Artisan::call('alarm:reademail');
        });
    }
);
/**
 * Frontend
 */
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/home', [PageController::class, 'home'])->name('home.start');
Route::get('/einsaetze', [EinsaetzeController::class, 'einsaetze_show'])->name('einsaetze');
Route::get('/einsaetze/{jahr?}', [EinsaetzeController::class, 'einsaetze_show'])->name('einsaetze.jahr')->where(['jahr' => '[0-9]+']);
Route::get('/einsaetze/{jahr?}/{view?}', [EinsaetzeController::class, 'details'])->name('einsaetze.details')->where(['jahr' => '[0-9]+', 'view' => '[0-9]+']);
Route::get('/karte/einsatz/{id?}', [KarteController::class, 'show_einsatz'])->name('karte.einsatz')->where(['id' => '[0-9]+']);
Route::get('/einsatzgebiet', [KarteController::class, 'einsatzgebiet'])->name('einsatzgebiet');
Route::get('/statistik', [EinsaetzeController::class, 'einsatz_statistik_show'])->name('einsaetze.statistik');
Route::get('/aktuelles', [NewsController::class, 'news_overview'])->name('news');
Route::get('/aktuelles/{id?}', [NewsController::class, 'getArtikel'])->name('news.details')->where(['id' => '[0-9]+']);
Route::get('/kontakt', [ContactController::class, 'contact'])->name('contact');
Route::post('/kontakt', [ContactController::class, 'contact_send'])->name('contact.post');
Route::get('/feuer_anmelden', [FeuerwehrController::class, 'add_fire_contactform'])->name('feuer_anmelden');
Route::post('/feuer_anmelden', [FeuerwehrController::class, 'send_fire_contactform'])->name('feuer_anmelden.post');
Route::get('/impressum', [PageController::class, 'impressum'])->name('impressum');
Route::get('/datenschutz', [PageController::class, 'datenschutz'])->name('datenschutz');
Route::get('/125jahre', [PageController::class, 'page125jahre'])->name('125jahre');
Route::get('/linkout/{url?}', [LinksController::class, 'linkout'])->name('linkout')->where(['id' => '[0-9]+']);
Route::get('/links', [LinksController::class, 'links_show'])->name('links');
Route::get('/vorstand', [MitgliederController::class, 'vorstand'])->name('vorstand');
Route::get('/vorstand/kontakt/{id?}', [MitgliederController::class, 'vorstand_contact'])->name('vorstand.contact')->where(['id' => '[0-9]+']);
Route::get('/mitglieder', [MitgliederController::class, 'mitglieder'])->name('mitglieder');
Route::get('/termine', [TermineController::class, 'show_website'])->name('termine');
Route::get('/amtswehren', [PageController::class, 'amtswehren'])->name('amtswehren');
Route::get('/notruf_absetzen', [PageController::class, 'notruf_absetzen'])->name('notruf_absetzen');
Route::get('/stellenangebot', [PageController::class, 'stellenangebot'])->name('stellenangebot');
Route::get('/feuerwehrball', [PageController::class, 'feuerwehrball'])->name('feuerwehrball');
Route::get('/fahrzeuge/', [FahrzeugeController::class, 'fahrzeuge_show'])->name('fahrzeuge');
Route::get('/fahrzeuge/bild/{id?}', [FahrzeugeController::class, 'show_bild_details'])->name('fahrzeuge.bild')->where(['id' => '[0-9]+']);
Route::get('/fahrzeuge/wache/{id?}', [FahrzeugeController::class, 'show_wache_details'])->name('fahrzeuge.wache')->where(['id' => '[0-9]+']);
Route::get('/fahrzeuge/{id?}', [FahrzeugeController::class, 'show_details'])->name('fahrzeuge.details')->where(['id' => '[0-9]+']);
Route::get('/bilder', [BilderController::class, 'bilder_show'])->name('bilder');
Route::get('/bilder/{gallery?}', [BilderController::class, 'show_gallery'])->name('bilder.gallery')->where(['gallery' => '[0-9]+']);
Route::get('/bilder/{gallery?}/{image?}', [BilderController::class, 'show_image'])->name('bilder.gallery.image')->where(['gallery' => '[0-9]+', 'image' => '[0-9]+']);
/**
 * CSS + JS
 */
Route::get('/css', [CSSJSController::class, 'css'])->name('css');
Route::get('/js', [CSSJSController::class, 'js'])->name('js');
Route::get('/img/{image?}', [ImageController::class, 'getimage'])->name('image.get');
/**
 * Ajax
 */
Route::group(['prefix' => '/ajax'], function () {
    Route::get('/unwetter', [WetterController::class, 'unwetter'])->name('ajax.unwetter');
    Route::get('/wetter', [WetterController::class, 'wetter'])->name('ajax.wetter');
    Route::get('/karte', [KarteController::class, 'karte_show'])->name('ajax.karte');
    Route::get('/FacebookBox', [LinkToFacebookController::class, 'facebook_show'])->name('ajax.facebookbox');
});

Route::get('/feuerwehrlexikon/{abc?}', [FeuerwehrlexikonController::class, 'lexikon_show'])->name('fwlexikon');
Route::get('/schiffstraffic', [SchiffstrafficController::class, 'schiffe_show'])->name('schiffstraffic');


Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap.xml', [PageController::class, 'sitemap_xml'])->name('sitemap.xml');
Route::get('/error/404', [PageController::class, 'page_show'])->name('error.404');
Route::get('/error/404', [PageController::class, 'page_show'])->name('404');

Route::get('/{slug}', [PageController::class, 'page_show'])->name('pages');
