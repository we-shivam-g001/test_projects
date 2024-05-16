<?php

Route::group(
    [
        'prefix'     => '/',
        'middleware' => ['web'],
        'namespace' => 'Frontend',
    ],
    function () {
        //------------------------------------------------
        Route::get( '/login', 'AuthController@login' )
        ->name( 'login' );
        //------------------------------------------------
        Route::get( '/signout', 'AuthController@signout' )
        ->name( 'vh.frontend.projects.signout' );
        //------------------------------------------------
        Route::get( '/signin', 'AuthController@signin' )
        ->name( 'vh.frontend.projects.signin' );
        //------------------------------------------------
        Route::post( '/signin/post', 'AuthController@signinPost' )
        ->name( 'vh.frontend.projects.signin.post' );
        //------------------------------------------------
        Route::post( '/signin/send/otp', 'AuthController@sendOtp' )
        ->name( 'vh.frontend.projects.signin.send.otp' );
        //------------------------------------------------
        Route::post( '/signin/send/reset/code', 'AuthController@sendResetCode' )
        ->name( 'vh.frontend.projects.signin.send.reset.code' );
        //------------------------------------------------
        Route::post( '/signin/password/reset', 'AuthController@passwordResetAndSignin' )
        ->name( 'vh.frontend.projects.signin.password.reset' );
        //------------------------------------------------
        Route::get( '/signup', 'AuthController@signup' )
        ->name( 'vh.frontend.projects.signup' );
        //------------------------------------------------
        Route::post( '/signup/post', 'AuthController@signupPost' )
        ->name( 'vh.frontend.projects.signup.post' );
        //------------------------------------------------
        Route::get( '/signup/activate/{code}', 'AuthController@activate' )
        ->name( 'vh.frontend.projects.signup.activate' );
        //------------------------------------------------
        Route::any( '/signup/activate/{code}/available', 'AuthController@subDomainAvailable' )
        ->name( 'vh.frontend.projects.signup.activate.available' );
        //------------------------------------------------
        Route::any( '/signup/activate/{code}/post', 'AuthController@activatePost' )
        ->name( 'vh.frontend.projects.signup.activate.post' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
