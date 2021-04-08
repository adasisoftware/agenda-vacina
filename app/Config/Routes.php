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

$routes->get('/dashboard', 'DashboardController::index');

//agenda
$routes->get('/agenda', 'AgendaController::index');
$routes->get('/agenda/novo', 'AgendaController::create');
$routes->post('/agenda/save', 'AgendaController::save');
$routes->post('/agenda/excluir/(:alphanum)', 'AgendaController::delete/$1');
$routes->get('/agenda/editar/(:alphanum)', 'AgendaController::update/$1');
$routes->get('/agenda/get-by-grupo-verification/(:alphanum)', 'AgendaController::getByGrupoVerification/$1');
$routes->get('/agenda/get-by-grupo/(:alphanum)', 'AgendaController::getByGrupo/$1');
$routes->get('/agenda/copiar/(:alphanum)', 'AgendaController::copy/$1');
$routes->get('/agenda/verification-edit-vagas/(:alphanum)', 'AgendaController::verificationEditVagas/$1');

//agendamento
$routes->get('/agendamento', 'AgendamentoController::index');
$routes->get('/agendamento/novo', 'AgendamentoController::create');
$routes->post('/agendamento/save', 'AgendamentoController::save');
$routes->post('/agendamento/excluir/(:alphanum)', 'AgendamentoController::delete/$1');
$routes->get('/agendamento/editar/(:alphanum)', 'AgendamentoController::update/$1');
$routes->get('/agendamento/get-by-paciente/(:alphanum)', 'AgendamentoController::getByPaciente/$1');
$routes->get('/agendamento/print-screen/(:alphanum)', 'AgendamentoController::printScreen/$1');

// routs grupo
$routes->get('/grupo', 'GrupoController::index');
$routes->get('/grupo/novo', 'GrupoController::create');
$routes->post('/grupo/save', 'GrupoController::save');
$routes->post('/grupo/excluir/(:alphanum)', 'GrupoController::delete/$1');
$routes->get('/grupo/editar/(:alphanum)', 'GrupoController::update/$1');

// rots usuario
$routes->get('/usuario', 'UsuarioController::index');
$routes->get('/usuario/novo', 'UsuarioController::create');
$routes->get('/usuario/editar/(:alphanum)', 'UsuarioController::update/$1');
$routes->post('/usuario/save', 'UsuarioController::save');
$routes->post('/usuario/excluir/(:alphanum)', 'UsuarioController::delete/$1');
$routes->post('/usuario/get-by-email', 'UsuarioController::getByEmail');

// rots paciente
$routes->get('/paciente', 'PacienteController::index');
$routes->get('/paciente/novo', 'PacienteController::create');
$routes->get('/paciente/editar/(:alphanum)', 'PacienteController::update/$1');
$routes->post('/paciente/save', 'PacienteController::save');
$routes->post('paciente/get-by-cpf', 'PacienteController::getByCpf');
$routes->post('/paciente/excluir/(:alphanum)', 'PacienteController::delete/$1');

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
