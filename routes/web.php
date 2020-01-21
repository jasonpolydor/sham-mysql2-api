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

Route::get('/', 'MiscController@welcome');
Route::get('test', 'MiscController@test');
Route::get('vue-test', 'MiscController@vueTest');
Route::get('testleave', 'MiscController@testleave');
Route::get('testunclaimedmonthly', 'MiscController@testunclaimedmonthly');

Route::any('/broadcasting/auth', '\Illuminate\Broadcasting\BroadcastController@authenticate');
Auth::routes();



Route::group(['prefix' => '/survey', 'namespace' => 'Open'], function() {
    Route::get('/{post_id?}','SurveysController@show')
            ->name('survey.show');
    Route::post('/{post_id?}','SurveysController@store')
            ->name('survey.save');
});

Route::group(['prefix' => '/vacancies', 'namespace' => 'Open'], function() {
    Route::get('/', 'RecruitmentsController@publicHome')->name('candidate.vacancies');
    Route::get('status/{recruitment_id}','RecruitmentsController@showCandidateStatus')
            ->middleware(['auth:candidate'])
            ->name('vacancies.status');
    Route::any('apply/{recruitment_id}','RecruitmentsController@apply')
            ->name('vacancies.apply');
    Route::post('save', 'RecruitmentsController@applyInterview')->name('vacancies.save');
});

Route::group(['prefix' => '/candidate'], function () {
    //Route::get('/', 'Open\RecruitmentsController@publicHome')->name('candidate.dashboard');
    //Route::get('dashboard', 'Open\RecruitmentsController@publicHome')->name('candidate.dashboard');
    Route::get('register', 'Open\CandidateController@create')->name('candidate.register');
    Route::post('register', 'Open\CandidateController@store')->name('candidate.register.store');
    Route::get('login', 'Auth\CandidateLoginController@login')->name('candidate.auth.login');
    Route::post('login', 'Auth\CandidateLoginController@loginCandidate')->name('candidate.auth.loginCandidate');
    Route::get('details', 'Open\CandidateController@details')->name('candidate.auth.details');
    Route::match(['put', 'patch'],'update/{id}', 'Open\CandidateController@update')->name('candidate.auth.update');
    // logout using get
    Route::get('logout', 'Auth\CandidateLoginController@logout')->name('candidate.auth.logout');
    Route::post('logout', 'Auth\CandidateLoginController@logout')->name('candidate.auth.logout');


});

