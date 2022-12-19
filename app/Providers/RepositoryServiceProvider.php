<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Item\ItemRepository;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\SubCategory\SubCategoryRepository;
use App\Repositories\SubCategory\SubCategoryRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(SubCategoryRepositoryInterface::class, SubCategoryRepository::class);
        $this->app->singleton(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
    }
}
