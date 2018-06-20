<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>GESTION DE ROLE DES UTILISATEURS</h2>
	</div>
	<div class="col-lg-12">
		Flash
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
	<div class="row">
		<div class="col-md-10">
			<a href="index.php?module=admin.roles.index" type="submit" class="btn btn-sm btn-primary">ACTUALISE LA PAGE APRES LA RECHERCHE</a>
			<form method="role" class="pull-right mail-search">
				<div class="input-group">
					<input type="text" class="form-control input-sm"
						   name="query" placeholder="Nom ou la categorie">
					<div class="input-group-btn">
						<input type="submit" class="btn btn-sm btn-primary" value="Rechercher">
					</div>
				</div>
			</form>
		</div>
	</div><br>
	<div class="row">
		<div class="col-lg-12">
			<h1><?php echo $count. " Resultat(s)"; ?></h1>
		</div>
	</div>
	<div class="wrapper wrapper-content animated fadeInRight ecommerce">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-content">
					<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
						<thead>
						<tr>
							<th>#</th>
							<th data-hide="phone,tablet" >Nom</th>
							<th data-hide="phone,tablet" >Ecris Par</th>
							<th class="text-right">Action</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($roles as $role): ?>
							<tr>
								<td><?= $role['id'] ?></td>
								<td><?= $role['nom'] ?></td>
								<td><?= $role['utilisateur'] ?></td>
								<td class="text-right">
									<div class="btn-group">
										<a href="index.php?page=admin.roles.view&id=<?= $role['id']?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Voir</a>
										<a href="index.php?module=admin.roles.edit&id=<?= $role['id'] ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a>
										<form action="index.php?module=admin.roles.delete" style="display: inline;" method="role">
											<input type="hidden" name="id" value="<?= $role['id'] ?>">
											<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Etes vous sur de supprimer ?')"><i class="fa fa-trash"></i>Supprimer</button>
										</form>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>

				</div>
			</div>
			Nav
		</div>
	</div></div></div></div>