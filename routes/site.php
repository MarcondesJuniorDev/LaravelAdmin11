<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('site.home');

Route::get('/quem-somos/historico', [SiteController::class, 'aboutHistory'])->name('about.history');
Route::get('/quem-somos/organograma', [SiteController::class, 'aboutOrgChart'])->name('about.orgchart');
Route::get('/quem-somos/projetos', [SiteController::class, 'aboutProjects'])->name('about.projects');
Route::get('/quem-somos/parceiros', [SiteController::class, 'aboutPartners'])->name('about.partners');

Route::get('/aulas/ensino-fundamental', [SiteController::class, 'elementarySchool'])->name('lessons.elementary');
Route::get('/aulas/ensino-medio', [SiteController::class, 'highSchool'])->name('lessons.highschool');
Route::get('/aulas/ensino-fundamental-eja', [SiteController::class, 'adultElementaryEducation'])->name('lessons.adult.elementary');
Route::get('aulas/ensino-medio-eja', [SiteController::class, 'adultHighEducation'])->name('lessons.adult.highschool');

Route::get('/premiacoes', [SiteController::class, 'awards'])->name('awards');

Route::get('/fique-por-dentro/eventos', [SiteController::class, 'stayinEvents'])->name('stayin.events');
Route::get('/fique-por-dentro/noticias', [SiteController::class, 'stayinNews'])->name('stayin.news');
Route::get('/fique-por-dentro/publicacoes', [SiteController::class, 'stayinPublications'])->name('stayin.publications');

Route::get('/entre-em-contato', [SiteController::class, 'contact'])->name('contact');
