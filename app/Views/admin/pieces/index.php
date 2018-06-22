<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>GESTION DE NOMBRE DE PIECE</h2>
	</div>
	<div class="col-lg-12">
		<?= flash(); ?>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
	<div class="row">
		<div class="col-md-10">
			<form method="post" class="pull-right mail-search">
				<div class="input-group">
					<input type="text" class="form-control input-sm"
						   name="query" placeholder="Recherche par nombre">
					<div class="input-group-btn">
						<input type="submit" class="btn btn-sm btn-primary" value="Rechercher">
					</div>
				</div>
			</form>
		</div>
	</div><br>
	<div class="row">
		<div class="col-lg-12">
			<a href="index.php?module=admin.pieces.add" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Ajouter une categorie</a><br><br>
			<div class="ibox">
				<div class="ibox-content">
					<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
						<thead>
						<tr>

							<th>#</th>
							<th data-hide="phone,tablet" >Nombre</th>
							<th data-hide="phone,tablet" >Ecris Par</th>
							<th class="text-right">Action</th>

						</tr>
						</thead>
						<tbody>
						<?php
						while ($pieces = $requette->fetch()) {
							?>
							<tr>
								<td><?= $pieces['id']?></td>
								<td><?= $pieces['nombre']?></td>
								<td><?= $pieces['utilisateur']?></td>
								<td class="text-right">
									<div class="btn-group">
										<a href="index.php?module=admin.pieces.edit&id=<?= $pieces['id']?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Editer</a>
										<form action="index.php?module=admin.pieces.delete" style="display: inline;" method="post">
											<input type="hidden" name="id" value="<?= $pieces['id']?>">
											<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Etes vous sur de supprimer ?')"><i class="fa fa-trash"></i>Supprimer</button>
										</form>
									</div>
								</td>
							</tr>
							<?php
						}
						?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>

				</div>
			</div>
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li>
						<a class="<?php if($current == '1'){ echo "disabled";} ?>" href="index.php?module=admin.pieces.index&p=<?php if($current != '1'){echo $current-1;}else{ echo $current;} ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<?php
					for ($i=1; $i <= $nbPage ; $i++) {
						if ($i == $current) {
							?>
							<li class="paginate-active"><a href="index.php?module=admin.pieces.index&p=<?= $i ?>"><?= $i ?></a></li>
							<?php
						}else{
							?>
							<li><a href="index.php?module=admin.pieces.index&p=<?= $i ?>"><?= $i ?></a></li>
							<?php
						}
					}
					?>

					<li>
						<a class="<?php if($current == '1'){ echo "disabled";} ?>" href="index.php?module=admin.pieces.index&p=<?php if($current != $nbPage){echo $current+1;}else{ echo $nbPage;} ?>" aria-label="Previous">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div></div></div>
