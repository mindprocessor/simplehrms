<?php

declare(strict_types = 1);

date_default_timezone_set('Asia/Manila');

session_start();

include 'app/vendor/autoload.php';
include 'app/lib/helper.php'; //helper file - list of utility function

//define
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');

//instance f3
$f3 = \Base::instance();

//config
$f3->set('AUTOLOAD', 'app/controllers/; app/controllers/Api/');
$f3->set('DEBUG', 10);
$f3->set('UI', 'app/views/');

//routes
//portal routes
$f3->route('GET /', 'Portal->index');
$f3->route('GET /portal/profile', 'Portal->profile');
$f3->route('GET /portal/leave', 'Portal->leave');
$f3->route('GET /portal/leave-plot', 'Portal->leavePlot');
$f3->route('GET /portal/leave-cancel/@leave_id', 'Portal->leaveCancel');
$f3->route('GET /portal/timesheet', 'Portal->timesheet');
$f3->route('GET /portal/timelog/@val', 'Portal->timelog');
$f3->route('GET /portal/break/@mode/@val', 'Portal->break');

//auth
$f3->route('GET|POST /login', 'Authenticate->login');
$f3->route('GET /logout', 'Authenticate->logout');

//API
$f3->route('POST /api/leave/plot [ajax]', 'Api->leavePlot');
$f3->route('GET|POST /api/timesheets [ajax]', 'Api->timesheets');
$f3->route('GET|POST /api/breaks/@timesheet_id [ajax]', 'Api->breaks');
$f3->route('GET|POST /api/payroll/entry/generate/@id [ajax]', 'Api->payrollEntryGenerate');

$f3->route('POST /api/employee/add', 'Api\Employee->add');
$f3->route('POST /api/employee/update', 'Api\Employee->update');
$f3->route('GET /api/employee/get/@id', 'Api\Employee->get');
$f3->route('GET /api/employee/getall', 'Api\Employee->getAll');

//admin
$f3->route('GET /admin', 'Admin->home');
$f3->route('GET /admin/home', 'Admin->home');
$f3->route('GET /admin/employee', 'Admin->employee');
$f3->route('GET /admin/employee/view/@id', 'Admin->employeeView');
$f3->route('GET|POST /admin/employee/add', 'Admin->employeeAdd');
$f3->route('GET|POST /admin/employee/editprofile/@id', 'Admin->employeeEditProfile');
$f3->route('GET|POST /admin/employee/editgovernment/@id', 'Admin->employeeEditGovernment');
$f3->route('GET|POST /admin/employee/editemployment/@id', 'Admin->employeeEditEmployment');
$f3->route('GET|POST /admin/employee/editcontactinfo/@id', 'Admin->employeeEditContactInfo');
$f3->route('GET|POST /admin/employee/editlogin/@id', 'Admin->employeeEditLogin');
$f3->route('GET /admin/leave', 'Admin->leave');
$f3->route('GET /admin/leave/view/@id', 'Admin->leaveView');
$f3->route('GET|POST /admin/leave/approve/@id/@confirm', 'Admin->leaveApprove');
$f3->route('GET /admin/livestat', 'Admin->livestat');

//payroll
$f3->route('GET /payroll', 'Payroll->entry');
$f3->route('GET|POST /payroll/entry/add', 'Payroll->entryAdd');
$f3->route('GET|POST /payroll/entry/view/@id', 'Payroll->entryView');

//component
$f3->route('GET /component/livestat [ajax]', 'Component->livestat');
$f3->route('GET /component/payroll/entry/generated/@id [ajax]', 'Component->payrollEntryGenerated');

$f3->route('GET /sample', 'Sample->index');


//invoke
$f3->run();
