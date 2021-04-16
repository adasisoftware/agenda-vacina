<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->post('/login', 'Auth::logar');
$routes->get('/login/logout', 'Auth::logout');

$routes->group('dashboard', ['filter' => 'authFilter'], function ($routes) {
	$routes->get('', 'DashboardController::index');
});

//agenda
$routes->group('agenda', ['filter' => 'authFilter'], function ($routes) {
	$routes->get('', 'AgendaController::index');
	$routes->get('novo', 'AgendaController::create');
	$routes->post('save', 'AgendaController::save');
	$routes->post('excluir/(:alphanum)', 'AgendaController::delete/$1');
	$routes->get('editar/(:alphanum)', 'AgendaController::update/$1');
	$routes->get('get-by-grupo-verification/(:alphanum)', 'AgendaController::getByGrupoVerification/$1');
	$routes->get('get-by-grupo/(:alphanum)', 'AgendaController::getByGrupo/$1');
	$routes->get('copiar/(:alphanum)', 'AgendaController::copy/$1');
	$routes->get('verification-edit-vagas/(:alphanum)', 'AgendaController::verificationEditVagas/$1');
});

//agendamento
$routes->group('agendamento', ['filter' => 'authFilter'], function ($routes) {
	$routes->get('', 'AgendamentoController::index');
	$routes->get('novo', 'AgendamentoController::create');
	$routes->post('save', 'AgendamentoController::save');
	$routes->post('excluir/(:alphanum)', 'AgendamentoController::delete/$1');
	$routes->get('editar/(:alphanum)', 'AgendamentoController::update/$1');
	$routes->get('get-by-paciente/(:alphanum)', 'AgendamentoController::getByPaciente/$1');
	$routes->get('print-screen/(:alphanum)', 'AgendamentoController::printScreen/$1');
	$routes->get('get-count-data-by-agendamento', 'AgendamentoController::getCountDataByAgendamento');
	$routes->get('get-by-agenda_id/(:alphanum)', 'AgendamentoController::getAgendaByAgendaId/$1');
});

// routs grupo
$routes->group('grupo', ['filter' => 'authFilter'], function ($routes) {
	$routes->get('', 'GrupoController::index');
	$routes->get('novo', 'GrupoController::create');
	$routes->post('save', 'GrupoController::save');
	$routes->post('excluir/(:alphanum)', 'GrupoController::delete/$1');
	$routes->get('editar/(:alphanum)', 'GrupoController::update/$1');
});

// rots usuario
$routes->group('usuario', ['filter' => 'authFilter'], function ($routes) {
	$routes->get('', 'UsuarioController::index');
	$routes->get('novo', 'UsuarioController::create');
	$routes->get('editar/(:alphanum)', 'UsuarioController::update/$1');
	$routes->post('save', 'UsuarioController::save');
	$routes->post('excluir/(:alphanum)', 'UsuarioController::delete/$1');
	$routes->post('get-by-email', 'UsuarioController::getByEmail');
});

// rots paciente
$routes->group('paciente', ['filter' => 'authFilter'], function ($routes) {
	$routes->get('', 'PacienteController::index');
	$routes->get('novo', 'PacienteController::create');
	$routes->get('editar/(:alphanum)', 'PacienteController::update/$1');
	$routes->post('save', 'PacienteController::save');
	$routes->post('get-by-cpf', 'PacienteController::getByCpf');
	$routes->post('excluir/(:alphanum)', 'PacienteController::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
