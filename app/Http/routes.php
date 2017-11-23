<?php
/**
 * Rutas GET
 */
Route::get('/', ['uses'=>'Auth\AuthController@getLogin'       ,   'as' => 'login']);
Route::get('logout', ['uses'=>'Auth\AuthController@getLogout' ,   'as' => 'logout']);
Route::get('errorRole', ['uses'=>'AdminController@errorRole'  ,   'as' => 'home']);
Route::get('/testing', ['uses'=>'AdminLTEController@testing'  ,   'as' => 'testing']);

/**
 * Rutas POST
 */
Route::post('/', ['uses'=>'Auth\AuthController@postLogin'     ,   'as' => 'login']);


Route::group(['middleware'=>['auth'], 'prefix'=>'home' ], function () {
    Route::get('/', ['uses'=>'AdminController@index'         ,    'as' => 'home'      ]);
});

Route::group(['middleware'=>['user']], function () {
    Route::group(['middleware'=>['supervisor', 'cliente', 'calidad']], function () {

        // Dashboard
        Route::get('dashboard_01', ['uses'=>'DashboardController@dashboard_01']);
        Route::post('dashboard_03', ['uses'=>'Dashboard03Controller@index']);

        Route::post('dashboard_01/getVariablesGlobals', ['uses'=>'DashboardController@getVariablesGlobals']);
        Route::post('dashboard_01/getEventKpi', ['uses'=>'DashboardController@getEventKpi']);
        Route::post('dashboard_01/getListQueues', ['uses'=>'DashboardController@getListQueues']);
        Route::post('dashboard_01/getQuantityCalls', ['uses'=>'DashboardController@getQuantityCalls']);
        Route::post('dashboard_01/panelAgentStatusSummary', ['uses'=>'DashboardController@panelAgentStatusSummary']);
        Route::post('dashboard_01/panelGroupStatistics', ['uses'=>'DashboardController@panelGroupStatistics']);

        // Reportes de consolidado de eventos
        Route::post('events_consolidated', ['uses'=>'EventsAgentController@events_consolidated']);

        // Repote nuevo de eventos
        Route::post('detail_event_report', ['uses'=>'DetailEventsReportController@index']);

        // Reporte de llamadas salienes
        Route::post('agents_online', ['uses'=>'AgentsOnlineController@index']);

        // Administrar Usuarios
        Route::post('manage_users', ['uses'=>'UserController@index']);
        Route::post('viewqueuesUsers', ['uses'=>'UserController@viewQueuesUsers']);
        Route::post('getqueuesUsers', ['uses'=>'UserController@getQueuesUsers']);
        Route::post('form_assign_queue', ['uses'=>'UserController@formAssignQueue']);
        Route::post('form_change_password', ['uses'=>'UserController@formChangePassword']);
        Route::post('form_change_rol', ['uses'=>'UserController@formChangeRol']);
        Route::post('form_status_user', ['uses'=>'UserController@formChangeStatus']);
        Route::post('saveformassignQueues', ['uses'=>'UserController@saveFormAssingQueue']);
        Route::post('saveformchangeStatus', ['uses'=>'UserController@saveFormChangeStatus']);

        // Administrar Queues
        Route::post('manage_queues', ['uses'=>'QueuesController@index']);
        Route::post('form_queues', ['uses'=>'QueuesController@formQueues']);
        Route::post('form_status_queue', ['uses'=>'QueuesController@formChangeStatus']);
        Route::post('form_assign_user', ['uses'=>'QueuesController@formAssignUser']);
        Route::post('saveformQueues', ['uses'=>'QueuesController@saveFormQueues']);
        Route::post('saveformQueuesStatus', ['uses'=>'QueuesController@saveFormQueuesStatus']);
        Route::post('saveformAssignUser', ['uses'=>'QueuesController@saveFormAssingUser']);
        Route::post('exportQueues', ['uses'=>'QueuesController@exportQueues']);
        Route::post('executeSSH', ['uses'=>'QueuesController@executeSSH']);
        Route::post('taskmanagerQueues', ['uses'=>'QueuesController@taskManagerQueues']);

        // Administrar Template Queues
        Route::post('manage_template_queues', ['uses'=>'QueuesTemplateController@index']);

        // Administrar los Sonidos de los masivos
        Route::post('manage_sound_massive', ['uses'=>'SoundMassiveController@index']);
        Route::post('form_status_sound_massive', ['uses'=>'SoundMassiveController@formChangeStatus']);
        Route::post('saveformSoundMassiveStatus', ['uses'=>'SoundMassiveController@saveFormSoundMassiveStatus']);

        // Broadcast Message
        Route::post('broadcast_message', ['uses'=>'BroadcastMessageController@index']);
    });

    // Reporte de encuestaa
    Route::post('surveys', ['uses'=>'SurveysController@index']);

    // Reportes de eventos
    Route::post('events_detail', ['uses'=>'EventsAgentController@events_detail']);

    // Lista de anexos
    Route::post('agents_annexed', ['uses'=>'AgentsAnnexedController@index']);
    Route::post('agents_annexed/user', ['uses'=>'AgentsAnnexedController@getUserAnexo']);
    Route::post('agents_annexed/list_annexed', ['uses'=>'AgentsAnnexedController@getListAnnexed']);

    // Reportes calls
    Route::post('incoming_calls', ['uses'=>'IncomingCallsController@index']);
    Route::post('outgoing_calls', ['uses'=>'OutgoingCallsController@index']);
    Route::post('consolidated_calls', ['uses'=>'ConsolidatedCallsController@index']);

    // Rutas de exportacion
    Route::post('export_incoming', ['uses'=>'IncomingCallsController@export']);
    Route::post('export_outgoing', ['uses'=>'OutgoingCallsController@export']);
    Route::post('export_consolidated', ['uses'=>'ConsolidatedCallsController@export']);
    Route::post('export_events_detail', ['uses'=>'EventsAgentController@export_event_detail']);
    Route::post('export_events_consolidated', ['uses'=>'EventsAgentController@export_event_consolidated']);
    Route::post('export_details_events_report', ['uses'=>'DetailEventsReportController@export_details_events_report']);
    Route::post('export_agents_online', ['uses'=>'AgentsOnlineController@export']);
    Route::post('export_surveys', ['uses'=>'SurveysController@export']);
    Route::post('export_list_user', ['uses'=>'UserController@export']);

    // Perfil de Usuario
    Route::post('profile_users', ['uses'=>'UserController@changeProfile']);
    Route::post('viewUsers', ['uses'=>'UserController@viewUser']);
    Route::post('uploadPerfil', ['uses'=>'UserController@uploadPerfil']);
    Route::post('viewUbigeo', ['uses'=>'UserController@viewUbigeo']);
    Route::post('viewDepartamento', ['uses'=>'UserController@viewDepartamento']);
    Route::post('viewProvincia', ['uses'=>'UserController@viewProvincia']);
    Route::post('viewDistrito', ['uses'=>'UserController@viewDistrito']);

    // Miscelaneas
    Route::post('assistance', ['uses'=>'AssistanceController@index'         ,    'as' => 'assistance']);
    Route::post('working', ['uses'=>'AdminController@working'            ,    'as' => 'working']);
    Route::post('setQueueAdd', ['uses'=>'AdminController@setQueueAdd'        ,    'as' => 'setQueueAdd']);
    Route::post('createUser', ['uses'=>'UserController@createUser'          ,    'as' => 'createUser']);
    Route::post('changeStatus', ['uses'=>'UserController@changeStatus'        ,    'as' => 'changeStatus']);
    Route::post('form_change_password', ['uses'=>'UserController@formChangePassword',  'as' => 'changePassword']);
    Route::post('saveformchangePassword', ['uses'=>'UserController@saveFormChangePassword']);
    Route::post('saveformchangeRole', ['uses'=>'UserController@saveFormChangeRole']);

    Route::post('updateStatusAddAgentDashboard', ['uses'=>'AdminController@updateStatusAddAgentDashboard','as'=>'updateStatusAddAgentDashboard']);

    // FrontPanel
    Route::post('frontPanel/getQueuesUser', ['uses'=>'AdminController@getQueuesUser']);
    Route::post('frontPanel/getAgentDashboard', ['uses'=>'AdminController@getAgentDashboard']);
    Route::post('frontPanel/getAllListEvents', ['uses'=>'AdminController@getAllListEvents']);
    Route::post('frontPanel/broadcastMessage', ['uses'=>'BroadcastMessageController@getBroadcastMessage']);

    Route::post('frontPanel/getVariablesGlobals', ['uses'=>'AdminController@getVariablesGlobals']);
    Route::post('frontPanel/getStatusAddAgentDashboard', ['uses'=>'AdminController@getStatusAddAgentDashboard']);
});
