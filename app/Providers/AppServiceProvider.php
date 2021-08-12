<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\ConversationRepository\ConversationRepository;
use App\Repositories\ConversationRepository\ConversationRepositoryInterface;
use App\Repositories\ReceiptRepository\ReceiptRepository;
use App\Repositories\ReceiptRepository\ReceiptRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\DocumentRepository\DocumentRepository;
use App\Repositories\DocumentRepository\DocumentRepositoryInterface;
use App\Repositories\MessageRepository\MessageRepository;
use App\Repositories\MessageRepository\MessageRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->singleton(
            DocumentRepositoryInterface::class,
            DocumentRepository::class
        );
        $this->app->singleton(
            ReceiptRepositoryInterface::class,
            ReceiptRepository::class
        );
        $this->app->singleton(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );
        $this->app->singleton(
            ConversationRepositoryInterface::class,
            ConversationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
