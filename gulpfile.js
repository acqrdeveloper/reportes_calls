let elixir = require('laravel-elixir')
require('laravel-elixir-webpack')

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = false

elixir(function(mix) {
	mix
		.scripts([
			'node_modules/vue/vue.min.js',
			'node_modules/vue-resource/vue-resource.min.js',
			'node_modules/socket.io-client/socket.io.min.js',
			'node_modules/sails.io/sails.io.js',
			'../../.env.js'
		],'public/js/vuesockets.min.js','resources/assets/')

		/**
	  Generando el archivo cosapi_realtime.min.js para mostrar data realtime en panel
	  */
		.scripts([
			'sapia/js/front.js',
			'sapia/js/helper.js',
			'sapia/js/datatable.js',
			'sapia/js/frontVue.js'
		],'public/js/personalizeFunctions.min.js','resources/assets/')

		.scripts([
			'node_modules/vue-select/vue-select.js',
			'sapia/js/profileuserVue.js'
		],'public/js/profileuserVue.min.js','resources/assets/')
})

/*
  Generando los archivos css y js para el Layout Login
*/
elixir(function(mix) {
	mix
		.styles([
			'vendor/adminlte/plugins/font-awesome/css/font-awesome.css',
			'vendor/adminlte/plugins/bootstrap/dist/css/bootstrap.css',
			'vendor/adminlte/dist/css/AdminLTE.css',
			'sapia/css/login.css'
		],'public/css/login.min.css','resources/assets/')
		.scripts([
			'vendor/adminlte/plugins/jquery/dist/jquery.js',
			'vendor/adminlte/plugins/bootstrap/dist/js/bootstrap.js',
			'extras/bootstrap-typeahead/js/bootstrap-typeahead.min.js',
			'extras/jquery-backstretch/jquery.backstretch.min.js'
		],'public/js/cosapidata_login.min.js','resources/assets/')
})

/*
  Generando los archivos css y js para el Layout Dashboard
*/
elixir(function(mix) {
	mix
		.styles([
			'vendor/adminlte/plugins/bootstrap/dist/css/bootstrap.css',
			'vendor/adminlte/plugins/font-awesome/css/font-awesome.css',
			'vendor/adminlte/dist/css/AdminLTE.css',
			'sapia/css/preloader.css'
		],'public/css/dashboard.min.css','resources/assets/')
		.scripts([
			'vendor/adminlte/plugins/jquery/dist/jquery.js',
			'vendor/adminlte/plugins/bootstrap/dist/js/bootstrap.js',
			'vendor/adminlte/plugins/fastclick/lib/fastclick.js',
			'../../.env.js',
			'sapia/js/helper.js',
			'node_modules/vue/vue.min.js',
			'node_modules/vue-resource/vue-resource.min.js',
			'node_modules/vue-select/vue-select.js',
			'node_modules/socket.io-client/socket.io.min.js',
			'sapia/js/cookie.js',
            'node_modules/daterangepicker/moment.min.js'
		],'public/js/dashboard.min.js','resources/assets/')
})

/*
 Generando los archivos css y js para el layout que necesite AdminLTE 2.4
*/
elixir(function(mix) {
	mix
		.styles([
			'vendor/adminlte/plugins/bootstrap/dist/css/bootstrap.css',
			'vendor/adminlte/plugins/font-awesome/css/font-awesome.css',
			'vendor/adminlte/plugins/Ionicons/css/ionicons.css',
			'vendor/adminlte/dist/css/AdminLTE.css',
			'vendor/adminlte/dist/css/skins/_all-skins.css',
			'sapia/css/preloader.css'
		],'public/css/adminlte.min.css','resources/assets/')
		.scripts([
			'vendor/adminlte/plugins/jquery/dist/jquery.js',
			'vendor/adminlte/plugins/bootstrap/dist/js/bootstrap.js',
			'vendor/adminlte/plugins/fastclick/lib/fastclick.js',
			'vendor/adminlte/dist/js/adminlte.js',
			'sapia/js/right_menu_adminlte.js'
		],'public/js/adminlte.min.js','resources/assets/')
})

/**
 Generando un solo archivo css y js para la funcionalidad de daterangepicker
*/
elixir(function(mix) {
	mix
		.styles([
			'daterangepicker/daterangepicker.css'
		],'public/css/daterangepicker.min.css','resources/assets/node_modules/')
		.scripts([
			'daterangepicker/moment.min.js',
			'daterangepicker/daterangepicker.js'
		],'public/js/daterangepicker.min.js','resources/assets/node_modules/')
})

/**
 Generando un solo archivo css y js para la funcionalidad de notificaciones
*/
elixir(function(mix) {
	mix
		.styles([
			'extras/bootstrap3-dialog/css/bootstrap-dialog.min.css',
			'extras/toastr/toastr.min.css'
		],'public/css/notifications.min.css','resources/assets/')
		.scripts([
			'extras/bootstrap3-dialog/js/bootstrap-dialog.js',
			'extras/toastr/toastr.js'
		],'public/js/notifications.min.js','resources/assets/')
})