#region auth middleware routes
    Route::group(['middleware' => ['auth:sham']], function() {
        Route::get('get-notifications', 'GeneralNotificationsController@getWidjetNotifications');
        Route::get('read-notification/{id}', 'GeneralNotificationsController@readNotifiaction');
        Route::get('my-notifications', 'GeneralNotificationsController@notificationList');
        // logout using get
        Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');
        Route::post('auth/logout', 'Auth\LoginController@logout')->name('logout');

        #region Dashboard & Reports
            Route::resource('home', 'HomeController', [ 'only' => ['index'] ]);
            Route::resource('dashboard', 'HomeController', [ 'only' => ['index'] ]);
            
            Route::get('getHeadcountData', 'HomeController@getHeadcountData')->name('getHeadcountData');
            Route::get('getHeadcountDeptData', 'HomeController@getHeadcountDeptData')->name('getHeadcountDeptData');
            Route::get('getNewHiresData', 'HomeController@getNewHiresData')->name('getNewHiresData');
            Route::get('getAssetData', 'HomeController@getAssetData')->name('getAssetData');
            Route::get('getCourseData', 'HomeController@getCourseData')->name('getCourseData');
            Route::get('getRewardCount', 'HomeController@getRewardCount')->name('getRewardCount');
            Route::get('getDisciplinaryActionCount', 'HomeController@getDisciplinaryActionCount')->name('getDisciplinaryActionCount');
            Route::get('getQALastFiveDaysData', 'HomeController@getQALastFiveDaysData')->name('getQALastFiveDaysData');
            Route::get('getQAEvaluationScoresData', 'HomeController@getQAEvaluationScoresData')->name('getQAEvaluationScoresData');
            Route::get('getTotalAssessmentData', 'HomeController@getTotalAssessmentData')->name('getTotalAssessmentData');

            Route::resource('reports', 'ReportController' );
            Route::any('reports-v2/{report}', 'ReportV2Controller@reports')->name('reports.getReportsData');
            Route::any('dashboard-v2/{dashboard}', 'ReportV2Controller@dashboard')->name('reports.getDashboardData');
            Route::get('reports-v2', 'ReportV2Controller@reports');
            Route::get('dashboard-v2', 'ReportV2Controller@dashboard' );
        #endregion

        #region MyPortal
            Route::resource('selfservice-portal', 'SSPController');

            Route::get('my-details/getProfile', 'SSPMyDetailsController@getProfile');
            Route::resource('my-details', 'SSPMyDetailsController',[
                'only'=>['index','update']
            ]);

            Route::resource('my-elearning/my-assessments', 'SSPMyCourseAssessmentsController',[
                'only'=>['index']
            ]);
            Route::post('my-elearning/enrol', 'SSPMyCourseController@enrol')->name('courseEnrol');;
            Route::get('my-elearning/my-courses', 'SSPMyCourseController@myCourses');
            Route::get('my-course/{Id}','SSPMyCourseController@renderTopic');
            Route::any('my-courses/{Id}/assessment/{assmId}', 'SSPMyCourseController@manageAssessment');
            Route::any('my-courses/{Id}/assessment/{assmId}/post/{status}/{redirect}', 'SSPMyCourseController@manageAssessment');
            Route::get('topic-attachment/{Id}/download', 'SSPMyCourseController@download')->name('sspmycourses.download');
            Route::get('my-courses/{Id}/getAssessmentData/', 'SSPMyCourseController@getAssessmentData')->name('sspmycourses.getassessmentdata');
            Route::get('my-courses/{Id}/getattachments/', 'SSPMyCourseController@getTopicAttachments');
            Route::get('my-courses/{Id}/restart/', 'SSPMyCourseController@restartCourse');
            Route::get('my-courses/{Id}/getattachments/', 'SSPMyCourseController@getTopicAttachments');
            Route::get('play/module/{Id}', 'SSPMyCourseController@playModule');
            Route::get('play/topic/{Id}', 'SSPMyCourseController@playTopic');
            Route::post('my-courses/progress', 'SSPMyCourseController@updateCourseProgress');
            Route::resource('my-courses', 'SSPMyCourseController',[
                'only'=>['index']
            ]);

            Route::resource('my-surveys', 'SSPMySurveysController');
            Route::any('survey-thumbnail/{formId}', 'SSPMySurveysController@getFormData');

            Route::resource('my-surveys2', 'SSPMySurveysNewController');

            Route::any('compliances/laws/{id}', 'SSPMyCompliancesController@law')->name('compliance.law');
            Route::any('compliances/policies/{id}', 'SSPMyCompliancesController@policy')->name('compliance.policy');

            #Absences and leaves
            Route::fileResource('my-leaves', 'SSPEmployeeLeavesController' );
            Route::get('/my-leaves/create/{leave_id}/{leave_desc}/{employee_id}', 'SSPEmployeeLeavesController@create');
            Route::get('/my-leaves/{leave_id}/view', 'SSPEmployeeLeavesController@viewDetails');
            Route::get('/my-leaves/status/{leave_id}/{status}', 'SSPEmployeeLeavesController@changeStatus');
            Route::get('/my-leaves/batch/{leave_ids}/{status}', 'SSPEmployeeLeavesController@batchChangeStatus');
            Route::post('/my-leaves/filter', 'SSPEmployeeLeavesController@filterLeave')->name('my-leaves.filter');
            Route::post('/my-leaves/filter/calendar', 'SSPEmployeeLeavesController@filterCalendar')->name('my-leaves.filter-calendar');
            Route::any('/my-leaves-history', 'SSPEmployeeLeavesController@historyLeave')->name('my-leaves.history');
            Route::any('/my-leaves-pending-request', 'SSPEmployeeLeavesController@pendingLeave')->name('my-leaves.pending');
            Route::any('/my-leaves/management/{type}', 'SSPEmployeeLeavesController@management');


            #working hours
            Route::get('my-working-hours', 'SSPMyWorkingHoursController@workingHours');
            Route::get('get_timer','SSPMyWorkingHoursController@getTimer');
            Route::post('set_timer','SSPMyWorkingHoursController@store')->name('working-hours.store');

            #my-team
            Route::resource('my-team', 'SSPMyTeamController');

            #my-kpi-results
            Route::any('my-kpi-results', 'SSPMyKpisController@kpiResults')->name('kpi_results.my_kpis');

            #my-vacancies
            Route::get('my-vacancies/{recruitment_id}/page/{page}/apply', 'SSPMyVacanciesController@applyInterview')->name('my-vacancies.apply-interview');
            Route::get('my-vacancies/{recruitment_id}/status/{candidate_id}/apply','SSPMyVacanciesController@showCandidateStatus')
                    ->name('my-vacancies.status');
            Route::get('my-vacancies', 'SSPMyVacanciesController@index')->name('my-vacancies.index');
                #endregion

            #region Central HR
            // "duplicate" routes to work with both create and edit mode
            Route::get('employees/check-id', 'EmployeesController@checkId');
            Route::get('employees/{employee}/check-id', 'EmployeesController@checkId');    
            Route::get('employees/check-name', 'EmployeesController@checkEmployee');
            Route::get('employees/{employee}/check-name', 'EmployeesController@checkEmployee');
            Route::get('employees/check-passport', 'EmployeesController@checkPassport');
            Route::get('employees/{employee}/check-passport', 'EmployeesController@checkPassport');
            Route::get('employees/check-employeeno', 'EmployeesController@checkEmployeeNo');
            Route::get('employees/{employee}/check-employeeno', 'EmployeesController@checkEmployeeNo')->name('check-employeeno');
            Route::get('employees/export/{type}','EmployeesController@export');

            Route::any('employees/{employee?}/departmentid', 'EmployeesController@getEmployeeDepartmentId')->name('get-departmentid');
            Route::get('employees/{employee?}/qualifications', 'EmployeesController@qualifications')->name('get.qualifications');
            Route::any('employees/{employee?}/edit/employee-history', 'EmployeesController@editEmployeeHistory')->name('employee-history');
            Route::any('employees/{employee?}/update/employee-history', 'EmployeesController@updateEmployeeHistory')->name('employees-history.update');
            
            Route::resource('employees', 'EmployeesController');

            Route::resource('announcements', 'AnnouncementsController');
            Route::post('announcements/dependent-department-employee',
                'AnnouncementsController@dependentDepartmentEmployee')->name('announcements.dependent-department-employee');
            Route::fileResource('laws');
            Route::fileResource('policies');
            Route::fileResource('topics');
            Route::get('topics/view/{topic}', 'TopicsController@view' );
            Route::fileResource('employees');
            //Route::fileResource('assessments');
            Route::resource('organisationcharts', 'OrganisationChartsController', [ 'only' => ['index']]);
            
            Route::resource('assets', 'AssetsController');
            Route::get('assets/depreciation/{Id}', 'AssetsController@depreciation' )->name('assets.depreciation');
            Route::get('assets/history/{Id}', 'AssetsController@history' )->name('assets.history');
            Route::resource('asset_groups', 'AssetGroupsController');
            Route::resource('asset_suppliers', 'AssetSuppliersController');
            Route::resource('asset_allocations', 'AssetAllocationsController');

            Route::resource('surveys', 'SurveysController' );
            Route::get('surveys/{Id}/results', 'SurveysController@results' );

            Route::resource('newsurveys', 'NewSurveysController' );
            Route::any('newsurveys/{survey}/results', 'NewSurveysController@results' );
            Route::get('newsurveys/{survey}/employeeresult', 'NewSurveysController@employeeResult' );
            Route::get('surveys/export-csv/{questionnaire_id}', 'NewSurveysController@exportCsv');
            Route::post('surveys/dependent-department-employee',
                'NewSurveysController@dependentDepartmentEmployee')->name('surveys.dependent-department-employee');
			
            Route::resource('timelines', 'TimelinesController', [
                'parameters' => ['index' => 'employee'],
                'names' => ['show' => 'timelines.index'],
                'only' => ['show']
            ]);
            Route::employeeInResource('rewards');
            Route::employeeInResource('disciplinary_actions');
            Route::get('disciplinaryactions/employee/{employee_id}/{MediaId}/preview/{preview}/attachment', 'DisciplinaryActionsController@attachment' );
            Route::get('disciplinaryactions/employee/{employee_id}/{MediaId}/preview/{preview}/attachment/{mediable}', 'DisciplinaryActionsController@download' );

            Route::resource('kpis', 'KpiRulesController');
            Route::get('kpis/{kpi?}/kpis-modules', 'KpiRulesController@getModels')->name('get-models');
            Route::post('get-evaluations/{model}/{item_id}', 'KpiRulesController@getEvaluations')->name('get-evaluations');

        #endregion

        #region Configuration parameters routes
            Route::group(['prefix'=>'config'], function(){
                Route::get('employees', 'ConfigDropdownsController@employees')->name('employees');
            });
            Route::resource('disciplinary_decisions', 'DisciplinaryDecisionsController');
            Route::resource('disabilities', 'DisabilitiesController');
            //Route::resource('disability_categories', 'DisabilityCategoriesController');
            Route::resource('law_categories', 'LawCategoriesController');
            Route::resource('policy_categories', 'PolicyCategoriesController');
            Route::resource('genders', 'GendersController');
            Route::resource('titles', 'TitlesController');
            Route::resource('marital_statuses', 'MaritalStatusesController');
            Route::resource('skills', 'SkillsController');
            Route::resource('teams', 'TeamsController');
            Route::resource('tax_statuses', 'TaxStatusesController');
            Route::resource('branches', 'BranchesController');
            Route::resource('countries', 'CountriesController');
            Route::resource('locations', 'LocationsController');
            Route::resource('departments', 'DepartmentsController');
            Route::resource('divisions', 'DivisionsController');
            Route::resource('document_categories', 'DocumentCategoriesController');
            Route::resource('document_types', 'DocumentTypesController');
            Route::resource('employee_statuses', 'EmployeeStatusesController');
            Route::resource('ethnic_groups', 'EthnicGroupsController');
            Route::resource('immigration_statuses', 'ImmigrationStatusesController');
            Route::resource('job_titles', 'JobTitlesController');
            Route::resource('languages', 'LanguagesController');
            Route::resource('time_periods', 'TimePeriodsController');
            Route::resource('time_groups', 'TimeGroupsController');
            Route::resource('products', 'ProductsController');
            //Route::resource('employee_attachment_types', 'EmployeeAttachmentTypesController');
            Route::resource('assessment_types', 'AssessmentTypesController');
            //Route::resource('learning_material_types', 'LearningMaterialTypesController');
            //Route::resource('training_delivery_methods', 'TrainingDeliveryMethodsController');
            Route::resource('product_categories', 'ProductCategoriesController');
            Route::resource('category_question_types', 'CategoryQuestionTypesController');
            Route::resource('companies', 'CompaniesController');
            Route::resource('report_templates', 'ReportTemplatesController');
            Route::resource('sham_user_profiles', 'ShamUserProfilesController');
            Route::any('sham_user_profiles/{Id}/matrix', 'ShamUserProfilesController@matrix')->name('sham_user_profiles.matrix');
            Route::resource('sham_users', 'ShamUsersController');
            Route::resource('users', 'UsersController');
            Route::get('users/{user}/logs', 'UsersController@logs')->name('authentication_log');
            Route::get('/general_options', 'GeneralOptionsController@index')->name('general_options.index');
            Route::post('/general_options/store', 'GeneralOptionsController@store')->name('general_options.store');
            Route::resource('asset_conditions', 'AssetConditionsController');
            Route::resource('violations', 'ViolationsController');

            Route::resource('contracts', 'ContractsController');
            Route::resource('interviews', 'InterviewsController');
            Route::resource('offers', 'OffersController');
            Route::resource('qualification-recruitments', 'QualificationRecruitmentsController');
            Route::resource('audits', 'AuditsController');
        #endregion

        #region E-Learning
            Route::get('elearning', 'MiscController@elearningHelper');
            Route::resource('courses', 'CoursesController' );
            Route::resource('modules', 'ModulesController' );

            Route::get('topics/embed/{file}', 'TopicsController@embedMedia');
            Route::get('topics/{topic?}/snippets', 'TopicsController@getSnippets');
            Route::resource('topics', 'TopicsController' );
            Route::get('topics/{topic?}/topic-embeds', 'TopicsController@embeds')->name('get-video-embeds');

            Route::resource('module_assessments', 'ModuleAssessmentsController' );
            Route::resource('module_assessments/{module_assessment}/responses', 'ModuleAssessmentResponsesController',[
                'only'=>['index', 'update']
            ]);
            Route::get('module_assessments/{response}/responses/{module_assessment}/employee/{employee_id}/editAssessment', 'ModuleAssessmentResponsesController@editAssessment');
            Route::resource('course_training_sessions', 'CourseTrainingSessionsController' );
        #endregion

        #region Quality
            Route::any('assessments/assessment/{assessment}/clone', 'AssessmentsController@clone')->name('assessment.clone');
            Route::get('assessments/assessment/{assessment}/cloneForm', 'AssessmentsController@cloneForm')->name('assessments.clone-assessment-form');
            Route::get('assessments/assessment/{assessment}/preview', 'AssessmentsController@preview')->name('assessments.preview');
            Route::resource('assessments', 'AssessmentsController' );
            Route::any('assessments/duplicates/', 'AssessmentsController@duplicates')->name('assessment.duplicates');
            Route::resource('assessment_categories', 'AssessmentCategoriesController');
            Route::resource('category_questions', 'CategoryQuestionsController');
            Route::fileResource('evaluations', 'EvaluationsController');
            Route::any('instances', 'EvaluationsController@showInstances')->name('evaluations.instances');
            Route::get('evaluations/{id}/EvaluationId/{EvaluationId}/assess', 'EvaluationsController@loadAssessment')->name('evaluations.load_assessment');
            Route::post('evaluations/{id}/EvaluationId/{EvaluationId}/submitassessment', 'EvaluationsController@submitAssessment')->name('evaluations.submit_assessment');
            Route::get('evaluations/{assessor}/score/{evaluationid}/show', 'EvaluationsController@score')->name('evaluations.score');
            Route::get('evaluations/{assessor}/score/{evaluationid}/show-score-modal', 'EvaluationsController@scoreCompletedEvaluation')->name('evaluations.score-completed-evaluation');
            Route::any('evaluations/{Id}/name/{name}/downloadscorepdf', 'EvaluationsController@downloadScorePdf' )->name('evaluations.pdfscores');
            Route::any('evaluations/{Id}/EvaluationId/{EvaluationId}/AssessorId/{AssessorId}/summary', 'EvaluationsController@summary')->name('evaluations.summary');
            Route::get('getaudio', 'EvaluationsController@getaudio');
            Route::get('getaudio1', 'EvaluationsController@getaudio1');
            Route::get('getaudiolist', 'EvaluationsController@getaudiolist');
        #endregion

        #region Imports
            Route::get('import', 'ImportsController@getImport')->name('import');
            Route::post('import_parse', 'ImportsController@parseImport')->name('import_parse');
            Route::post('import_process', 'ImportsController@processImport')->name('import_process');
        #endregion

        #region Recruitment
        Route::resource('recruitment', 'RecruitmentsController');

	    Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/interview/{interview}/delete-media', 'RecruitmentRequestsController@deleteInterviewMedia')->name('recruitment_requests.delete-interview-media');
        Route::get('recruitment_requests/{recruitment_request}/candidate/{candidate}/interview/{interview}/download-media/{media}', 'RecruitmentRequestsController@downloadInterviewMedia')->name('recruitment_requests.download-interview-media');

        Route::get('recruitment_requests/{recruitment_request}/stages/{interview}/candidate/{candidate?}/edit-interview', 'RecruitmentRequestsController@editInterview')->name('recruitment_requests.edit-interview');
        Route::patch('recruitment_requests/{recruitment_request}/stages/{interview}/candidate/{candidate?}/update-interview', 'RecruitmentRequestsController@updateInterview')->name('recruitment_requests.update-interview');
        Route::fileResource('recruitment_requests', 'RecruitmentRequestsController');
        Route::get('recruitment_requests/{recruitment_request}/stages', 'RecruitmentRequestsController@showStages')->name('recruitment_requests.stages');
        Route::get('recruitment_requests/{recruitment_request}/candidates', 'RecruitmentRequestsController@getCandidates')->name('recruitment_requests.candidates-list');
        Route::get('recruitment_requests/{recruitment_request}/offer-letters', 'RecruitmentRequestsController@getOfferLetters')->name('recruitment_requests.offer-letters-list');
        Route::get('recruitment_requests/{recruitment_request}/contracts', 'RecruitmentRequestsController@getContracts')->name('recruitment_requests.contracts-list');
        Route::post('recruitment_requests/{recruitment_request}/switch/{candidate}/{state}', 'RecruitmentRequestsController@stateSwitch')->name('recruitment_requests.update-status');
        Route::post('recruitment_requests/{recruitment_request}/interviewing/{candidate}', 'RecruitmentRequestsController@getInterviewing')->name('recruitment_requests.get-interviewing');
        Route::post('recruitment_requests/{recruitment_request}/upload-offer', 'RecruitmentRequestsController@saveSignedOfferForm')->name('recruitment_requests.upload-offer');

        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-offer', 'RecruitmentRequestsController@downloadOffer')->name('recruitment_requests.download-offer');
        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-signed-offer', 'RecruitmentRequestsController@downloadSignedOffer')->name('recruitment_requests.download-signed-offer');
        Route::get('recruitment_requests/{recruitment_request}/candidate/{candidate}/offer/{offer}/upload-offer-form', 'RecruitmentRequestsController@uploadSignedOfferForm')->name('recruitment_requests.upload-offer-form');

        Route::post('recruitment_requests/{recruitment_request}/upload-contract', 'RecruitmentRequestsController@saveSignedContractForm')->name('recruitment_requests.upload-contract');
        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-contract', 'RecruitmentRequestsController@downloadContract')->name('recruitment_requests.download-contract');
        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-signed-contract', 'RecruitmentRequestsController@downloadSignedContract')->name('recruitment_requests.download-signed-contract');
        Route::get('recruitment_requests/{recruitment_request}/candidate/{candidate}/contract/{contract}/upload-contract-form', 'RecruitmentRequestsController@uploadSignedContractForm')->name('recruitment_requests.upload-contract-form');

        Route::any('recruitment_requests/{recruitment_request}/candidate/{candidate}/hired-existing-employee', 'RecruitmentRequestsController@importHiredExistingEmployee')->name('recruitment_requests.hired-existing-employee');
        Route::any('recruitment_requests/{recruitment_request}/candidate/{candidate}/hired', 'RecruitmentRequestsController@importHiredCandidate')->name('recruitment_requests.hired');
        Route::any('recruitment_requests/{recruitment_request}/candidate/{candidate}/update-interview-comment', 'RecruitmentRequestsController@updateInterviewComment')->name('recruitment_requests.update-interview-comment');
        Route::get('recruitment_requests/{request?}/manage-candidate', 'RecruitmentRequestsController@manageCandidate');
        Route::patch('recruitment_requests/{request?}/update-candidate', 'RecruitmentRequestsController@updateCandidate')->name('recruitment_requests.update-candidate');
        Route::fileResource('candidates', 'CandidatesController');
        Route::get('candidates/{candidate?}/candidate-qualifications', 'CandidatesController@qualifications')->name('get-candidate-qualifications');
        Route::get('candidates/{candidate?}/previous_employments', 'CandidatesController@previousEmployments')->name('get-candidate-employments');
        #endregion

        #region Leaves
            Route::resource('absence_types', 'AbsenceTypesController');
            Route::resource('entitlements', 'EntitlementsController');
            Route::resource('history_leave', 'LeavesController', [ 'only' => ['index'] ]);
        #endregion

        #region Time and Attendances
            Route::resource('time_attendances', 'TimeAttendancesController');
            Route::any('data_upload', 'TimeAttendancesController@dataUpload')->name('time_attendances.data-upload');
            Route::any('daily_records', 'TimeAttendancesController@dailyRecords')->name('time_attendances.daily-records');
        #endregion
    });
#endregion
