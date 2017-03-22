<?php require ("includes/verificarSession.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Sistema Odontologico</title>

    <?php include ("includes/imports.php"); ?>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inicio de Sesión</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <form data-toggle="validator" role="form" id="frmLogin" name="frmLogin">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" data-required-error="Debe Ingresar Su Usuario" placeholder="Usuario" name="User" id="User" type="text" autofocus required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Contraseña" name="Password" type="Password" data-required-error="Debe Ingresar Su Contraseña" value="" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Recordarme
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Ingresar</button>
                                </fieldset>
                            </form>
                        </p>
                        <p id="results" name="results">

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ("includes/includes-footer.php"); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#frmLogin').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    var formData = $(this).serialize(); //Serializamos los campos del formulario
                    $.ajax({
                        type        : 'POST', // Metodo de Envio
                        url         : '../../Controlador/pacienteController.php?action=Login', // Ruta del envio
                        data        : formData, // our data object
                        //dataType    : 'json', // what type of data do we expect back from the server
                        encode      : true
                    })
                    .done(function(data) {
                        //console.log(data);
                        if (data == true){
                            window.location.href = "index.php";
                        }else{
                            $('#results').html(data);
                        }
                    });
                    event.preventDefault();
                }
            })
        });
    </script>

</body>

</html>
