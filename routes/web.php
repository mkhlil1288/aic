<?php
use Illuminate\Support\Facades\Auth;

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

	//Auth Route
	Route::get('/login', function () {
		return redirect('login');
	});

	Auth::routes();	
	
	//Frontend Route
	Route::get('/', 'App\Http\Controllers\WebsiteController@index');
	Route::get('/post/{slug?}', 'App\Http\Controllers\WebsiteController@single');
	Route::get('/category/{id?}', 'App\Http\Controllers\WebsiteController@category_archive');
	Route::get('/notice/{id?}', 'App\Http\Controllers\WebsiteController@notice');
	Route::get('/event/{id?}', 'App\Http\Controllers\WebsiteController@event');
	Route::post('/contact/send_message', 'App\Http\Controllers\WebsiteController@send_message');
	Route::get('/site/{slug?}', 'App\Http\Controllers\WebsiteController@index');

	
	Route::group(['middleware' => ['auth']], function () {
		/** Common Route for All **/
		Route::get('dashboard','App\Http\Controllers\DashboardController@index')->name('dashboard');	
		
		//Profile Controller
		Route::get('profile/my_profile', 'App\Http\Controllers\ProfileController@my_profile');
		Route::get('profile/edit', 'App\Http\Controllers\ProfileController@edit');
		Route::post('profile/update', 'App\Http\Controllers\ProfileController@update');
		Route::get('profile/changepassword', 'App\Http\Controllers\ProfileController@change_password');
		Route::post('profile/updatepassword', 'App\Http\Controllers\ProfileController@update_password');
			
		
		/** Permission Route Group **/
		Route::group(['middleware' => ['permission']], function () {
		
			//User Controller
			Route::get('users/get_users/{user_type}', 'App\Http\Controllers\UserController@get_users');
			Route::resource('users','App\Http\Controllers\UserController');

			Route::resource('teachers','App\Http\Controllers\TeacherController');
			
			//Parents Route
			Route::get('parents/get_parents','App\Http\Controllers\ParentController@get_parents');
			Route::resource('parents','App\Http\Controllers\ParentController');
			
			//Student Route
			Route::get('students/id_card/{student_id}', 'App\Http\Controllers\StudentController@id_card')->name('students.view_id_card');
			Route::get('students/class/{class_id?}', 'App\Http\Controllers\StudentController@class')->name('students.index');
			Route::get('students/get_subjects/{class_id}', 'App\Http\Controllers\StudentController@get_subjects');
			Route::get('students/get_students/{class_id}/{section_id}', 'App\Http\Controllers\StudentController@get_students');
			Route::match(['get','post'],'students/promote/{step?}','App\Http\Controllers\StudentController@promote')->name('students.promote');
			Route::resource('students','App\Http\Controllers\StudentController');
			
			//Class Controller
			Route::resource('class','App\Http\Controllers\ClassController');
			
			//Section Route
			Route::post('sections/section', 'App\Http\Controllers\SectionController@get_section');
			Route::get('sections/class/{class_id}', 'App\Http\Controllers\SectionController@index')->name('sections.index');
			Route::resource('sections','App\Http\Controllers\SectionController');
			
			//Subject Route
			Route::get('subjects/class/{class_id}', 'App\Http\Controllers\SubjectController@index')->name('subjects.index');
			Route::post('subjects/subject', 'App\Http\Controllers\SubjectController@get_subject');
			Route::resource('subjects','App\Http\Controllers\SubjectController');
			
			//Assign Subject Route
			Route::post('assignsubjects/search', 'App\Http\Controllers\AssignSubjectController@search')->name('assignsubjects.index');
			Route::resource('assignsubjects','App\Http\Controllers\AssignSubjectController');
			
			Route::resource('syllabus','App\Http\Controllers\SyllabusController');
			Route::resource('assignments','App\Http\Controllers\AssignmentController');
			Route::resource('academic_years','App\Http\Controllers\AcademicYearController');	
			Route::resource('student_groups','App\Http\Controllers\StudentGroupController');
			
			//Class Routine
			Route::get('class_routines', 'App\Http\Controllers\ClassRoutineController@index')->name('class_routines.index');
			Route::get('class_routines/class/{class_id}', 'App\Http\Controllers\ClassRoutineController@class')->name('class_routines.index');
			Route::get('class_routines/manage/{class_id}/{section_id}', 'App\Http\Controllers\ClassRoutineController@manage')->name('class_routines.edit');
			Route::post('class_routines/store', 'App\Http\Controllers\ClassRoutineController@store')->name('class_routines.create');
			Route::get('class_routines/show/{class_id}/{section_id}', 'App\Http\Controllers\ClassRoutineController@show')->name('class_routines.index');
			
			//Attendance Controller
			Route::match(['get','post'],'student/attendance','App\Http\Controllers\AttendanceController@student_attendance')->name('student_attendance.create');
			Route::post('student/attendance/save', 'App\Http\Controllers\AttendanceController@student_attendance_save')->name('student_attendance.create');
			Route::match(['get','post'],'staff/attendance','App\Http\Controllers\AttendanceController@staff_attendance')->name('staff_attendance.create');
			Route::post('staff/attendance/save', 'App\Http\Controllers\AttendanceController@staff_attendance_save')->name('staff_attendance.create');
			
			//Utility Controller
			Route::match(['get', 'post'],'administration/general_settings/{store?}', 'App\Http\Controllers\UtilityController@settings')->name('general_settings.update');
			Route::post('administration/theme_option/{store?}', 'App\Http\Controllers\UtilityController@update_theme_option')->name('theme_option.update');
			Route::get('administration/change_session/{session_id}', 'App\Http\Controllers\UtilityController@change_session')->name('general_settings.update');
			Route::post('administration/upload_logo', 'App\Http\Controllers\UtilityController@upload_logo')->name('general_settings.update');
			Route::get('administration/backup_database', 'App\Http\Controllers\UtilityController@backup_database')->name('utility.backup_database');

			//Language Controller
			Route::resource('languages','App\Http\Controllers\LanguageController');
			
			//PickList Controller
			Route::get('picklists/type/{type}', 'App\Http\Controllers\PicklistController@type')->name('picklists.index');
			Route::resource('picklists','App\Http\Controllers\PicklistController');

			//Library Controller
			Route::get('librarymembers/librarycard/{id}', 'App\Http\Controllers\LibraryMemberController@library_card')->name('librarymembers.view_library_card');
			Route::post('librarymembers/section', 'App\Http\Controllers\LibraryMemberController@get_section');
			Route::post('librarymembers/student', 'App\Http\Controllers\LibraryMemberController@get_student');
			Route::resource('librarymembers','App\Http\Controllers\LibraryMemberController');

			//Book Controller
			Route::resource('books','App\Http\Controllers\BookController');

			//Book Issue  Controller
			Route::match(['get','post'],'bookissues/list/{library_id?}','App\Http\Controllers\BookIssueController@index')->name('bookissues.index');
			Route::get('bookissues/return/{id}', 'App\Http\Controllers\BookIssueController@book_return')->name('bookissues.return');
			Route::resource('bookissues','App\Http\Controllers\BookIssueController');

			//BookCategory Controller
			Route::resource('bookcategories','App\Http\Controllers\BookCategoryController');

			//Transport Controller
			Route::resource('transportvehicles','App\Http\Controllers\TransportVehicleController');

			//Transport Controller
			Route::resource('transports','App\Http\Controllers\TransportController');

			//Transport Member Controller
			Route::post('transportmembers/section', 'App\Http\Controllers\TransportMemberController@get_section');
			Route::post('transportmembers/student', 'App\Http\Controllers\TransportMemberController@get_student');
			Route::post('transportmembers/transport_fee', 'App\Http\Controllers\TransportMemberController@get_transport_fee');
			Route::get('transportmembers/list/{type?}/{class?}', 'App\Http\Controllers\TransportMemberController@index')->name('transportmembers.index');
			Route::resource('transportmembers','App\Http\Controllers\TransportMemberController');

			//Hostel Controller
			Route::resource('hostels','App\Http\Controllers\HostelController');

			//Hostel Category Controller
			Route::resource('hostelcategories','App\Http\Controllers\HostelCategoryController');

			//Hostel Member Controller
			Route::get('hostelmembers/class/{class_id}', 'App\Http\Controllers\HostelMemberController@index')->name('hostelmembers.index');
			Route::get('hostelmembers/create/{id?}', 'App\Http\Controllers\HostelMemberController@create')->name('hostelmembers.create');
			Route::post('hostelmembers/standard', 'App\Http\Controllers\HostelMemberController@get_standard');
			Route::post('hostelmembers/hostel_fee', 'App\Http\Controllers\HostelMemberController@get_hostel_fee');
			Route::resource('hostelmembers','App\Http\Controllers\HostelMemberController');
			
			// Exam Controller
			Route::match(['get', 'post'],'exams/schedule/{type?}', 'App\Http\Controllers\ExamController@exam_schedule')->name('exams.view_schedule');
			Route::match(['get', 'post'],'exams/attendance', 'App\Http\Controllers\ExamController@exam_attendance')->name('exams.store_exam_attendance');
			Route::post('exams/store_exam_attendance', 'App\Http\Controllers\ExamController@store_exam_attendance')->name('exams.store_exam_attendance');
			Route::post('exams/store_schedule', 'App\Http\Controllers\ExamController@store_exam_schedule')->name('exams.store_exam_schedule');
			Route::post('exams/get_exam', 'App\Http\Controllers\ExamController@get_exam');
			Route::post('exams/get_subject', 'App\Http\Controllers\ExamController@get_subject');
			Route::post('exams/get_teacher_subject', 'App\Http\Controllers\ExamController@get_teacher_subject');
			Route::resource('exams','App\Http\Controllers\ExamController');
			
			
			//Grade Controller
			Route::resource('grades','App\Http\Controllers\GradeController');
			
			//Mark Distribution Controller
			Route::resource('mark_distributions','App\Http\Controllers\MarkDistributionController');
			
			//Mark Register
			Route::match(['get', 'post'],'marks/rank/{class?}', 'App\Http\Controllers\MarkController@student_ranks')->name('marks.view_student_rank');	
			Route::match(['get', 'post'],'marks/create', 'App\Http\Controllers\MarkController@create')->name('marks.create');
			Route::post('marks/store','App\Http\Controllers\MarkController@store')->name('marks.store');
			Route::match(['get', 'post'],'marks/{class?}', 'App\Http\Controllers\MarkController@index')->name('marks.index');
			Route::get('marks/view/{student_id}/{class_id}', 'App\Http\Controllers\MarkController@view_marks')->name('marks.show');	
			
			//Bank & Cash Account Controller
			Route::resource('accounts','App\Http\Controllers\AccountController');
			
			//Chart Of Accounts Controller
			Route::resource('chart_of_accounts','App\Http\Controllers\ChartOfAccountController');
			
			//Payment Method Controller
			Route::resource('payment_methods','App\Http\Controllers\PaymentMethodController');
			
			//Payee/Payer Controller
			Route::resource('payee_payers','App\Http\Controllers\PayeePayerController');
			
			//Transaction Controller
			Route::get('transactions/income', 'App\Http\Controllers\TransactionController@income')->name('transactions.manage_income');
			Route::get('transactions/expense', 'App\Http\Controllers\TransactionController@expense')->name('transactions.manage_expense');
			Route::get('transactions/add_income', 'App\Http\Controllers\TransactionController@add_income')->name('transactions.add_income');
			Route::get('transactions/add_expense', 'App\Http\Controllers\TransactionController@add_expense')->name('transactions.add_expense');
			Route::resource('transactions','App\Http\Controllers\TransactionController');
			
			//Fee Type
			Route::resource('fee_types','App\Http\Controllers\FeeTypeController');
			
			//Invoice
			Route::get('invoices/class/{class_id}', 'App\Http\Controllers\InvoiceController@index')->name('invoices.index');
			Route::resource('invoices','App\Http\Controllers\InvoiceController');
			
			//Student Payments
			Route::get('student_payments/create/{invoice_id?}', 'App\Http\Controllers\StudentPaymentController@create')->name('student_payments.create');
			Route::get('student_payments/class/{class_id}', 'App\Http\Controllers\StudentPaymentController@index')->name('student_payments.index');
			Route::resource('student_payments','App\Http\Controllers\StudentPaymentController');
			
			//Message Controller
			Route::get('message/compose', 'App\Http\Controllers\MessageController@create');
			Route::get('message/outbox', 'App\Http\Controllers\MessageController@send_items');
			Route::get('message/inbox', 'App\Http\Controllers\MessageController@inbox_items');
			Route::get('message/outbox/{id}', 'App\Http\Controllers\MessageController@show_outbox');
			Route::get('message/inbox/{id}', 'App\Http\Controllers\MessageController@show_inbox');
			Route::post('message/send', 'App\Http\Controllers\MessageController@send');
			
			//SMS Controller
			Route::get('sms/compose', 'App\Http\Controllers\SmsController@create')->name('sms.compose');
			Route::get('sms/logs', 'App\Http\Controllers\SmsController@logs')->name('sms.view_logs');
			Route::post('sms/send', 'App\Http\Controllers\SmsController@send')->name('sms.compose');
			
			//Email Controller
			Route::get('email/compose', 'App\Http\Controllers\EmailController@create')->name('email.compose');
			Route::get('email/logs', 'App\Http\Controllers\EmailController@logs')->name('email.view_logs');
			Route::post('email/send', 'App\Http\Controllers\EmailController@send')->name('email.compose');
			
			//Notice Controller
			Route::get('notices/{id}','App\Http\Controllers\NoticeController@show')->where('id', 'App\Http\Controllers\[0-9]+');
			Route::resource('notices','App\Http\Controllers\NoticeController');
			
			//Event Controller
			Route::get('events/{id}','App\Http\Controllers\EventController@show')->where('id', 'App\Http\Controllers\[0-9]+');
			Route::resource('events','App\Http\Controllers\EventController');
			
			//Report Controller
			Route::match(['get', 'post'],'reports/student_attendance_report/{view?}', 'App\Http\Controllers\ReportController@student_attendance_report')->name('reports.student_attendance_report');
			Route::match(['get', 'post'],'reports/staff_attendance_report/{view?}', 'App\Http\Controllers\ReportController@staff_attendance_report')->name('reports.staff_attendance_report');
			Route::match(['get', 'post'],'reports/student_id_card/{view?}', 'App\Http\Controllers\ReportController@student_id_card')->name('reports.student_id_card');
			Route::match(['get', 'post'],'reports/exam_report/{view?}', 'App\Http\Controllers\ReportController@exam_report')->name('reports.exam_report');
			Route::match(['get', 'post'],'reports/progress_card/{view?}', 'App\Http\Controllers\ReportController@progress_card')->name('reports.progress_card');
			Route::match(['get', 'post'],'reports/class_routine/{view?}', 'App\Http\Controllers\ReportController@class_routine')->name('reports.class_routine');
			Route::match(['get', 'post'],'reports/exam_routine/{view?}', 'App\Http\Controllers\ReportController@exam_routine')->name('reports.exam_routine');
			Route::match(['get', 'post'],'reports/income_report/{view?}', 'App\Http\Controllers\ReportController@income_report')->name('reports.income_report');
			Route::match(['get', 'post'],'reports/expense_report/{view?}', 'App\Http\Controllers\ReportController@expense_report')->name('reports.expense_report');
			Route::get('reports/account_balance', 'App\Http\Controllers\ReportController@account_balance')->name('reports.account_balance');
			
			//Permission Controller
			Route::get('permission/control/{role_id?}', 'App\Http\Controllers\PermissionController@index')->name('permission.manage');
			Route::post('permission/store', 'App\Http\Controllers\PermissionController@store')->name('permission.manage');

			
			//Role Controller
			Route::resource('permission_roles','App\Http\Controllers\RoleController');
			
			//CMS Controller
			Route::get('posts/type/{type?}','App\Http\Controllers\PostController@index')->name("posts.custom_post_list");
			Route::resource('posts','App\Http\Controllers\PostController');
			
			
			//Page Controller
			Route::resource('pages','App\Http\Controllers\PageController');
			
			//Post Categrory
			Route::get('post_categories/get_category','App\Http\Controllers\PostCategoryController@get_category');
			Route::resource('post_categories','App\Http\Controllers\PostCategoryController');
			
			//Route::get('website_languages/translate/{language_id?}','App\Http\Controllers\WebsiteLanguageController@translate')->name("website_languages.translate");
			//Route::post('website_languages/store_translate','App\Http\Controllers\WebsiteLanguageController@store_translate')->name("website_languages.translate");
			//Route::resource('website_languages','App\Http\Controllers\WebsiteLanguageController');
			
			//Site Navigation
			Route::resource('site_navigations','App\Http\Controllers\SiteNavigationController');
			Route::get('site_navigation_items/navigation/{navigation_id?}','App\Http\Controllers\NavigationItemController@index')->name("site_navigation_items.index");
			Route::get('site_navigation_items/create/{navigation_id?}','App\Http\Controllers\NavigationItemController@create')->name("site_navigation_items.create");
			Route::resource('site_navigation_items','App\Http\Controllers\NavigationItemController');
			
			Route::match(['get', 'post'],'website/menu_sorting', 'App\Http\Controllers\FrontendSettingController@menu_sorting')->name('website.menu_sorting');
			Route::match(['get', 'post'],'website/theme_option', 'App\Http\Controllers\FrontendSettingController@theme_option')->name('website.theme_option');
		
		});
		
		
		/** Teacher Route Group **/
		Route::group(['middleware' => ['teacher']], function () {
			Route::get('teacher/my_profile', 'App\Http\Controllers\Users\TeacherController@my_profile');
			Route::get('teacher/class_schedule', 'App\Http\Controllers\Users\TeacherController@class_schedule');
			Route::get('teacher/mark_register', 'App\Http\Controllers\Users\TeacherController@mark_register');
			Route::post('teacher/marks/create', 'App\Http\Controllers\Users\TeacherController@create_mark');
			Route::post('teacher/marks/store', 'App\Http\Controllers\Users\TeacherController@store_mark');
			Route::get('teacher/assignments', 'App\Http\Controllers\Users\TeacherController@assignments');
			Route::get('teacher/create_assignment', 'App\Http\Controllers\Users\TeacherController@create_assignment');
			Route::post('teacher/store_assignment', 'App\Http\Controllers\Users\TeacherController@store_assignment');
			Route::get('teacher/edit_assignment/{id}', 'App\Http\Controllers\Users\TeacherController@edit_assignment');
			Route::get('teacher/assignment/{id}', 'App\Http\Controllers\Users\TeacherController@show_assignment');
			Route::post('teacher/update_assignment/{id}', 'App\Http\Controllers\Users\TeacherController@update_assignment');
			Route::get('teacher/destroy_assignment/{id}', 'App\Http\Controllers\Users\TeacherController@destroy_assignment');
		});	
		
		
		/** Student Route Group **/
		Route::group(['middleware' => ['student']], function () {
			Route::get('student/my_profile', 'App\Http\Controllers\Users\StudentController@my_profile');
			Route::get('student/my_subjects', 'App\Http\Controllers\Users\StudentController@my_subjects');
			Route::get('student/class_routine', 'App\Http\Controllers\Users\StudentController@class_routine');
			Route::match(['get', 'post'],'student/exam_routine/{view?}', 'App\Http\Controllers\Users\StudentController@exam_routine');
			Route::get('student/progress_card', 'App\Http\Controllers\Users\StudentController@progress_card');
			Route::get('student/my_invoice/{status?}', 'App\Http\Controllers\Users\StudentController@my_invoice');
			Route::get('student/view_invoice/{id?}', 'App\Http\Controllers\Users\StudentController@view_invoice');
			Route::get('student/invoice_payment/{method?}/{invoice_id?}', 'App\Http\Controllers\Users\StudentController@invoice_payment');
			Route::get('student/paypal/{action?}/{invoice_id?}', 'App\Http\Controllers\Users\StudentController@paypal');
			Route::post('student/stripe_payment/{invoice_id?}', 'App\Http\Controllers\Users\StudentController@stripe_payment');
			Route::get('student/payment_history', 'App\Http\Controllers\Users\StudentController@payment_history');
			Route::get('student/library_history', 'App\Http\Controllers\Users\StudentController@library_history');
			Route::get('student/my_assignment', 'App\Http\Controllers\Users\StudentController@my_assignment');
			Route::get('student/view_assignment/{id?}', 'App\Http\Controllers\Users\StudentController@view_assignment');
			Route::get('student/my_syllabus', 'App\Http\Controllers\Users\StudentController@my_syllabus');
			Route::get('student/view_syllabus/{id?}', 'App\Http\Controllers\Users\StudentController@view_syllabus');
		});
		
		
		/** Parent Route Group **/
		Route::group(['middleware' => ['parent']], function () {
			Route::get('parent/my_profile', 'App\Http\Controllers\Users\ParentController@my_profile');
			Route::get('parent/my_children/{student_id?}', 'App\Http\Controllers\Users\ParentController@my_children');
			Route::match(['get', 'post'],'parent/children_attendance/{student_id?}', 'App\Http\Controllers\Users\ParentController@children_attendance');
			Route::get('parent/progress_card/{student_id?}', 'App\Http\Controllers\Users\ParentController@progress_card');
		});
				
	});

Route::get('/installation', 'App\Http\Controllers\Install\InstallController@index');
Route::get('install/database', 'App\Http\Controllers\Install\InstallController@database');
Route::post('install/process_install', 'App\Http\Controllers\Install\InstallController@process_install');
Route::get('install/create_user', 'App\Http\Controllers\Install\InstallController@create_user');
Route::post('install/store_user', 'App\Http\Controllers\Install\InstallController@store_user');
Route::get('install/system_settings', 'App\Http\Controllers\Install\InstallController@system_settings');
Route::post('install/finish', 'App\Http\Controllers\Install\InstallController@final_touch');

Route::post('student/paypal_ipn','App\Http\Controllers\GatewayController@paypal_ipn');	

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
