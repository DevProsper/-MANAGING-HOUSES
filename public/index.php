<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
use App\Controller\Admin\TypesController;
use App\Controller\PostsController;
use App\Controller\UsersController;

define('ROOT', dirname(__DIR__));
require '../app/App.php';
require '../config/includes.php';
require ROOT . '/config/includes.php';
App::load();
if (isset($_GET['module'])) {
	$module = $_GET['module'];
}else{
	$module = 'home';
}
/*$page = explode('.', $page);
if ($page[0] == 'admin') {
	$controller = '\App\Controller\Admin\\' .ucfirst($page[1]) . 'Controller';
	$action = $page[2];
}else{
	$controller = '\App\Controller\\' .ucfirst($page[0] . 'Controller');
	$action = $page[1];
}
$controller = new $controller();
$controller->$action();*/
/*if ($page === 'home') {
	$controller = new PostsController();
	$controller->test();
}*/
switch($module){
	//FRONT END
	case 'home':
		$controller = new PostsController();
		$controller->index();
		break;
	case 'posts.category':
		$controller = new PostsController();
		$controller->category();
		break;
	case 'posts.show':
		$controller = new PostsController();
		$controller->show();
		break;


	//AUTHENTIFICATION
	case 'login':
		$controller = new UsersController();
		$controller->login();
		break;
	case 'logout':
		$controller = new UsersController();
		$controller->logout();
		break;
	case 'users.forget':
		$controller = new UsersController();
		$controller->forgetPassword();
		break;
	case 'users.reset':
		$controller = new UsersController();
		$controller->resetPassword();
		break;

	/////////////////////////////////////////
	//	ADMINISTRATION					  //
	///////////////////////////////////////


	//GESTION DES UTILISATEURS
	case 'admin.utilisateurs.index':
		$controller = new \App\Controller\Admin\UtilisateursController();
		$controller->index();
		break;
	case 'admin.utilisateurs.add':
		$controller = new \App\Controller\Admin\UtilisateursController();
		$controller->add();
		break;
	case 'admin.utilisateurs.edit':
		$controller = new \App\Controller\Admin\UtilisateursController();
		$controller->edit();
		break;
	case 'admin.utilisateurs.delete':
		$controller = new \App\Controller\Admin\UtilisateursController();
		$controller->delete();
		break;

		//GESTION DES ADMINISTRATEURS
	case 'admin.admins.index':
		$controller = new \App\Controller\Admin\AdministrateursController();
		$controller->index();
		break;
	case 'admin.admins.add':
		$controller = new \App\Controller\Admin\AdministrateursController();
		$controller->add();
		break;
	case 'admin.admins.edit':
		$controller = new \App\Controller\Admin\AdministrateursController();
		$controller->edit();
		break;
	case 'admin.admins.delete':
		$controller = new \App\Controller\Admin\AdministrateursController();
		$controller->delete();
		break;


		//GESTION DES AGENCES
	case 'admin.agences.index':
		$controller = new \App\Controller\Admin\AgencesController();
		$controller->index();
		break;
	case 'admin.agences.add':
		$controller = new \App\Controller\Admin\AgencesController();
		$controller->add();
		break;
	case 'admin.agences.edit':
		$controller = new \App\Controller\Admin\AgencesController();
		$controller->edit();
		break;
	case 'admin.agences.delete':
		$controller = new \App\Controller\Admin\AgencesController();
		$controller->delete();
		break;

		//GESTION DES PROPRIETAIRES
	case 'admin.proprietaires.index':
		$controller = new \App\Controller\Admin\ProprietairesController();
		$controller->index();
		break;
	case 'admin.proprietaires.add':
		$controller = new \App\Controller\Admin\ProprietairesController();
		$controller->add();
		break;
	case 'admin.proprietaires.edit':
		$controller = new \App\Controller\Admin\ProprietairesController();
		$controller->edit();
		break;
	case 'admin.proprietaires.delete':
		$controller = new \App\Controller\Admin\ProprietairesController();
		$controller->delete();
		break;


	//GESTION DES POSTS
	case 'admin.posts.index':
		$controller = new \App\Controller\Admin\PostsController();
		$controller->index();
		break;
	case 'admin.posts.edit':
		$controller = new \App\Controller\Admin\PostsController();
		$controller->edit();
		break;
	case 'admin.posts.add':
		$controller = new \App\Controller\Admin\PostsController();
		$controller->add();
		break;
	case 'admin.posts.add2':
		$controller = new \App\Controller\Admin\PostsController();
		$controller->addAjax();
		break;
	case 'admin.posts.delete':
		$controller = new \App\Controller\Admin\PostsController();
		$controller->delete();
		break;
	case 'admin.posts.excel':
		$controller = new \App\Controller\Admin\PostsController();
		$controller->export();
		break;


	//GESTION DES CATEGORIES
	case 'admin.categories.index':
		$controller = new \App\Controller\Admin\CategoriesController();
		$controller->index();
		break;
	case 'admin.categories.edit':
		$controller = new \App\Controller\Admin\CategoriesController();
		$controller->edit();
		break;
	case 'admin.categories.add':
		$controller = new \App\Controller\Admin\CategoriesController();
		$controller->add();
		break;
	case 'admin.categories.delete':
		$controller = new \App\Controller\Admin\CategoriesController();
		$controller->delete();
		break;


	//GESTION D'ARRONDISSEMENT
	case 'admin.arrond.index':
		$controller = new \App\Controller\Admin\ArrondissementsController();
		$controller->index();
		break;
	case 'admin.arrond.edit':
		$controller = new \App\Controller\Admin\ArrondissementsController();
		$controller->edit();
		break;
	case 'admin.arrond.add':
		$controller = new \App\Controller\Admin\ArrondissementsController();
		$controller->add();
		break;
	case 'admin.arrond.delete':
		$controller = new \App\Controller\Admin\ArrondissementsController();
		$controller->delete();
		break;

	//GESTION DE TYPES DE BIEN
	case 'admin.types_bien.index':
		$controller = new TypesController();
		$controller->index();
		break;
	case 'admin.types_bien.add':
		$controller = new TypesController();
		$controller->add();
		break;
	case 'admin.types_bien.edit':
		$controller = new TypesController();
		$controller->edit();
		break;
	case 'admin.types_bien.delete':
		$controller = new TypesController();
		$controller->delete();
		break;

	//GESTION DE ROLES
	case 'admin.roles.index':
		$controller = new \App\Controller\Admin\RolesController();
		$controller->index();
		break;
	case 'admin.roles.add':
		$controller = new \App\Controller\Admin\RolesController();
		$controller->add();
		break;
	case 'admin.roles.edit':
		$controller = new \App\Controller\Admin\RolesController();
		$controller->edit();
		break;
	case 'admin.roles.delete':
		$controller = new \App\Controller\Admin\RolesController();
		$controller->delete();
		break;

	//GESTION DES VILLES
	case 'admin.villes.index':
		$controller = new \App\Controller\Admin\VillesController();
		$controller->index();
		break;
	case 'admin.villes.add':
		$controller = new \App\Controller\Admin\VillesController();
		$controller->add();
		break;
	case 'admin.villes.edit':
		$controller = new \App\Controller\Admin\VillesController();
		$controller->edit();
		break;
	case 'admin.villes.delete':
		$controller = new \App\Controller\Admin\VillesController();
		$controller->delete();
		break;

	//GESTION DES QUARTIERX
	case 'admin.quartiers.index':
		$controller = new \App\Controller\Admin\QuartiersController();
		$controller->index();
		break;
	case 'admin.quartiers.add':
		$controller = new \App\Controller\Admin\QuartiersController();
		$controller->add();
		break;
	case 'admin.quartiers.edit':
		$controller = new \App\Controller\Admin\QuartiersController();
		$controller->edit();
		break;
	case 'admin.quartiers.delete':
		$controller = new \App\Controller\Admin\QuartiersController();
		$controller->delete();
		break;

	//GESTION DES PIECES
	case 'admin.pieces.index':
		$controller = new \App\Controller\Admin\PiecesController();
		$controller->index();
		break;
	case 'admin.pieces.add':
		$controller = new \App\Controller\Admin\PiecesController();
		$controller->add();
		break;
	case 'admin.pieces.edit':
		$controller = new \App\Controller\Admin\PiecesController();
		$controller->edit();
		break;
	case 'admin.pieces.delete':
		$controller = new \App\Controller\Admin\PiecesController();
		$controller->delete();
		break;

	//GESTION DES STATUTS
	case 'admin.statuts.index':
		$controller = new \App\Controller\Admin\StatutsController();
		$controller->index();
		break;
	case 'admin.statuts.add':
		$controller = new \App\Controller\Admin\StatutsController();
		$controller->add();
		break;
	case 'admin.statuts.edit':
		$controller = new \App\Controller\Admin\StatutsController();
		$controller->edit();
		break;
	case 'admin.statuts.delete':
		$controller = new \App\Controller\Admin\StatutsController();
		$controller->delete();
		break;

	/////////////////////////////////////////
	//			FIN ADMINISTRATION		//
	///////////////////////////////////////


	default:
		$controller = new \App\Controller\AppController();
		$controller->notFound();
		break;
}