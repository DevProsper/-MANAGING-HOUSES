<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Immobilier | Connexion</title>

    <link href="public/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="public/admin/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="public/admin/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">


    <!-- Toastr style -->

    <!-- Gritter -->
    <link href="public/admin/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="public/admin/css/animate.css" rel="stylesheet">
    <link href="public/admin/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h2><b>MINISTER DE LA SANTE ET DE LA POPULATION</b></h2>
            <?= flash(); ?>
            <?php var_dump($_SESSION['auth']); ?>
        </div>
        <h4><b>Résevervés aux administrateurs</b></h4>
        <form method="post">
            <div class="form-group">
                <label for="email">Votre pseudo</label>
                <div class="form-group">
                    <?= $form->input('email', 'Login'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <?= $form->input('password', 'Mot de passe', ['type' => 'password']); ?>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Se connecter</button>
        </form>
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

</body>
<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7.1/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 05:39:51 GMT -->
</html>
