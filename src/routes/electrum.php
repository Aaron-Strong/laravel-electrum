<?php

use Illuminate\Support\Facades\Route;

if (config('electrum.web_interface.enabled', false)) {
    Route::prefix(config('electrum.web_interface.prefix', 'electrum'))->group(function () {
        Route::get('/', 'AraneaDev\Electrum\App\IndexController');

        Route::prefix('api')->group(function () {
            Route::get('status', 'AraneaDev\Electrum\App\Api\StatusController');

            Route::get('history', 'AraneaDev\Electrum\App\Api\HistoryController@index');
            Route::get('history/{address}', 'AraneaDev\Electrum\App\Api\HistoryController@show')
                ->where('address', '^(ltc1|[LM])[a-zA-HJ-NP-Z0-9]{26,40}$');
            Route::get('history/tx/{txid}', 'AraneaDev\Electrum\App\Api\HistoryController@details');

            Route::get('addresses', 'AraneaDev\Electrum\App\Api\AddressController@index');
            Route::get('addresses/unused', 'AraneaDev\Electrum\App\Api\AddressController@unused');
            Route::get('addresses/is_mine{address}', 'AraneaDev\Electrum\App\Api\AddressController@is_mine')
                ->where('address', '^(ltc1|[LM])[a-zA-HJ-NP-Z0-9]{26,40}$');
            Route::get('addresses/{address}', 'AraneaDev\Electrum\App\Api\AddressController@check')
                ->where('address', '^(ltc1|[LM])[a-zA-HJ-NP-Z0-9]{26,40}$');

            Route::prefix('requests')->group(function () {
                Route::get('/', 'AraneaDev\Electrum\App\Api\RequestsController@index');
                Route::get('{address}', 'AraneaDev\Electrum\App\Api\RequestsController@show')
                    ->where('address', '^(ltc1|[LM])[a-zA-HJ-NP-Z0-9]{26,40}$');

                Route::post('/', 'AraneaDev\Electrum\App\Api\RequestsController@create');

                Route::delete('/', 'AraneaDev\Electrum\App\Api\RequestsController@clear');
                Route::delete('{address}', 'AraneaDev\Electrum\App\Api\RequestsController@destroy')
                    ->where('address', '^(ltc1|[LM])[a-zA-HJ-NP-Z0-9]{26,40}$');
            });
        });
    });
}
