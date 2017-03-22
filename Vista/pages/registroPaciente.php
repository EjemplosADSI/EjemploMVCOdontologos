<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inicio</title>

    <?php include ("includes/imports.php"); ?>

</head>

<body>

    <div id="wrapper">

    <?php include ("includes/barra-navegacion.php"); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Registro Paciente</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Datos Basicos del Paciente
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div id="alertas">
                                    <?php if(!empty($_GET["respuesta"]) && $_GET["respuesta"] == "correcto"){ ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            La informacion del paciente se ha registrado correctamente. Puede administrar los pacientes desde <a href="adminPacientes.php" class="alert-link">Aqui</a> .
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($_GET["respuesta"]) && $_GET["respuesta"] == "error"){ ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            No se pudo registrar al paciente. <a href="#" class="alert-link">Error: <?php echo $_GET["Mensaje"] ?></a> .
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="col-lg-12">
                                    <form role="form" data-toggle="validator" method="post" action="../../Controlador/pacienteController.php?action=crear">
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input required data-toggle="tooltip" title="Sin Signos de puntuación o caracteres especiales" data-placement="top" maxlength="60" id="Nombres" name="Nombres" minlength="2" class="form-control newTooltip" placeholder="Ingrese Sus Nombres Completos">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Apellidos</label>
                                            <input required maxlength="60" id="Apellidos" name="Apellidos" minlength="2" class="form-control" placeholder="Ingrese Sus Apellidos Completos">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Direccion</label>
                                            <input required maxlength="60" id="Direccion" name="Direccion" minlength="7" class="form-control" placeholder="Ingrese su direccion de residencia">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo Documento</label>
                                            <select required id="TipoDocumento" name="TipoDocumento" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="C.C">Cedula de Ciudadania</option>
                                                <option value="T.I">Tarjeta de Identidad</option>
                                                <option value="C.E">Cedula de Extranjeria</option>
                                                <option value="RegistroCivil">Registro Civil</option>
                                                <option value="RUT">Registro Unico Tributario</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>Documento</label>
                                            <input type="number" required max="3000000000" min="1000000" maxlength="12" id="Documento" name="Documento" minlength="7" class="form-control" placeholder="Ingrese Documento Completo">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">@</span>
                                                <input type="email" required maxlength="45" id="Email" name="Email" minlength="7" class="form-control" placeholder="Ingrese su correo electronico">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>Genero</label>
                                            <select required id="Genero" name="Genero" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Indefinido">Indefinido</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>User</label>
                                            <input required maxlength="20" id="User" name="User" minlength="7" class="form-control" placeholder="Ingrese su Usuario de Acceso">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Password" class="control-label">Password</label>
                                            <div class="form-inline row">
                                                <div class="form-group col-sm-3">
                                                    <input type="password" data-minlength="6" class="form-control" id="Password" placeholder="Contraseña de Acceso " required>
                                                    <div class="help-block">Minimo 6 caracteres</div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <input type="password" class="form-control" id="inputPasswordConfirm" data-match="#Password" data-match-error="Las Contraseñas no Coinciden" placeholder="Confirmar Contraseña" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                        <button type="reset" class="btn btn-warning">Cancelar</button>


                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    
    <?php include ("includes/includes-footer.php"); ?>

</body>

</html>
