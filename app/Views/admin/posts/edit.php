<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EDITER LE BIEN</h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php
                    foreach ($errors as $error) {
                        echo $error."<br/>";
                    }
                    ?>
                </div>
            <?php endif ?>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-8 b-r">
                            <form method="post" action=" " enctype="multipart/form-data">
                                <div class="form-group">
                                    <?= $form->input('titre', 'Titre'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('contenu', 'Contenu', ['type' => 'textarea']); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('prix', 'Prix'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_categorie', 'Categories', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_ville', 'Ville', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_arrondissement', 'Arrondissement', $arrondissement_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_quartier', 'Quartier', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('adresse', 'Adresse', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_piece', 'Nombre de piece', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_type_bien', 'Type de bien', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('latitude', 'Latitude'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('longitude', 'Longitude'); ?>
                                </div>
                                <div class="form-group">
                                        <?= $form->select('statut', 'Statut', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_agence', 'Agence', $categories_list); ?>
                                </div>
                                <div class="form-group">
                                    <label>Fichier</label>
                                    <input type="file" name="file_name[]">
                                    <input type="file" name="file_name[]">
                                    <input type="file" name="file_name[]">
                                </div>
                                <div class="input-group-btn">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4 b-r">
                            IMAGES
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>