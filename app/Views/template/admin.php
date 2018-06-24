<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Immobilière | Administration</title>

	<link href="public/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="public/admin/css/bootstrap.min.css" rel="stylesheet">
	<link href="public/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
	<link href="public/admin/css/plugins/summernote/summernote.css" rel="stylesheet">
	<link href="public/admin/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

	<script type="text/javascript" src="public/js/jquery.min.js"></script>
	<script type="text/javascript" src="public/js/js.js"></script>


	<!-- Toastr style -->

	<!-- Gritter -->
	<link href="public/admin/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

	<link href="public/admin/css/animate.css" rel="stylesheet">
	<link href="public/admin/css/style.css" rel="stylesheet">

</head>

<body>
<div id="wrapper">

	<nav class="navbar-default navbar-static-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav metismenu" id="side-menu">
				<li class="nav-header">
					<div class="dropdown profile-element"> <span>
							 </span>
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= $_SESSION['auth']->prenom; ?> - <?= $_SESSION['auth']->nom; ?></strong>
							 </span> <span class="text-muted text-xs block">Aller <b class="caret"></b></span> </span> </a>
						<ul class="dropdown-menu animated fadeInRight m-t-xs">
							<li><a href="<?= URL_ADMIN  ?>utilisateurs.profile">Profile</a></li>
							<li><a href="<?= URL_HOME  ?>">Sur le site</a></li>
							<li class="divider"></li>
							<li><a href="<?= URL_ADMIN  ?>logout">Déconnexion</a></li>
						</ul>
					</div>
					<div class="logo-element">
						IN+
					</div>
				</li>
				<li class="active">
					<a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Tableau de bord</span> <span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="dashboard_2.html">Statistique des agences</a></li>
					</ul>
				</li>
				<li class="">
					<a href="<?= URL_ADMIN  ?>posts.index"><i class="fa fa-th-large"></i> <span class="nav-label">Gestion des Biens</span></span></a>
				</li>
				<li class="">
					<a href="<?= URL_ADMIN  ?>utilisateurs.index"><i class="fa fa-th-large"></i> <span class="nav-label">Gestion des Utilisateurs</span></span></a>
				</li>
				<li class="">
					<a href="<?= URL_ADMIN  ?>commandes.index"><i class="fa fa-th-large"></i> <span class="nav-label">Gestion d.. Commandes</span></span></a>
				</li>
				<li class="">
					<a href="<?= URL_ADMIN  ?>admins.index"><i class="fa fa-th-large"></i> <span class="nav-label">Administrateurs du site</span></span></a>
				</li>
				<li class="">
					<a href="<?= URL_ADMIN  ?>agences.index"><i class="fa fa-th-large"></i> <span class="nav-label">Gestion des Agences</span></span></a>
				</li>
				<li class="">
					<a href="<?= URL_ADMIN  ?>proprietaires.index"><i class="fa fa-th-large"></i> <span class="nav-label">Gestion d.. Proprietaires</span></span></a>
				</li>
				<li class="">
					<a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Paramètre</span> <span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
                        <li><a href="<?= URL_ADMIN  ?>arrond.index">Arrondissement</a></li>
                        <li><a href="<?= URL_ADMIN  ?>categories.index">Categorie des biens</a></li>
                        <li><a href="<?= URL_ADMIN  ?>pieces.index">Nombre de Pièce</a></li>
                        <li><a href="<?= URL_ADMIN  ?>villes.index">Gestion des Villes</a></li>
                        <li><a href="<?= URL_ADMIN  ?>quartiers.index">Gestion des Quartiers</a></li>
                        <li><a href="<?= URL_ADMIN  ?>roles.index">Gestion de Role</a></li>
						<li><a href="<?= URL_ADMIN  ?>types_bien.index">Gestion de Type de bien</a></li>
						<li><a href="<?= URL_ADMIN  ?>statuts.index">Gestion des Etats</a></li>
					</ul>
				</li>
				<li class="">
					<a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Configuration</span> <span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
                        <li><a href="<?= URL_ADMIN  ?>arrond.index">Pagination</a></li>
					</ul>
				</li>
			</ul>

		</div>
	</nav>

	<div id="page-wrapper" class="gray-bg dashbard-1">
		<div class="row border-bottom">
			<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
				</div>


			</nav>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?= $content; ?>


				<div class="footer">
					<div class="pull-right">
						prosperngouari38@gmail.com <strong> | +242-06-428-98-39  </strong>
					</div>
					<div>
						Copyright Tout droit réservés &copy;
						<?php
						$copyYear = 2017;
						$curYear = date('Y');
						echo $copyYear . (($copyYear != $curYear) ? '-' .$curYear : '');
						?> |
						Veillez contactez l'administrateur pour un besoin quelconque
					</div>
				</div>
			</div>
		</div>


			</div>

		</div>
	</div>

</div>



</div>
</div>

<!-- Mainly scripts -->
	<script src="public/admin/js/jquery-3.1.1.min.js"></script>
	<script src="public/admin/js/bootstrap.min.js"></script>
	<script src="public/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="public/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- SUMMERNOTE -->
	<script src="public/admin/js/plugins/summernote/summernote.min.js"></script>

	<!-- Flot -->
	<script src="public/admin/js/plugins/flot/jquery.flot.js"></script>
	<script src="public/admin/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script src="public/admin/js/plugins/flot/jquery.flot.spline.js"></script>
	<script src="public/admin/js/plugins/flot/jquery.flot.resize.js"></script>
	<script src="public/admin/js/plugins/flot/jquery.flot.pie.js"></script>
	<script src="public/admin/js/app.js"></script>

	<!-- Peity -->
	<script src="public/admin/js/plugins/peity/jquery.peity.min.js"></script>
	<script src="public/admin/js/demo/peity-demo.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="public/admin/js/plugins/pace/pace.min.js"></script>

	<!-- jQuery UI -->
	<script src="public/admin/js/plugins/jquery-ui/jquery-ui.min.js"></script>

	<!-- GITTER -->
	<script src="public/admin/js/plugins/gritter/jquery.gritter.min.js"></script>
	
	<!-- Sparkline -->
	<script src="public/admin/js/plugins/sparkline/jquery.sparkline.min.js"></script>

	<!-- Sparkline demo data  -->
	<script src="public/admin/js/demo/sparkline-demo.js"></script>

	<!-- ChartJS-->
	<script src="public/admin/js/plugins/chartJs/Chart.min.js"></script>

	<!-- Toastr -->
	<script src="public/admin/js/plugins/toastr/toastr.min.js"></script>

	<!-- iCheck -->
	<script src="public/admin/js/plugins/iCheck/icheck.min.js"></script>

	<!-- SUMMERNOTE -->
	<script src="public/admin/js/plugins/summernote/summernote.min.js"></script>    
	<script>
		$(document).ready(function(){

			$('.summernote').summernote();

		});

	</script>
</body>

</html>
