<?php
//Autor: Cristian Rivera. 15/03/23
//Proyecto supervisorio sistema de paletizado.
//Hoja de logica.

//relación estilos de bootstrap.
echo '<link rel="stylesheet" href="css/bootstrap.min.css" class="rel"> ';
//relación estilos propios.
echo '<link rel="stylesheet" href="css/styles.css" class="rel"> ';

class Datos
{

    static function obtencionCodigos()
    {
        $testigo = false;
        // En este código, estamos incluyendo el archivo conexion.php y 
        // luego llamando al método estático conexionBD() de la clase Conexion para establecer 
        // la conexión y almacenarla en la variable $conn.
        require_once('conexion.php');
        $conn = Conexion::conexionBD();
        //Estamento de configuración de linea
        $stmt1 = $conn->prepare("SELECT * FROM CONFIGURACION_LINEA ORDER BY LINEA ASC;");
        $stmt1->execute();
        $resultConfLin = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        //$datos = array_combine($resultConfLin,$resultEst);
        //Estamento para sumatoria de pallets
        $stmt2 = $conn->prepare("SELECT 
        cl.LINEA, 
        COUNT( pg.LINEA_PALLETS) AS cant_pallets, SUM(pg.NUM_PAQUETES) AS cant_fardos FROM configuracion_linea cl 
        LEFT JOIN pallets_generados pg ON cl.LINEA = pg.LINEA_PALLETS  WHERE  pg.FECHA_HORA >= cl.FECHA_HORA_INICIO GROUP BY cl.LINEA;");
        $stmt2->execute();
        $resultCantPallets = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        //Control de rowspan con datos linea tiempo real
        $stmt4 = $conn->prepare("SELECT LINEA, ESTADO FROM DATOS_LINEA_TIEMPO_REAL ORDER BY LINEA ASC;");
        $stmt4->execute();
        $resultEstLineas = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        $k001 = 0;
        $k002 = 0;
        $k003 = 0;
        $k004 = 0;
        foreach ($resultEstLineas as $line) {
            //Estado. 1 producto asignado 2 libre.
            $lineaAct = $line['ESTADO'];
            $lineaPro = $line['LINEA'];
            if ($lineaPro >= 1 && $lineaPro <= 3 && $lineaAct == 1) {
                $k002++;
            } else if ($lineaPro >= 4 && $lineaPro <= 6 && $lineaAct == 1) {
                $k001++;
            } else if ($lineaPro >= 7 && $lineaPro <= 9 && $lineaAct == 1) {
                $k003++;
            } else if ($lineaPro >= 10 && $lineaPro <= 12 && $lineaAct == 1) {
                $k004++;
            }
        }
        // echo "VALIDACIÓN KOO1 " . $k001 . "<br>";
        // echo "VALIDACIÓN KOO2 " . $k002 . "<br>";
        // echo "VALIDACIÓN KOO3 " . $k003 . "<br>";
        // echo "VALIDACIÓN KOO4 " . $k004 . "<br>";
        //Titulos tabla
        echo "<table class ='table table-hover my-auto table-responsive'>";
        echo "<tr><th colspan=8 class='text-center fs-3'>PASTA LARGA</th></tr>";
        //echo "<caption>ASIGNACIÓN DE PRODUCTOS SISTEMA DE PALETIZADO</caption>";
        echo
        "<tr>
        <th scope='col'class= 'text-center align-middle p-2'>Robot</th>
        <th scope='col'class= 'text-center align-middle p-2'>Salida</th>
        <th scope='col'class= 'text-center align-middle p-2' >Máquina</th>
        <th scope='col'class= 'text-center align-middle p-2'>Referencia</th>
        <th scope='col'class= 'text-center align-middle p-2'>Descripción</th>
        <th scope='col'class= 'text-center align-middle p-2''>Inicio <br> producción</th>
        <th scope='col'class= 'text-center align-middle p-2'>Cant. pallets <br> generados</th>
        <th scope='col'class= 'text-center align-middle p-2'>Cant. fardos <br> generados</th>
        </tr>";

        //logica para resultado de configuración de linea
        foreach ($resultConfLin as $confi) {

            //se procesa para separar el codigo de la maquina.
            $codigo = substr($confi['PRODUCTO'], 0, 3);

            //se procesa para obtener la maquina
            $maquina = substr($confi['PRODUCTO'], 3, 1);

            //almacenar hora de inicio
            $inicioFecha = substr($confi["FECHA_HORA_INICIO"], 0, 10);
            $inicioHora  = substr($confi["FECHA_HORA_INICIO"], 10, 9);

            //se cambia valor de salidas a maquinas de empaque
            if ($maquina == 1) {
                $maquina = 2;
            } else if ($maquina == 2) {
                $maquina = 3;
            } else if ($maquina == 3) {
                $maquina = 4;
            } else if ($maquina == 4) {
                $maquina = 5;
            } else if ($maquina == 5) {
                $maquina = 6;
            } else if ($maquina == 6) {
                $maquina = 'ENC';
            } else if ($maquina == 'H') {
                $maquina = 17;
            } else if ($maquina == 'I') {
                $maquina = 18;
            } else if ($maquina == 'J') {
                $maquina = 19;
            } else if ($maquina == 'K') {
                $maquina = 20;
            } else if ($maquina == 'L') {
                $maquina = 21;
            } else if ($maquina == 'M') {
                $maquina = 'ENC';
            }

            //se almacena línea y se da formato de lineas segun los robots
            $linea = $confi["LINEA"];
            if ($linea == 7) {
                $linea = 11;
            } else if ($linea == 8) {
                $linea = 12;
            } else if ($linea == 9) {
                $linea = 13;
            } else if ($linea == 10) {
                $linea = 14;
            } else if ($linea == 11) {
                $linea = 15;
            } else if ($linea == 12) {
                $linea = 16;
            } else if ($linea == 8) {
                $linea = 12;
            }

            //Configuración para mostrar el robot.
            $robot;
            if ($linea <= 3 && $linea >= 1) {
                $robot = 'K002';
            } else if ($linea >= 4 && $linea <= 6) {
                $robot = 'K001';
            } else if ($linea >= 11 && $linea < 13) {
                $robot = 'K003';
            } else if ($linea >= 14) {
                $robot = 'K004';
            }

            //logica almacenado de datos sumatoria de pallets
            foreach ($resultCantPallets as $cant) {
                //almacen de lineas
                $lineaCantPallets = $cant['LINEA'];
                //se da formato de lineas segun los robots
                if ($lineaCantPallets == 7) {
                    $lineaCantPallets = 11;
                } else if ($lineaCantPallets == 8) {
                    $lineaCantPallets = 12;
                } else if ($lineaCantPallets == 9) {
                    $lineaCantPallets = 13;
                } else if ($lineaCantPallets == 10) {
                    $lineaCantPallets = 14;
                } else if ($lineaCantPallets == 11) {
                    $lineaCantPallets = 15;
                } else if ($lineaCantPallets == 12) {
                    $lineaCantPallets = 16;
                } else if ($lineaCantPallets == 8) {
                    $lineaCantPallets = 12;
                }

                $totalPallets = 0;
                $totalFardos = 0;
                //se iguala lineas, dependiendo de la linea asiganda a  la linea de sumatoria.
                if ($cant['LINEA'] == $confi['LINEA']) {
                    $totalPallets = $cant['cant_pallets'];
                    $totalFardos = $cant['cant_fardos'];
                    break;
                }
            }

            //se obtiene la información de producto según lo programado
            $stmt3 = $conn->prepare("SELECT * FROM RopProductos WHERE CodigoBarras = $codigo;");
            $stmt3->execute();
            $resultRopProd = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            //Se imprimen todos los resultados una vez se tenga la descripción del producto
            foreach ($resultRopProd as $fila) {
                //Se imprime pasta larga
                $tipoPasta = $fila["TipoPasta"];
                if ($tipoPasta != 'Corta') {
                    echo "<tr>";
                    if ($linea ==1) {
                        echo "<td rowspan=" . $k002 . " class= 'text-center align-middle'>" . $robot . "</td>";
                    } else if ($linea == 4) {
                        echo "<td rowspan=" . $k001 . " class= 'text-center align-middle'>" . $robot . "</td>";
                    }
                    echo "<td class= 'text-center align-middle'>" . $linea . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $maquina . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $fila['Referencia'] . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $fila["Descripcion"] . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $inicioFecha . " - " . $inicioHora . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $totalPallets . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $totalFardos . "</td>";
                    echo "</tr>";
                }
                //se imprime encabezado de PC. Es necesario imprimir de nuevo, ya que el sistema cuenta como si hubiera
                // impreso la maquina 11
                else if ($tipoPasta == 'Corta' && $testigo == false) {
                    // echo "</table>";
                    // echo "<table class ='table table-hover my-auto table-responsive'>";
                    echo "<tr><th colspan=8 class='text-center fs-3'>PASTA CORTA</th></tr>";
                    echo
                    "<tr>
                    <th scope='col'class= 'text-center align-middle p-2'>Robot</th>
                    <th scope='col'class= 'text-center align-middle p-2'>Salida</th>
                    <th scope='col'class= 'text-center align-middle p-2' >Máquina</th>
                    <th scope='col'class= 'text-center align-middle p-2'>Referencia</th>
                    <th scope='col'class= 'text-center align-middle p-2'>Descripción</th>
                    <th scope='col'class= 'text-center align-middle p-2''>Inicio <br> producción</th>
                    <th scope='col'class= 'text-center align-middle p-2'>Cant. pallets <br> generados</th>
                    <th scope='col'class= 'text-center align-middle p-2'>Cant. fardos <br> generados</th>
                    </tr>";
                    echo "<tr>";
                    echo "<td rowspan=" . $k003 . " class= 'text-center align-middle'>" . $robot . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $linea . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $maquina . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $fila['Referencia'] . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $fila["Descripcion"] . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $inicioFecha . " - " . $inicioHora . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $totalPallets . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $totalFardos . "</td>";
                    echo "</tr>";
                    $testigo = true;
                } else {
                    echo "<tr>";
                    if($linea == 14){
                        echo "<td rowspan=" . $k004 . " class= 'text-center align-middle'>" . $robot . "</td>";
                    }
                    echo "<td class= 'text-center align-middle'>" . $linea . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $maquina . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $fila['Referencia'] . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $fila["Descripcion"] . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $inicioFecha . " - " . $inicioHora . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $totalPallets . "</td>";
                    echo "<td class= 'text-center align-middle'>" . $totalFardos . "</td>";
                    echo "</tr>";
                }
            }
        }
        echo "</table>";
    }
}
//relación con ficheros de jS
echo '<script src="js/bootstrap.bundle.min.js"></script>';
echo '<script src="css/styles.css"></script>';
