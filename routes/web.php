<?php

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


Auth::routes(['verify' => true]);
Route::get('/', 'IndexController@create')->name('home');
Route::get('/home', 'IndexController@create')->name('home')->middleware('verified');
Route::get('/sell', 'sellController@create')->name('sell');
Route::get('/membership', 'MembershipController@create')->name('membership');
Route::get('/about-us', 'AboutUsController@create')->name('about-us');
Route::get('/account-type', 'IndexController@account_type')->name('account_type');
Route::post('/subscriber', 'SubscribersController@store')->name('subscriber');

//Route::post('/account-registration', 'Auth\RegisterController@save_account_type')->name('account_type');
// Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');


// Authentication routes...
Route::get('/login', 'auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('/login', 'auth\LoginController@postLogin');
Route::get('/logout', 'auth\LoginController@Logout')->name('logout');
Route::post('/logout', 'auth\LoginController@Logout')->name('logout');
// Registration routes...
Route::get('/account-registration', 'auth\RegisterController@showRegistrationForm')->name('register')->middleware('guest')->middleware(AccountType::class);
Route::get('/register', 'auth\RegisterController@showRegistrationForm')->name('register')->middleware('guest')->middleware(AccountType::class);
Route::post('/register', 'auth\RegisterController@register');
Route::post('/account-registration', 'auth\RegisterController@save_account_type')->name('account_type');

//super user
/*
Route::get('/super-login', 'auth\LoginController@showAdminLoginForm')->name('super_user_login')->middleware('guest');
Route::post('/super-login', 'auth\LoginController@checklogin')->name('super_user_login')->middleware('guest');

Route::get('/super-register', 'auth\RegisterController@Adminregister')->name('super_user_register')->middleware('guest');
Route::post('/super-register', 'auth\RegisterController@registerAdmin')->name('super_user_register')->middleware('guest');

*/
//verify email route
//Route::post('/verify', 'Auth\RegisterController@save_account_type')->name('account_type');

Route::get('/autocomplete', 'SearchController@index');
Route::post('/autocomplete/fetch', 'SearchController@livesearch')->name('autocomplete.fetch');
Route::get('/search/{pd_name}', 'SearchController@search');
Route::get('/search', 'SearchController@formsearch');;
Route::post('/search', 'SearchController@formsearch')->name('formsearch');

//Auth::routes(['verify' => true, 'register' => false, 'login' => false]);


Route::post('/subcats', 'SubCategoryController@show')->name('subcats');
Route::post('/lastcats', 'LastCategoryController@show')->name('lastcats');



Route::get('/buying-request', 'BuyingRequestController@create')->name('BuyingRequest');
Route::post('/buying-request', 'BuyingRequestController@store')->name('BuyingRequest'); // stores all buying request data
//selling reuests

Route::get('/selling-request', 'SellingRequestsController@create')->name('SellingRequest'); //returns a Selling requests view
Route::post('/selling-request', 'SellingRequestsController@store')->name('SellingRequest'); // stores all Selling request data
Route::get('/all-selling-requests', 'SellingRequestsController@allSellingView')->name('allSellingRequests');
Route::get('/send-a-sell-message/{request_id}', 'SellingRequestsController@sendAmessageView')->name('sendSellingRequestOfferMessage');
Route::get('/send-a-buy-message/{request_id}', 'BuyingRequestController@sendAmessageView')->name('sendBuyingRequestOfferMessage');

Route::get('/all-buying-requests', 'BuyingRequestController@allBuyingView')->name('allBuyingRequests'); //returns a buying requests view
Route::get('/suppliers', 'SupplierController@showAll')->name('suppliers');

//Route::get('/suppliers/{industry}', 'SupplierController@findByIndustry')->name('sortByIndustry');//
Route::post('/singleBuyingRequest', 'BuyingRequestController@allBuyingSingleView')->name('singleBuyingRequest')->middleware('auth'); //returns a single buying requests before making an offer
Route::post('/singleSellingRequest', 'SellingRequestsController@allSellingSingleView')->name('singleSellingRequest')->middleware('auth'); //returns a single buying requests before making an offer
Route::post('/messages/{msg_to_id}', 'MessageController@store')->name('messages'); // stores all buying request data
Route::get('/supplier/{supplier_id}', 'SupplierController@show')->name('supplier');
Route::get('/contact-supplier/product/{product_id}/supplier/{supplier_id}', 'SupplierController@create')->name('contactSupplier')->middleware('auth');
Route::post('/contact-supplier', 'SupplierController@store')->name('contactSupplierStore');
Route::get('/products-by-category/{sub_cat_name}/{sub_category_id}', 'ProductsByCategoryController@create')->name('getFeaturedCats');
Route::get('/products-by-last-category/{last_cat_name}/{last_category_id}', 'ProductsByCategoryController@showByCat')->name('contactSupplier');
Route::get('/product-details/{product_id}', 'ProductController@showProductDetails')->name('showProduct');
Route::post('/reviews', 'ReviewController@store')->name('reviews'); //
Route::get('/showReview', 'ReviewController@showReview')->name('showReviewAjax'); //
Route::get('/product/{pd_id}/reviews', 'ReviewController@showReviews')->name('showReviews'); //returns a single buying requests before making an offer
Route::get('/categories', 'ProductCategoryController@showCategories')->name('categories'); //returns a single buying requests before making an offer
Route::get('/services', 'ServicesController@create')->name('services');

Route::get('/filter-by-price', 'SearchController@filterByPrice')->name('filterByPrice');
Route::post('/filter-by-price', 'SearchController@filterByPrice')->name('filterByPrice');


Route::group(['prefix' => 'u', 'middleware' => 'auth'], function () {
    Route::get('/u', 'AdminIndexController@create')->name('admin.index');
    Route::get('/profile', 'ProfileController@show')->name('Profile');
    Route::patch('/profile', 'ProfileController@update')->name('Profile');
    Route::post('/profile/certificate', 'ProfileController@saveCertificates')->name('saveCertificates');
    Route::post('/questions-answers', 'QuestionsController@storeProductFAQ')->name('productFAQ');
    Route::get('/get-answer', 'AnswersController@getAnswer')->name('showAnswer');
    Route::post('/update-answer', 'AnswersController@updateAnswer')->name('updateAnswer');
    Route::get('/get-question', 'QuestionsController@getQuestion')->name('showQuestion');
    Route::post('/update-question', 'QuestionsController@updateQuestion')->name('updateQuestion');
    Route::post('/deleteQuestionAndAswer', 'QuestionsController@deleteQuestionAndAswer')->name('deleteQuestionAndAswer');
    Route::get('/notifications', 'NotificationsController@create')->name('notifications');
    Route::post('/deleteNotification', 'NotificationsController@destroy')->name('deleteNotification');
    Route::post('/deleteAllNotification', 'NotificationsController@destroyAll')->name('deleteAllNotification');
    Route::post('/profile/delete-certificate', 'ProfileController@deleteCompanyCertificate');
    Route::post('/profile', 'ExportCapabilityController@save')->name('export-capabilities');
    Route::get('/business-card', 'ProfileController@showBusinessCard')->name('business_card');
    Route::post('/business-card', 'ProfileController@storeCardDetails')->name('storeCardDetails'); //
    Route::get('/add-new-product', 'ProductController@create')->name('add-new-product');
    Route::post('/add-new-product', 'ProductController@store')->name('addingNewProduct');
    // Route::get('/product-analytics/{product_id}', 'ProductController@productAnalytics')->name('productAnalytics');
    Route::post('/showSpecList', 'SpecificationController@showSpecList');
    Route::get('/manage-products', 'ManageProductController@create')->name('manageProduct');
    Route::post('/deleteSingleProduct', 'ManageProductController@destroy')->name('deleteSingleProduct');
    Route::post('/destroyMultipleProduct', 'ManageProductController@destroyMultipleProduct')->name('destroyMultipleProduct');
    Route::get('/product/{product_id}/edit', 'ProductController@edit')->name('productEdit');
    Route::post('/product/updateSpecs', 'ProductController@updateSpecs')->name('updateSpecs');
    Route::post('/product/deleteSpecs', 'ProductController@deleteSpecs')->name('deleteSpecs');
    Route::post('/product/updateSpecOption', 'ProductController@updateSpecOption')->name('updateSpecOption');
    Route::post('/product/showSpec', 'ProductController@showSpec')->name('showSpec');
    Route::post('/product/addSpec', 'ProductController@addSpec')->name('addSpec');
    Route::post('/product/addSpecsParams', 'ProductController@addSpec')->name('addSpec');
    Route::patch('/product/{product_id}', 'ProductController@update')->name('productUpdate');
    Route::post('/delete-product-image', 'ProductController@deleteProductImg');
    Route::post('/delete-company-image', 'ProductController@deleteCompanyImg');

    //get buyer details
    Route::get('/showBuyerDetails', 'ManageUserController@showBuyerDetails')->name('showBuyerDetails'); //returns a single buying requests before making an offer
    Route::get('/manage-buying-request', 'ManageRequestsController@create');
    Route::post('/update-buying-request', 'ManageRequestsController@update')->name('update-buying-request');
    Route::post('/delete-buying-request', 'ManageRequestsController@deleteRequest')->name('delete-buying-request');

    //selling request
    Route::get('/manage-selling-request', 'ManageRequestsController@SellingView');
    Route::post('/update-selling-request', 'ManageRequestsController@updateSellingRequest')->name('update-selling-request');
    Route::post('/delete-selling-request', 'ManageRequestsController@deleteSellingRequest')->name('delete-selling-request');

    Route::get('/mailbox/inbox', 'InboxController@create')->name('inbox.index');
    Route::get('/mailbox/inbox/read/{emailId}', 'ReadEmailController@create')->name('readEmail'); //read an email
    Route::post('/updateStatus', 'MessageController@updateStatus')->name('updateStatus'); // update read email to 1
    Route::post('/destroyEmails', 'MessageController@destroyEmails')->name('destroyEmails'); //if they wish to delete email
    Route::get('/reply/{message_id}', 'ReadEmailController@reply_view')->name('reply_view'); // when they replying
    Route::post('/reply', 'ReadEmailController@store')->name('reply'); // when they replying
    Route::get('/mailbox/sent', 'SentEmailController@create')->name('SentEmail');
    Route::get('/mailbox/all-emails', 'MessageController@show')->name('allEmails');
    Route::get('/favorites', 'MyFavoriteController@create')->name('my_favorite');
    Route::post('/favorites', 'MyFavoriteController@addFavorite')->name('my_favorite');
    Route::post('/remove-favorite', 'MyFavoriteController@removeFav')->name('removeFav');
    Route::post('/search', 'SearchController@AdminEmailSearch')->name('liveSearchAdminEmail');
    Route::post('/All-email-search', 'SearchController@AdminAllEmailSearch')->name('AdminAllEmailSearch');
    Route::get('/sent-emails-search', 'SearchController@AdminSentEmailSearch')->name('liveSearchAdminSentEmail');
});

Route::group(['prefix' => 'super', 'middleware' => 'auth:admin', 'middleware' => 'AccessSuperUser'], function () {

    Route::get('/index', 'SuperIndexController@view')->name('super.index');
    Route::post('/deleteAdminNotification', 'SuperIndexController@destroy')->name('deleteAdminNotification');
    Route::post('/deleteAllAdminNotification', 'SuperIndexController@destroyAll')->name('deleteAllAdminNotification');
    Route::get('/manage-users', 'ManageUserController@create')->name('manage-users');
    Route::get('/feature-a-supplier', 'ManageUserController@featureSupplier')->name('featureSupplier');
    Route::get('/manage-reviews', 'ReviewController@create')->name('manage-reviews');
    Route::post('/approve-review', 'ReviewController@approve')->name('approveReview');
    Route::post('/suspend-review', 'ReviewController@suspend')->name('suspendReview');
    Route::post('/destroyMultiplereviews', 'ReviewController@destroyMultiplereviews');
    Route::post('/limit', 'ManageUserController@show')->name('limit');
    Route::post('/destroyMultipleUsers', 'ManageUserController@destroyMultipleUsers')->name('deleteMultipleUser');
    Route::post('/takeaction-user', 'ManageUserController@takeAction')->name('takeactionUser');
    Route::post('/feature-user', 'ManageUserController@FeatureUser')->name('FeatureUser');
    Route::get('/showUser', 'ManageUserController@showUser')->name('showUser'); //returns a single buying requests before making an offer
    Route::get('/cms-add', 'CMSController@create')->name('cmsAdd'); //
    Route::post('/cms-add', 'CMSController@store')->name('cmsAdd'); //
    Route::get('/showCms', 'CMSController@getCms')->name('getCms');
    Route::post('/cms-update', 'CMSController@update')->name('updateCms');
    Route::post('/destroyMultipleCms', 'CMSController@destroyMultipleCms');
    Route::get('/content-management', 'CMSController@show')->name('cms'); //
    Route::get('/maincategory', 'ProductCategoryController@create')->name('maincategory-add');
    Route::post('/maincategory-add', 'ProductCategoryController@store')->name('maincategory-store'); //
    Route::get('/maincategory-view', 'ProductCategoryController@viewMain');
    Route::get('/category', 'SubCategoryController@create')->name('category-add'); //
    Route::post('/category-add', 'SubCategoryController@store')->name('category-store'); //
    Route::get('/category-edit/{category_id}', 'SubCategoryController@editView')->name('category-edit'); //
    Route::post('/category-save/{category_id}', 'SubCategoryController@categorySave')->name('categorySave'); //
    Route::get('/category-view', 'SubCategoryController@viewCat');
    Route::get('/subcategory', 'lastCategoryController@create')->name('subcategory-add'); //
    Route::post('/subcategory-add', 'lastCategoryController@store')->name('subcategory-store'); //
    Route::get('/subcategory-view', 'lastCategoryController@viewSub');
    Route::post('/deleteSingleMainCategory', 'ProductCategoryController@deleteSingleMainCategory');
    Route::post('/deleteSingleCategory', 'SubCategoryController@deleteSingleCategory');
    Route::post('/deleteSingleSubCategory', 'lastCategoryController@deleteSingleSubCategory');
    Route::get('/showMain', 'ProductCategoryController@showMain');
    Route::get('/showCat', 'SubCategoryController@showCat');
    Route::get('/showSub', 'lastCategoryController@showSub');
    Route::post('/mainUpdate', 'ProductCategoryController@mainUpdate');
    Route::post('/catUpdate', 'SubCategoryController@catUpdate');
    Route::post('/subUpdate', 'lastCategoryController@subUpdate');
    Route::post('/destroyMultipleMainCategories', 'ProductCategoryController@destroyMultipleMainCategories');
    Route::post('/destroyMultipleCategories', 'SubCategoryController@destroyMultipleCategories');
    Route::post('/destroyMultipleSubCategories', 'lastCategoryController@destroyMultipleSubCategories');
    Route::post('/limit', 'ProductCategoryController@limit');
    Route::get('/add-specification', 'SpecificationController@create')->name('add-specification'); //
    Route::post('/add-specification', 'SpecificationController@store')->name('add-specification'); //
    Route::get('/spec-view', 'SpecificationController@viewSpec');
    Route::post('/showSpec', 'SpecificationController@showSpec');
    Route::post('/specUpdate', 'SpecificationController@specUpdate');
    Route::post('/deleteSingleSpec', 'SpecificationController@deleteSingleSpec');
    Route::post('/destroyMultipleSpecs', 'SpecificationController@destroyMultipleSpecs');
    Route::get('/add-spec-option', 'SpecOptionController@addSpecOption')->name('addSpecOption'); //
    Route::post('/add-spec-option', 'SpecOptionController@store')->name('add-SpecOption'); //
    Route::get('/spec-option-view', 'SpecOptionController@viewSpecOption');
    Route::post('/deleteSingleSpecOption', 'SpecOptionController@deleteSingleSpecOption');
    Route::post('/destroyMultipleSpecOption', 'SpecOptionController@destroyMultipleSpecOption');
    Route::get('/showSpecOption', 'SpecOptionController@showSpecOption');
    Route::post('/specOptionUpdate', 'SpecOptionController@specOptionUpdate');
    Route::post('/showSpecList', 'SpecificationController@showSpecList');
    Route::get('/manage-products', 'ManageProductController@view')->name("SuperUserManageProducts");
    Route::get('/feature-products', 'ManageProductController@feature_a_product')->name("product_feature");
    Route::post('/feature-product', 'ManageProductController@featured_product')->name('featured-product');
    Route::post('/takeaction-product', 'ManageProductController@takeaction')->name('approve-product');
    Route::post('/deleteSingleProduct', 'ManageProductController@deleteSingleProduct');
    Route::post('/destroyMultipleproducts', 'ManageProductController@destroyMultipleproducts');
    Route::get('/showProduct', 'ManageProductController@showProduct')->name('showProduct'); //returns a single buying requests before making an offer
    Route::get('/manage-buying-request', 'ManageRequestsController@view');
    Route::post('/takeaction-buying-requests', 'ManageRequestsController@takeActionBuyingRequests')->name('takeActionBuyinggrequest');
    Route::post('/deleteSingleRequest', 'ManageRequestsController@deleteSingleRequest');
    Route::post('/destroyMultiplerequests', 'ManageRequestsController@destroyMultiplerequests');
    Route::get('/showrequest', 'ManageRequestsController@showRequest')->name('showRequest'); //returns a single buying requests before making an offer
    Route::get('/showRequestUser', 'ManageRequestsController@showUser')->name('showUser');
    //selling request
    Route::get('/manage-selling-request', 'ManageRequestsController@SellingRequestsView');
    Route::post('/takeaction-selling-requests', 'ManageRequestsController@takeActionSellingRequests')->name('takeActionSellingrequest');
    Route::post('/deleteSingleSellingRequest', 'ManageRequestsController@deleteSingleSellingRequest');
    Route::post('/destroyMultipleSellingrequests', 'ManageRequestsController@destroyMultipleSellingrequests');
    Route::get('/showSellingRequest', 'ManageRequestsController@showSellingRequest')->name('showSellingrequest');
    Route::get('/showSellingRequestUser', 'ManageRequestsController@showSellingRequestUser')->name('showSellingRequestUser');
    Route::get('/add-banner', 'BannerController@create')->name('addBanner'); //returns a single buying requests before making an offer
    Route::post('/add-banner', 'BannerController@store')->name('storeBanner'); //returns a single buying requests before making an offer
    Route::get('/view-banner', 'BannerController@show')->name('viewBanners'); //
    Route::post('/deleteSingleBanner', 'BannerController@deleteSingleBanner');
    Route::post('/destroyMultipleBanners', 'BannerController@destroyMultipleBanners');
    Route::get('/banner/{banner_id}/edit', 'BannerController@edit')->name('bannerEdit');
    Route::patch('/banner/{banner_id}', 'BannerController@update')->name('bannerUpdate');
    Route::get('/faq-add', 'FaqController@create')->name('faq-add'); //
    Route::post('/faq-add', 'FaqController@store')->name('faq-store'); //
    Route::get('/faq-view', 'FaqController@viewFaq');
    Route::get('/showFaq', 'FaqController@showFaq');
    Route::post('/faqUpdate', 'FaqController@faqUpdate');
    Route::post('/deleteSinglefaq', 'FaqController@deleteSinglefaq');
    Route::post('/destroyMultipleFaq', 'FaqController@destroyMultipleFaq');
    Route::get('/add-faq-content', 'FaqController@addFaqContent')->name('faq-add'); //
    Route::post('/add-faq-content', 'FaqController@storeFaqContent')->name('faq-addContent');
    Route::get('/faq/{faq_name}/edit', 'FaqController@edit')->name('faqContentEdit');
    Route::post('/faq-contentUpdate', 'FaqController@faqContentUpdate')->name('faq-ContentUpdate'); //
    Route::get('/add-country', 'CountryController@create')->name('country-add'); //
    Route::post('/add-country', 'CountryController@store')->name('country-store'); //
    Route::get('/country-view', 'CountryController@viewCountry');
    Route::get('/showcountry', 'CountryController@showCountry');
    Route::get('/showcity', 'CountryController@showCity');
    Route::post('/countryUpdate', 'CountryController@countryUpdate');
    Route::post('/cityUpdate', 'CountryController@cityUpdate');
    Route::post('/deleteSingleCity', 'CountryController@deleteSingleCity');
    Route::post('/destroyMultipleCountries', 'CountryController@destroyMultipleCountries');
    Route::get('/add-city', 'CountryController@addCity')->name('city-add'); //
    Route::post('/add-city', 'CountryController@storeCity')->name('city-store'); //
    Route::get('/add-setting', 'SettingController@create')->name('setting-add'); //
    Route::post('/add-setting', 'SettingController@store')->name('setting-store'); //
    Route::get('/setting-view', 'SettingController@viewSetting');
    Route::post('/destroyMultiplesettings', 'SettingController@destroyMultiplesettings');
    Route::get('/showfield', 'SettingController@showField');
    Route::get('/showvalue', 'SettingController@showValue');
    Route::post('/fieldUpdate', 'SettingController@fieldUpdate');
    Route::post('/valueUpdate', 'SettingController@valueUpdate');
});
