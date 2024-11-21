<?php

Route::get('/business/{business_id}/invoice/{invoice_id}/view', 'Invoice@viewInvoice')->name('business.invoices.view');
Route::get('/business/{business_id}/invoice/{invoice_id}/login', 'Invoice@loginViewInvoice')->name('business.invoices.login');

Route::get('/', 'HomeController@index');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::redirect('/home', '/')->name('home');
    Route::get('/page/{ref}', 'Business@viewPage');

    // Debit Card
    Route::get('/debit-card/{id}/add', 'UserDashboard@addDebitCard');

    Route::group(['middleware' => ['role:USER']], function () {
        Route::get('/dashboard', 'UserDashboard@index')->name('dashboard');
        Route::get('/profile', 'UserDashboard@profile')->name('profile');
        Route::post('/profile', 'UserDashboard@updateProfile')->name('update-profile');
        Route::get('/business', 'Business@index')->name('my-business');
        Route::get('/business/add', 'Business@create')->name('add-business');
        Route::post('/business/store', 'Business@store')->name('business.store');

        Route::get('/invoices-received', 'UserDashboard@received')->name('user.invoices.received');
        Route::get('/invoices-received-json', 'UserDashboard@invoicesReceivedJson')->name('user.invoices.received.json');
        Route::get('/invoices-received/{id}', 'UserDashboard@viewInvoice')->name('user.invoices.view');

        Route::get('/products-purchased', 'UserDashboard@productsPurchased')->name('products.purchased');
        Route::get('/settings', 'UserDashboard@settings')->name('user-settings');
        Route::post('/save-settings', 'UserDashboard@saveSettings')->name('update-settings');

        // single business
        Route::prefix('/business/{id}')->name('business.')->group(function () {
            Route::get('/dashboard', 'Business@businessDashboard')->name('dashboard');
            Route::get('/edit', 'Business@edit')->name('edit');
            Route::get('/delete', 'Business@delete')->name('delete');
            Route::post('/update', 'Business@update')->name('update');
            Route::get('/edit-message/{message_id}', 'Business@editBusinessMessage')->name('edit-message');
            Route::post('/update-message/{message_id}', 'Business@updateBusinessMessage')->name('update-message');
            Route::get('/delete-message/{message_id}', 'Business@deleteBusinessMessage')->name('delete-message');

            // Customers
            Route::get('/customers/import/{type}', 'Customers@import')->name('customers.import');
            Route::post('/customers/import-csv', 'Customers@importCSV')->name('customers.import-csv');
            Route::get('/customers/import-google', 'Customers@importGoogle')->name('customers.import-google');
            Route::resource('/customers', 'Customers');

            // Products
            Route::get('/products', 'Product@index')->name('products');
            Route::get('/add-product', 'Product@create')->name('add.product');
            Route::post('/add-product', 'Product@store')->name('save.add.product');
            Route::get('/edit-product/{product_id}', 'Product@edit')->name('edit.product');
            Route::get('/restock-product/{product_id}', 'Product@restock')->name('restock.product');
            Route::get('/product-stocks/{product_id}', 'Product@productStocks')->name('stocks.product');
            Route::post('/restock-product/{product_id}', 'Product@restock')->name('restock.product');
            Route::patch('/update-product/{product_id}', 'Product@update')->name('update.product');
            Route::get('/delete-product/{product_id}', 'Product@destroy')->name('delete.product');
            Route::get('/delete-stock/{stock_id}', 'Product@deleteStock')->name('delete.stock');

            // Projects
            Route::get('/projects', 'Project@index')->name('projects');
            Route::get('/add-project', 'Project@create')->name('add.project');
            Route::post('/add-project', 'Project@store')->name('save.add.project');
            Route::get('/edit-project/{product_id}', 'Project@edit')->name('edit.project');
            Route::patch('/update-project/{product_id}', 'Project@update')->name('update.project');
            Route::get('/delete-project/{product_id}', 'Project@destroy')->name('delete.project');

            // Invoices
            Route::get('/invoice', 'Invoice@index')->name('invoices');
            Route::get('/invoice/{invoice_id}/resend', 'Invoice@resend')->name('invoices.edit');
            Route::get('/invoice/{invoice_id}/edit', 'Invoice@edit')->name('invoices.edit');
            Route::get('/invoice/{invoice_id}/delete', 'Invoice@deleteInvoice')->name('invoices.delete');
            Route::patch('/invoice/{invoice_id}/update', 'Invoice@update')->name('invoices.update');
            Route::get('/invoice-json', 'Invoice@indexJson')->name('invoices.json');
            Route::get('/invoice/send/{product_id?}', 'Invoice@create')->name('send.invoice');
            Route::post('/invoice/add', 'Invoice@store')->name('save.send.invoice');
            Route::get('/invoice/{invoice_id}/payment/{ref}', 'Invoice@makePayment');


            // ItemsReturnedToSupplier
            Route::get('/items-returned-to-supplier/add', 'ItemsReturnedToSupplier@add')->name('add.item.returned.to.supplier');
            Route::post('/items-returned-to-supplier/save', 'ItemsReturnedToSupplier@save')->name('save.item.returned.to.supplier');
            Route::get('/items-returned-to-supplier', 'ItemsReturnedToSupplier@index')->name('items.returned.to.supplier');
            Route::get('/items-returned-to-supplier-json', 'ItemsReturnedToSupplier@indexJson')->name('items.returned.to.supplier.json');

            // ItemsReturnedByCustomer
            Route::get('/items-returned-by-customer/add', 'ItemsReturnedByCustomer@add')->name('add.item.returned.by.customer');
            Route::post('/items-returned-by-customer/save', 'ItemsReturnedByCustomer@save')->name('save.item.returned.by.customer');
            Route::post('/items-returned-by-customer/get-invoice', 'ItemsReturnedByCustomer@addFetch')->name('save.item.returned.by.customer.fetch');
            Route::get('/items-returned-by-customer', 'ItemsReturnedByCustomer@index')->name('items.returned.by.customer');
            Route::get('/items-returned-by-customer-json', 'ItemsReturnedByCustomer@indexJson')->name('items.returned.by.customer.json');


            // Business Expenses
            Route::get('/expenses', 'BusinessExpenses@index')->name('expenses.index');
            Route::get('/expenses/json', 'BusinessExpenses@indexJson')->name('expenses.json');
            Route::get('/expenses/add', 'BusinessExpenses@create')->name('expenses.add');
            Route::post('/expenses/store', 'BusinessExpenses@store')->name('expenses.store');
            Route::get('/expenses/{expenses_id}/delete', 'BusinessExpenses@destroy')->name('expenses.delete');


            // Business Incomes
            Route::get('/incomes', 'BusinessIncomes@index')->name('incomes.index');
            Route::get('/incomes/json', 'BusinessIncomes@indexJson')->name('incomes.json');
            Route::get('/incomes/add', 'BusinessIncomes@create')->name('incomes.add');
            Route::post('/incomes/store', 'BusinessIncomes@store')->name('incomes.store');
            Route::get('/incomes/{expenses_id}/delete', 'BusinessIncomes@destroy')->name('incomes.delete');


            Route::get('/receivables-and-payables', 'Business@receivablePayable')->name('receivables.and.payables');
            Route::get('/receivables-json', 'Business@receivablesJson')->name('receivables.json');
            Route::get('/payables-json', 'Business@payablesJson')->name('payables.json');

            // settings
            Route::prefix('settings')->name('settings.')->group(function () {

                // Promotion and Ads
                Route::prefix('promotions')->name('promotions.')->group(function () {
                    // Birthday
                    Route::get('/birthday', 'PromoAds@birthday')->name('birthday');
                    Route::get('/add-birthday-message', 'PromoAds@addBirthdayMessageView')->name('add-birthday-message-view');
                    Route::post('/birthday', 'PromoAds@addBirthdayMessage')->name('add-birthday-message');

                    // Holiday
                    Route::get('/holiday', 'PromoAds@holiday')->name('holiday');
                    Route::get('/add-holiday-message', 'PromoAds@addHolidayMessageView')->name('add-holiday-message-view');
                    Route::post('/holiday', 'PromoAds@addHolidayMessage')->name('add-holiday-message');

                    Route::get('/tell-a-friend', 'PromoAds@tellAFriend')->name('tell-a-friend');
                    Route::get('/add-promopage', 'PromoAds@addPromoPage')->name('add-promopage');
                    Route::post('/add-promopage', 'PromoAds@createPromoPage')->name('promopage.add');
                    Route::get('/edit-promopage/{page_id}', 'PromoAds@createPromoPage')->name('promopage.edit');
                    Route::get('/delete-promopage/{page_id}', 'PromoAds@createPromoPage')->name('promopage.delete');


                    Route::get('/giveaways-and-freebies', 'PromoAds@birthday')->name('giveaways-and-freebies');
                });

                // Bank
                Route::get('/banks', 'Bank@index')->name('banks');
                Route::get('/banks/add', 'Bank@create')->name('add.bank');
                Route::get('/banks/add', 'Bank@create')->name('add.bank');
                Route::get('/banks/{ba_id}/edit', 'Bank@edit')->name('edit.bank');
                Route::post('/banks/add', 'Bank@store')->name('save.add.bank');
                Route::post('/banks/{ba_id}/update', 'Bank@update')->name('update.bank');
                Route::get('/banks/{ba_id}/delete', 'Bank@deleteAccount')->name('delete.bank');

                // New Item Alert
                Route::get('/new-item-alert', 'PromoAds@newItemAlert')->name('new-item-alert');
                Route::get('/add-new-item-alert', 'PromoAds@addNewItemAlertView')->name('add-new-item-alert-view');
                Route::post('/new-item-alert', 'PromoAds@addNewItemAlert')->name('add-new-item-alert');
            });

            Route::get('/activities', 'Business@activities')->name('activities');
            Route::get('/add-admin', 'Business@businessDashboard')->name('add.admin');
            Route::get('/settings', 'Business@businessDashboard')->name('settings');
        });


        // WALLET
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('/', 'WalletController@index')->name('wallet');
            Route::get('/get-transfer-charge/{amount}', 'WalletController@getChargeRequest');
            Route::get('/transactions', 'WalletController@transactions')->name('wallet.transaction.all');
            Route::get('/transfer-requests', 'WalletController@transferRequests')->name('wallet.transfer-request');
            Route::post('/transfer-requests', 'WalletController@makeTransferRequest')->name('wallet.make-transfer-request');
            Route::get('/transfer-requests/make', 'WalletController@transferRequestView')->name('wallet.transfer-request-view');
            Route::view('/topup', 'pages.wallet.topup', ['paystack_key' => env('PAYSTACK_PK')]);
            Route::post('/topup', 'WalletController@topup')->name('wallet.topup');
            Route::get('/transfers', 'WalletController@walletTransfers')->name('wallet.transfers');
            Route::view('/transfer', 'pages.wallet.transfer');
            Route::post('/transfer', 'WalletController@transferToWallet')->name('wallet.transfer');
        });
    });

    Route::group(['middleware' => ['role:ADMIN']], function () {
        Route::get('/users', 'AdminDashboard@users')->name('users');
        Route::get('/businesses', 'AdminDashboard@businesses')->name('businesses');

        Route::get('/wallet/transfer-requests/approve/{id}', 'WalletController@approveTransferRequest');
        Route::get('/wallet/transfer-requests/deny/{id}', 'WalletController@denyTransferRequest');
    });
});


Auth::routes(['verify' => true]);
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});

// redirect
Route::get('/u/{uri}', function ($brand) {
    return \App\Repository\Rebrand::process($brand);
});
//3e4d67