/**
 Generando un solo archivo css y js para la funcionalidad de datatables
*/
elixir(function(mix) {
	mix
		.styles([
			'plugins/datatables/Buttons-1.2.1/css/buttons.bootstrap.min.css',
			'plugins/datatables/DataTables-1.10.12/css/dataTables.bootstrap.min.css',
			'plugins/datatables/Responsive-2.1.0/css/responsive.bootstrap.min.css',
			'plugins/datatables/Select-1.2.0/css/select.bootstrap.min.css',
			'plugins/datatables/FixedColumns-3.2.2/css/fixedColumns.bootstrap.min.css',
			'plugins/datatables/FixedHeader-3.1.2/css/fixedHeader.bootstrap.min.css',
			'sapia/css/cosapi.css'
		],'public/css/datatables.min.css','resources/assets/')
		.scripts([
			'plugins/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js',
			'plugins/datatables/DataTables-1.10.12/js/dataTables.bootstrap.min.js',
			'plugins/datatables/Select-1.2.0/js/dataTables.select.min.js',
			'plugins/datatables/FixedColumns-3.2.2/js/dataTables.fixedColumns.min.js',
			'plugins/datatables/FixedHeader-3.1.2/js/dataTables.fixedHeader.min.js',
			'plugins/datatables/JSZip-2.5.0/jszip.min.js',
			'plugins/datatables/Responsive-2.1.0/js/dataTables.responsive.min.js',
			'plugins/datatables/Responsive-2.1.0/js/responsive.bootstrap.min.js',
			'plugins/datatables/Buttons-1.2.1/js/dataTables.buttons.min.js',
			'plugins/datatables/Buttons-1.2.1/js/buttons.bootstrap.min.js',
			'plugins/datatables/Buttons-1.2.1/js/buttons.html5.min.js'
		],'public/js/datatables.min.js','resources/assets/')
})

/**
 Generando un solo archivo css y js para la funcionalidad de select
*/
elixir(function(mix) {
	mix
		.styles([
			'plugins/select2/select2.css'
		],'public/css/select2.min.css','resources/assets/')
		.scripts([
			'plugins/select2/select2.js'
		],'public/js/select2.min.js','resources/assets/')
})

/**
 Generando los archivos para el drop and drag el cual se usara en el dashboard_03
*/
elixir(function(mix) {
	mix
		.scripts([
			'vendor/drop-drag/jquery-ui/jquery-ui.min.js',
			'vendor/drop-drag/dashboard.js'
		],'public/js/drop-drag.min.js','resources/assets/')
})

/**
 Generando los archivos para el highchart el cual se usara en el dashboard_03
*/
elixir(function(mix) {
	mix
		.scripts([
			'highcharts.js',
			'modules/exporting.js'
		],'public/js/highchart.min.js','resources/assets/node_modules/highcharts/')
})



elixir(function(mix) {
	/**
  Copiar archivos para funcionamiento de adminLTE y Boostrap
  */
	mix
		/**
		 * Archivos necesario para el Adminlte 2.4
		 */
		.copy('resources/assets/vendor/adminlte/plugins/bootstrap/dist/fonts'       , 'public/fonts')
		.copy('resources/assets/vendor/adminlte/plugins/Ionicons/fonts'             , 'public/fonts')
		.copy('resources/assets/vendor/adminlte/plugins/font-awesome/fonts'         , 'public/fonts')
		.copy('resources/assets/sapia/css/fonts-googleapis.css'                     , 'public/css/fonts-googleapis.css')
		.copy('resources/assets/sapia/css/fonts-google-apis'                        , 'public/css/fonts-google-apis')

		/**
		* Generando los archivos para autogestionar los formularios con Vue
		*/
		.copy('resources/assets/sapia/js/form/formUsers.js'									, 'public/js/form/formUsers.min.js')
        .copy('resources/assets/sapia/js/form/formQueues.js'								, 'public/js/form/formQueues.min.js')
        .copy('resources/assets/sapia/js/form/formSoundMassive.js'							, 'public/js/form/formSoundMassive.min.js')

		/**
	  	* Copiar imagenes en una sola carpeta
	  	*/
		.copy('resources/assets/images'										, 'public/img')
		.copy('resources/assets/sapia/img'									, 'public/img')
		.copy('resources/assets/index.php'									, 'public/index.php')
		.copy('resources/assets/favicon.ico'								, 'public/favicon.ico')

		.copy('resources/assets/sapia/favicon'								, 'public/favicon')
		.copy('resources/assets/sapia/background'							, 'public/background')
        .copy('resources/assets/sapia/script_php'							, 'public/script_php')
        .copy('resources/assets/sapia/sonidos'								, 'public/sonidos')
		.copy('resources/assets/images/default_avatar.png'					, 'public/storage/default_avatar.png')

		.copy('resources/assets/sapia/css/dashboard.css'					, 'public/css/dashboard.css')
		.copy('resources/assets/sapia/js/graphics.js'						, 'public/js/graphics.js')

		.copy('resources/assets/sapia/js/dashboard_vue.js'					, 'public/js/dashboard_vue.min.js')
		.copy('resources/assets/sapia/js/taskqueueVue.js'					, 'public/js/taskqueueVue.min.js')
		.copy('resources/assets/sapia/js/viewuserqueueVue.js'				, 'public/js/viewuserqueueVue.min.js')

		.copy('resources/assets/node_modules/push.js/push.min.js'			, 'public/js/push.min.js')
})
