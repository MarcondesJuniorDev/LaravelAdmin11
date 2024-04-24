<?php

use App\Http\Controllers\Admin\Acl\PermissionController;
use App\Http\Controllers\Admin\Acl\RoleController;
use App\Http\Controllers\Admin\Acl\UserController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\LMS\CourseCategoryController;
use App\Http\Controllers\Admin\LMS\CourseController;
use App\Http\Controllers\Admin\LMS\GradeController;
use App\Http\Controllers\Admin\LMS\LessonController;
use App\Http\Controllers\Admin\LMS\SchoolYearController;
use App\Http\Controllers\Admin\LMS\SubjectController;
use App\Http\Controllers\Admin\Posts\AwardController;
use App\Http\Controllers\Admin\Posts\BannerController;
use App\Http\Controllers\Admin\Posts\NewsController;
use App\Http\Controllers\Admin\Posts\SlideController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('usuarios')->group(function () {
        Route::get('/tabela-de-usuarios', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/criar-usuario', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/criar-usuario', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/editar-usuario/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/editar-usuario/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/excluir-usuario/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('permissoes')->group(function () {
        Route::get('/tabela-de-permissoes', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('/criar-permissao', [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('/criar-permissao', [PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::get('/editar-permissao/{id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::put('/editar-permissao/{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('/excluir-permissao/{id}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
    });

    Route::prefix('funcoes')->group(function () {
        Route::get('/tabela-de-funcoes', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/criar-funcao', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/criar-funcao', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/editar-funcao/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/editar-funcao/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/excluir-funcao/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    });

    Route::prefix('departamentos')->group(function () {
        Route::get('/tabela-de-departamentos', [DepartmentController::class, 'index'])->name('admin.departments.index');
        Route::get('/criar-departamento', [DepartmentController::class, 'create'])->name('admin.departments.create');
        Route::post('/criar-departamento', [DepartmentController::class, 'store'])->name('admin.departments.store');
        Route::get('/editar-departamento/{id}', [DepartmentController::class, 'edit'])->name('admin.departments.edit');
        Route::put('/editar-departamento/{id}', [DepartmentController::class, 'update'])->name('admin.departments.update');
        Route::delete('/excluir-departamento/{id}', [DepartmentController::class, 'destroy'])->name('admin.departments.destroy');
    });

    Route::prefix('noticias')->group(function () {
        Route::get('/tabela-de-noticias', [NewsController::class, 'index'])->name('admin.news.index');
        Route::get('/criar-noticia', [NewsController::class, 'create'])->name('admin.news.create');
        Route::post('/criar-noticia', [NewsController::class, 'store'])->name('admin.news.store');
        Route::get('/editar-noticia/{id}', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::put('/editar-noticia/{id}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::delete('/excluir-noticia/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
    });

    Route::prefix('banners')->group(function () {
        Route::get('/tabela-de-banners', [BannerController::class, 'index'])->name('admin.banners.index');
        Route::get('/criar-banner', [BannerController::class, 'create'])->name('admin.banners.create');
        Route::post('/criar-banner', [BannerController::class, 'store'])->name('admin.banners.store');
        Route::get('/editar-banner/{id}', [BannerController::class, 'edit'])->name('admin.banners.edit');
        Route::put('/editar-banner/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
        Route::delete('/excluir-banner/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    });

    Route::prefix('slides')->group(function () {
        Route::get('/tabela-de-slides', [SlideController::class, 'index'])->name('admin.slides.index');
        Route::get('/criar-slide', [SlideController::class, 'create'])->name('admin.slides.create');
        Route::post('/criar-slide', [SlideController::class, 'store'])->name('admin.slides.store');
        Route::get('/editar-slide/{id}', [SlideController::class, 'edit'])->name('admin.slides.edit');
        Route::put('/editar-slide/{id}', [SlideController::class, 'update'])->name('admin.slides.update');
        Route::delete('/excluir-slide/{id}', [SlideController::class, 'destroy'])->name('admin.slides.destroy');
    });

    Route::prefix('premiacoes')->group(function () {
        Route::get('/tabela-de-premiacoes', [AwardController::class, 'index'])->name('admin.awards.index');
        Route::get('/criar-premiacao', [AwardController::class, 'create'])->name('admin.awards.create');
        Route::post('/criar-premiacao', [AwardController::class, 'store'])->name('admin.awards.store');
        Route::get('/editar-premiacao/{id}', [AwardController::class, 'edit'])->name('admin.awards.edit');
        Route::put('/editar-premiacao/{id}', [AwardController::class, 'update'])->name('admin.awards.update');
        Route::delete('/excluir-premiacao/{id}', [AwardController::class, 'destroy'])->name('admin.awards.destroy');
    });

    Route::prefix('aulas')->group(function () {
        Route::get('/tabela-de-aulas', [LessonController::class, 'index'])->name('admin.lessons.index');
        Route::get('/criar-aula', [LessonController::class, 'create'])->name('admin.lessons.create');
        Route::post('/criar-aula', [LessonController::class, 'store'])->name('admin.lessons.store');
        Route::get('/editar-aula/{id}', [LessonController::class, 'edit'])->name('admin.lessons.edit');
        Route::put('/editar-aula/{id}', [LessonController::class, 'update'])->name('admin.lessons.update');
        Route::delete('/excluir-aula/{id}', [LessonController::class, 'destroy'])->name('admin.lessons.destroy');
    });

    Route::prefix('series')->group(function () {
        Route::get('/tabela-de-series', [GradeController::class, 'index'])->name('admin.grades.index');
        Route::get('/criar-serie', [GradeController::class, 'create'])->name('admin.grades.create');
        Route::post('/criar-serie', [GradeController::class, 'store'])->name('admin.grades.store');
        Route::get('/editar-serie/{id}', [GradeController::class, 'edit'])->name('admin.grades.edit');
        Route::put('/editar-serie/{id}', [GradeController::class, 'update'])->name('admin.grades.update');
        Route::delete('/excluir-serie/{id}', [GradeController::class, 'destroy'])->name('admin.grades.destroy');
    });

    Route::prefix('cursos')->group(function () {
        Route::get('/tabela-de-cursos', [CourseController::class, 'index'])->name('admin.courses.index');
        Route::get('/criar-curso', [CourseController::class, 'create'])->name('admin.courses.create');
        Route::post('/criar-curso', [CourseController::class, 'store'])->name('admin.courses.store');
        Route::get('/editar-curso/{id}', [CourseController::class, 'edit'])->name('admin.courses.edit');
        Route::put('/editar-curso/{id}', [CourseController::class, 'update'])->name('admin.courses.update');
        Route::delete('/excluir-curso/{id}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');
    });

    Route::prefix('categorias-de-cursos')->group(function () {
        Route::get('/tabela-de-categorias-de-cursos', [CourseCategoryController::class, 'index'])->name('admin.course.categories.index');
        Route::get('/criar-categoria-de-curso', [CourseCategoryController::class, 'create'])->name('admin.course.categories.create');
        Route::post('/criar-categoria-de-curso', [CourseCategoryController::class, 'store'])->name('admin.course.categories.store');
        Route::get('/editar-categoria-de-curso/{id}', [CourseCategoryController::class, 'edit'])->name('admin.course.categories.edit');
        Route::put('/editar-categoria-de-curso/{id}', [CourseCategoryController::class, 'update'])->name('admin.course.categories.update');
        Route::delete('/excluir-categoria-de-curso/{id}', [CourseCategoryController::class, 'destroy'])->name('admin.course.categories.destroy');
    });

    Route::prefix('componentes-curriculares')->group(function () {
        Route::get('/tabela-de-componentes-curriculares', [SubjectController::class, 'index'])->name('admin.subjects.index');
        Route::get('/criar-componente-curricular', [SubjectController::class, 'create'])->name('admin.subjects.create');
        Route::post('/criar-componente-curricular', [SubjectController::class, 'store'])->name('admin.subjects.store');
        Route::get('/editar-componente-curricular/{id}', [SubjectController::class, 'edit'])->name('admin.subjects.edit');
        Route::put('/editar-componente-curricular/{id}', [SubjectController::class, 'update'])->name('admin.subjects.update');
        Route::delete('/excluir-componente-curricular/{id}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');
    });

    Route::prefix('anos-letivos')->group(function () {
        Route::get('/tabela-de-anos-letivos', [SchoolYearController::class, 'index'])->name('admin.school.year.index');
        Route::get('/criar-ano-letivo', [SchoolYearController::class, 'create'])->name('admin.school.year.create');
        Route::post('/criar-ano-letivo', [SchoolYearController::class, 'store'])->name('admin.school.year.store');
        Route::get('/editar-ano-letivo/{id}', [SchoolYearController::class, 'edit'])->name('admin.school.year.edit');
        Route::put('/editar-ano-letivo/{id}', [SchoolYearController::class, 'update'])->name('admin.school.year.update');
        Route::delete('/excluir-ano-letivo/{id}', [SchoolYearController::class, 'destroy'])->name('admin.school.year.destroy');
    });

    Route::prefix('comentarios')->group(function () {
        Route::get('/tabela-de-comentarios', [CommentController::class, 'index'])->name('admin.comments.index');
        Route::get('/criar-comentario', [CommentController::class, 'create'])->name('admin.comments.create');
        Route::post('/criar-comentario', [CommentController::class, 'store'])->name('admin.comments.store');
        Route::get('/editar-comentario/{id}', [CommentController::class, 'edit'])->name('admin.comments.edit');
        Route::put('/editar-comentario/{id}', [CommentController::class, 'update'])->name('admin.comments.update');
        Route::delete('/excluir-comentario/{id}', [CommentController::class, 'destroy'])->name('admin.comments.destroy');
    });
});
