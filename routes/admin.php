<?php date_default_timezone_set('Africa/Cairo');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\JournalsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VersionsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ArticlesEnController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ConferencesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReceivedEmailsController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgetController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\InternationalTypesController;
use App\Http\Controllers\JournalsResearchesController;
use App\Http\Controllers\ConferenceCategoriesController;
use App\Http\Controllers\InternationalCreditsController;
use App\Http\Controllers\InternationalJournalsController;
use App\Http\Controllers\InternationalSpecialtiesController;
use App\Http\Controllers\InternationalPublicationOrdersController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SupportChatController;


Route::middleware(['guest'])->group(function () {
  Route::prefix(adminPrefix())->group(function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'login']);
    Route::get('forget-password', [ForgetController::class, 'forget']);
    Route::get('reset-password/{email_hash}', [ForgetController::class, 'reset']);
    Route::post('send-mail', [ForgetController::class, 'send_mail']);
    Route::post('update-password/{email_hash}', [ForgetController::class, 'update_password']);
  });
});
Route::prefix(adminPrefix())->group(function () {
  Route::middleware(['AdminAuth'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
      Route::get('profile', 'profile');
      Route::get('admins', 'all_admin');
      Route::get('create/admin', 'create');
      Route::get('edit/admin/{id}', 'edit')->where('id', '[0-9]+');
      Route::post('store/admin', 'store')->name("addNewAdmin");
      Route::post('update/admin/{id}', 'update')->where('id', '[0-9]+');
      Route::get('delete/admin/{id}', 'delete')->where('id', '[0-9]+');
      Route::post('update/profile', 'update_profile');
    });
    Route::get('notification', function () {
      return view('admin.notifications');
    });
    Route::get('home', [HomeController::class, 'index']);
    Route::get('logout', [LogoutController::class, 'logout']);
    Route::prefix('payments')->group(function () {
      Route::controller(PaymentsController::class)->group(function () {
        Route::get('', 'index');
      });
    });
    Route::prefix('invoices')->group(function () {
      Route::controller(InvoicesController::class)->group(function () {
        Route::get('', 'index');
        Route::get('journals', 'indexJournals');
        Route::get('create', 'create');
        Route::get('create-journals', 'createJournals');
        Route::get('edit/{id}', 'edit');
        Route::get('edit-journal/{id}', 'editJournal');
        Route::post('store', 'store');
        Route::post('store-journal', 'storeJournal')->name('admin.storeJournal');
        Route::post('update', 'update');
        Route::post('updateJournal', 'updateJournal');
        Route::post('active', 'active');
        Route::post('item/destory', 'item_destory');
        Route::delete('destroy', 'destroy');
        Route::post('item/journal_item_destory', 'journal_item_destory');

        Route::get('mark_as_paid/{id}', 'mark_as_paid');
        Route::post('send_reminder)', 'send_reminder')->name('send_reminder');
      });
    });
    Route::controller(ArticlesController::class)->group(function () {
      Route::get('articles', 'index');
      Route::get('article/create', 'create');
      Route::get('article/edit/{id}', 'edit')->where('id', '[0-9]+');
      Route::post('article/status', 'status');
      Route::post('article/store', 'store');
      Route::post('article/update', 'update');
      Route::delete('article/destroy', 'destroy');
    });
    Route::prefix('en')->group(function () {
      Route::controller(ArticlesEnController::class)->group(function () {
        Route::get('articles', 'index');
        Route::get('article/create', 'create');
        Route::get('article/edit/{id}', 'edit')->where('id', '[0-9]+');
        Route::post('article/status', 'status');
        Route::post('article/store', 'store');
        Route::post('article/update', 'update');
        Route::delete('article/destroy', 'destroy');
      });
    });
    Route::prefix('conference')->group(function () {
      Route::controller(ConferenceCategoriesController::class)->group(function () {
        Route::get('categories', 'index');
        Route::post('category/store', 'store');
        Route::post('category/update', 'update');
        Route::post('category/destroy', 'destroy');
        Route::delete('destroy', 'conference_destroy');
      });
      Route::controller(ConferencesController::class)->group(function () {
        Route::get('all', 'index');
        Route::get('show/{id}', 'show');
        Route::post('send/certificate', 'send_certificate');
      });
    });
    Route::prefix('users')->group(function () {
      Route::controller(UsersController::class)->group(function () {
        Route::get('user-researches/create', 'admin_create_research')->name('admin_create_research');
        Route::post('admin-user-researches/store', 'admin_store_research')->name('admin_store_research');
        Route::get('', 'index');
        Route::get('subscribers/restore', 'RestoreSubscribers')->name('subscriber.restore');

        // Subscribers
        Route::get('subscribers', 'subscribers');
        Route::post('subscribers', 'AddSubscribers')->name('add.subscribers');
        Route::get('subscribers/email', 'emailSubscriberForm');
        Route::post('send/subscribers/email', 'SendMail')->name('subscribers.send.email');
        Route::get('subscribers/ajax', 'Ajaxsubscribers')->name("subscribers");
        Route::get('subscribers/remove/{email}', 'RemoveSubscribers');
        Route::post('subscriber/edit', 'EditSubscriber')->name('subscriber.edit');
        Route::post('subscriber/destroy', 'destroySubscriber')->name('subscriber.destroy');

        Route::get('show/{id}', 'show');
        Route::get('admin_verifies_user/{id}', 'admin_verifies_user');
        Route::post('status', 'update_status');
        Route::delete('delete', 'destroy');
        Route::get('researches', 'researches');
        Route::post('send_link_facture/', 'send_facture')->name('send_facture');
        Route::post('refuse/international_publication_orders', 'RefusedInternationalPublicationOrders')->name('ChangeInternationalPublicationOrders');
        Route::post('accept/international_publication_orders', 'AcceptInternationalPublicationOrders')->name('AcceptInternationalPublicationOrders');

        // baik
        Route::get('user-researches', 'user_researches')->name('admin_user_researches');
        Route::get('user-researches/{id}', 'user_researches_cat');
        Route::get('user-researches/{id}/details', 'user_researche_details')->name('research_details');
        Route::get('user-researches/{id}/edit', 'admin_edit_research')->name('admin_edit_research');
        Route::post('user-researches/{id}/update', 'admin_update_research')->name('admin_update_research');
        Route::delete('user-researches/destroy', 'user_researches_destroy');
        Route::get('user-researches/edit/{value}/{id}', 'edit_researches');
        Route::post('chat/store', 'chat_store');
        Route::get('chat/{id}', 'chat');
        //baik
        Route::delete('researches/destroy', 'researches_destroy');
        Route::get('support/chat/{message_id}', 'ViewSupportChat')->name('ViewSupportChat');
        Route::post('adminSendMessage', [SupportChatController::class, 'adminSendMessage'])->name('adminSendMessage');
        Route::get('supportchat', [SupportChatController::class, 'SupportChat'])->name('supportchat');
        Route::get('OpenChat/{email}', [SupportChatController::class, 'OpenChat'])->name('OpenChat');

      });
    });
    Route::controller(DocumentController::class)->prefix('documents')->group(
      function () {
        Route::get('', 'index')->name('admin.documents');
        Route::post('store', 'store')->name('admin.store_documents');
        Route::post('delete_document', 'destroy')->name('admin.delete_document');
        Route::post('update_document', 'update')->name('admin.update_document');
        Route::post('get_user_researches', 'get_user_researches')->name('admin.get_user_researches');
        Route::post('get_documents', 'get_documents')->name('admin.get_documents');
      }
    );
    Route::prefix('journals')->group(function () {
      Route::controller(JournalsController::class)->group(function () {
        Route::get('', 'index');
        Route::get('create', 'create');
        Route::get('edit/{id}', 'edit');
        Route::post('store', 'store');
        Route::post('update', 'update');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('researches')->group(function () {
      Route::controller(JournalsResearchesController::class)->group(function () {
        Route::get('', 'index');
        Route::get('create', 'create');
        Route::get('edit/{id}', 'edit');
        Route::post('store', 'store');
        Route::post('update', 'update');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('versions')->group(function () {
      Route::controller(VersionsController::class)->group(function () {
        Route::get('', 'index');
        Route::get('create', 'create');
        Route::get('edit/{id}', 'edit');
        Route::post('store', 'store');
        Route::post('update', 'update');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('services')->group(function () {
      Route::controller(ServicesController::class)->group(function () {
        Route::get('', 'index');
        Route::get('create', 'create');
        Route::get('edit/{id}', 'edit');
        Route::post('store', 'store');
        Route::post('update', 'update');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('team')->group(function () {
      Route::controller(TeamController::class)->group(function () {
        Route::get('', 'index');
        Route::get('create', 'create');
        Route::get('edit/{id}', 'edit');
        Route::post('store', 'store');
        Route::post('update', 'update');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('international')->group(function () {
      Route::controller(InternationalCreditsController::class)->group(function () {
        Route::get('', 'index');
        Route::post('store', 'store');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('faqs')->group(function () {
      Route::controller(FaqController::class)->group(function () {
        Route::get('', 'index');
        Route::get('create', 'create');
        Route::get('edit/{id}', 'edit');
        Route::post('store', 'store');
        Route::post('update', 'update');
        Route::delete('destroy', 'destroy');
      });
    });
    Route::prefix('international-publishing')->group(function () {
      Route::controller(InternationalTypesController::class)->group(function () {
        Route::get('types-of-publication', 'index');
        Route::prefix('types')->group(function () {
          Route::post('store', 'store');
          Route::delete('destroy', 'destroy');
          Route::post('update', 'update');
        });
      });
      Route::controller(InternationalSpecialtiesController::class)->group(function () {
        Route::prefix('specialties')->group(function () {
          Route::get('', 'index');
          Route::post('store', 'store');
          Route::delete('destroy', 'destroy');
          Route::post('update', 'update');
        });
      });
      Route::controller(InternationalJournalsController::class)->group(function () {
        Route::prefix('journals')->group(function () {
          Route::get('', 'index');
          Route::post('store', 'store');
          Route::delete('destroy', 'destroy');
          Route::post('update', 'update');
        });
      });
      Route::controller(InternationalPublicationOrdersController::class)->group(function () {
        Route::delete('destroy', 'admin_destroy');
        Route::prefix('orders')->group(function () {
          Route::get('', 'orders');
          Route::get('show/{id}', 'show');
        });
      });
    });
    Route::prefix('settings')->group(function () {
      Route::controller(SettingsController::class)->group(function () {
        Route::get('', 'index');
        Route::post('social/create', 'social_store');
        Route::post('social/update', 'social_update');
        Route::post('mail/create', 'mail_store');
        Route::post('mail/update', 'mail_update');
        Route::post('phone/create', 'phone_store');
        Route::post('phone/update', 'phone_update');
        Route::post('alert_in_chat/update', 'alert_in_chat_update');
        Route::post('front_sections/update', 'front_sections_update');
        Route::post('study_submition_sections/update', 'study_submition_sections_update');
        Route::post('journals_statuses/update', 'updateJournalsStatus');
        Route::get('email_confirmation_alerts', 'email_confirmation_alerts_page');
        Route::post('email_confirmation_alerts', 'email_confirmation_alerts');

      });
      Route::controller(ReceivedEmailsController::class)->group(function () {
        Route::post('emails/create', 'store');
        Route::delete('emails/destroy', 'destroy');
      });
    });
  });
});
Route::get('hosam', function () {
  return view('admin.SubscriberMail');
});