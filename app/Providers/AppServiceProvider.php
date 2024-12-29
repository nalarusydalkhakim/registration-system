<?php

namespace App\Providers;

use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\DepartmentRepositoryInterface;
use App\Interfaces\DepartmentRequirementRepositoryInterface;
use App\Interfaces\RegistrationGradeRepositoryInterface;
use App\Interfaces\RegistrationRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\DepartmentRequirementRepository;
use App\Repositories\RegistrationGradeRepository;
use App\Repositories\RegistrationRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(DepartmentRequirementRepositoryInterface::class, DepartmentRequirementRepository::class);
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepository::class);
        $this->app->bind(RegistrationGradeRepositoryInterface::class, RegistrationGradeRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
