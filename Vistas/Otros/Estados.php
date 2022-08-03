<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">    
    <link rel="icon" href="../../Imagenes/Logo.png">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/medical.css">
    <title>Medical Assistent - Estados</title>
</head>
<body>
<?php
        session_start();
        if(isset($_SESSION["Usuario"]))
        {
            $date= date('Y-m-d');
            if (($_SESSION["FechaActivo"] > $date) && ($_SESSION["Estatus"] == 'Activo'))
            {
    ?>
        <?php
            include '../../Database/Database.php';
            $db=new Database();
            $db->ConectarDB();

            $Query="SELECT * FROM usuarios WHERE Usuario = '".$_SESSION["Usuario"]."'";
            $reg = $db->Selects($Query);
            foreach($reg as $valor)
            {
                switch($valor->TipoUsuario)
                {
                    case 'Admin':
                        require '../../Plantillas/Headers/Admins/HeaderAdmins2.php';
                        ?>
                        <div class="container">
                        <h1>Estados</h1>
        <form action="Estados.php" method="GET">
            <?php
                $db = new database();
                $db->ConectarDB();
                $Cadena = "SELECT Id_Pais, Pais FROM paises";
                $reg = $db->Selects($Cadena);
                echo "  <div class='row align-items-start'>
                            <div class='col-1'>
                                <label class='class-label'>Filtrar por:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtro'>
                                    <option value='10'selected>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='100'>100</option>
                                    <option value='All'>Todos</option>
                                </select>
                            </div>
                            <div class='col-4'>
                                    <label class='class-label'>País:</label>
                                    <select class='form-control' name='paises'>";
                                    foreach($reg as $value)
                                    {
                                        echo "<option value='".$value->Id_Pais."'>".$value->Pais."</option>";
                                    }
                                    echo "</select>
                                </div>
                            <div class='col-1'>
                                <br>
                                <button type='submit' class='btn btn-secondary'>Ver</button>
                            </div>
                        </div>";
                    $db->DesconectarDB();
                ?>
        </form>
        <br>
        <?php
        if($_GET)
        {
            extract($_GET);
            $conexion = new Database();
            $conexion->ConectarDB();
            
            if($filtro == "All")
            {
                $Query = "SELECT * FROM estados e JOIN paises p ON p.Id_Pais = e.Id_Pais WHERE e.Id_Pais = '$paises' limit 100000000000000 ;";
            }
            else
            {
                $Query = "SELECT * FROM estados e JOIN paises p ON p.Id_Pais = e.Id_Pais WHERE e.Id_Pais = '$paises' limit $filtro ;";
            }

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaEstados' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Estado</th>
                                <th>Nombre</th>
                                <th>País</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormEstados.php' method='GET'>                        
                            <td name='MyTable'>
                                <input type='hidden' name='Id_Estado' value='$registro->Id_Estado'>$registro->Id_Estado</td>
                            </td>
                            <td class='col'>$registro->Estado</td>
                            <td class='col'>$registro->Pais</td>
                            <td class='col-3'>
                                <button name='btned' type='submit' class='btn btn-outline-warning' value='Editar'>Editar</button>
                                <button name='btne' type='submit' class='btn btn-outline-danger' value='Eliminar'>Eliminar</button>
                            </td>
                            </form>
                        </tr>";
            }
                    echo "</tbody>
                        </table>";
            $conexion->DesconectarDB();
        }   
        ?>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Nuevo">Nuevo Estado</button>
        </div>
        <br>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <!--INSERT-->
    <div class="modal fade" id="NuevoEstado" tabindex="-1" aria-labelledby="NuevoEstadoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="NuevoEstado">Nuevo Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="GET">
                        <div class="mb-3 w-100">
                            <label for="estado">Estado:</label>
                            <input type="text" name="estado" placeholder="Escriba el Nombre del Estado" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                        <?php
                            $db1 = new database();
                            $db1->ConectarDB();
                            $Cadena1 = "SELECT Id_Pais, Pais FROM paises";
                            $reg1 = $db1->Selects($Cadena);
                            echo "  <div class='mb-3 w-100'>
                                        <label class='class-label'>País:</label>
                                        <select name='idpais' class='form-select' required>";
                            foreach($reg1 as $value1)
                            {
                                echo "      <option value='".$value1->Id_Pais."'>".$value1->Pais."</option>";
                            }
                            echo "      </select>";
                            $db1->DesconectarDB();
                        ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <?php
                    if($_GET)
                    {
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_GET);
                        $query = "INSERT INTO estados(Estado, Id_Pais, FUM) VALUES('$estado', $idpais, NOW())";
                        $db2->Insert($query);
                        echo "<div class='alert alert-success'>Estado Registrado</div>";
                        header("refresh:1; Estados.php");
                        $db2->DesconectarDB();
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
                    break;
                    default:
                        echo "<script> setTimeout(function() { window.location = '../NoAutorizado.php'; }, 10); </script>";
                    break;
                }
            }
        ?>
    <?php
        }
        else
        {
            ?>
            <?php echo "<script> setTimeout(function() { window.location = '../FechaNoValida.php'; }, 0); </script>";
            
        }}
        else
        {
            ?>
            <?php require '../Plantillas/Headers/HeaderIndexLogin.php' ?>
            <?php
        }
    ?>    
</body>
</html>