<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    /** Endpoints for users table */
    $app->get('/users', \App\Action\UsersAction::class);
    $app->get('/users/{id}', \App\Action\UserAction::class);
    $app->post('/users/register', \App\Action\UserAddAction::class);
    $app->post('/users/login', \App\Action\UserLoginAction::class);
    $app->put('/users/update/{id}', \App\Action\UserUpdateAction::class);
    $app->delete('/users/delete/{id}', \App\Action\UserDeleteAction::class);

    /** Endpoints for categories table */
    $app->get('/categories', \App\Action\CategoriesAction::class);
    $app->get('/categories/{id}', \App\Action\CategoryAction::class);

    /** Endpoints for cart table */
    $app->get('/cart', \App\Action\CartsAction::class);
    $app->get('/cart/{id}', \App\Action\CartAction::class);
    $app->post('/cart/add', \App\Action\CartAddAction::class);
    $app->delete('/cart/delete/{id}', \App\Action\CartDeleteAction::class);

    /** Endpoints for prodcuts table */
    $app->get('/products', \App\Action\ProductsAction::class);
    $app->get('/products/{id}', \App\Action\ProductAction::class);
    $app->get('/products-featured', \App\Action\ProductsFeaturedAction::class);
    $app->get('/products-category/{id}', \App\Action\ProductsCategoryAction::class);

    /** Endpoints for roles table */
    $app->get('/roles', \App\Action\RolesAction::class);
    $app->get('/roles/{id}', \App\Action\RoleAction::class);

};
