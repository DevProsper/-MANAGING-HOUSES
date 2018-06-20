<!DOCTYPE html PUBLIC>
<head>
    <style>
        /*body { background-color: #0a5656 }*/
        .post-title { font-size:20px; }
        .mtb-margin-top { margin-top: 20px; }
        .top-margin { border-bottom:2px solid #ccc; margin-bottom:20px; display:block; font-size:1.3rem; line-height:1.7rem;}
        .btn-success {
            cursor:pointer;
        }

        label {
            display: block;
            width:100%;
        }

    </style>

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

        <div class="col-xs-12 col-md-sm-6 col-md-3">
            <label>Continent :</label>
            <select name="continent" class="form-control" id="continent">
                <option value=''>------- Select --------</option>

                <?php
                if($count > 0){
                    foreach ($counts as $continent) {
                        echo '<option value="'.$continent['continent_id'].'">'.$continent['continent'].'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-xs-12 col-md-sm-6 col-md-3">
            <label>Country :</label>
            <select name="country" class="form-control" id="country" disabled="disabled"><option>------- Select --------</option></select>
        </div>


        <div class="col-xs-12 col-md-sm-6 col-md-3">
            <label>State / Province / County :</label>
            <select name="state" class="form-control" id="state" disabled="disabled"><option>------- Select --------</option></select>
        </div>


        <div class="col-xs-12 col-md-sm-6 col-md-3">
            <label>City / Popular Place :</label>
            <select name="city" class="form-control" id="city" disabled="disabled"><option>------- Select --------</option></select>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>