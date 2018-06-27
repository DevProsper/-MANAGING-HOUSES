<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EDITER L'UTILISATEUR</h2>
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
                            <form method="post" action="">
                                <div class="form-group">
                                    <?= $form->input('nom', 'Nom'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('prenom', 'Prenom'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('adresse', 'Adresse'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('tel', 'Tel'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('email', 'Email'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('fonction', 'Fonction'); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->input('identite', 'Identite'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_role', 'Role', $role_list); ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->select('id_statut', 'Etat', $etat_list); ?>
                                </div>
                                <div class="input-group-btn">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>