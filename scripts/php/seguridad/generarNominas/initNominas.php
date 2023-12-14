<?php
include_once "./vendor/autoload.php";
include_once("../mail/sendNominaReady.php");
use Dompdf\Dompdf;

function creaNomina($dataEmpleado)
{
    try {
        //! SEPARAMOS TODOS LOS VALORES
        
        $dni = $dataEmpleado['dni'];
        $nombre = $dataEmpleado['nombre'];
        $apellidos = $dataEmpleado['apellidos'];
        $categoria = $dataEmpleado['categoria'];
        $cantidadTurnos = $dataEmpleado['cantidadTurnos'];
        $sueldo_normal = $dataEmpleado['sueldo_normal'];
        $sueldo_plus = $dataEmpleado['sueldo_plus'];
        $horas_extras = $dataEmpleado['horas_extras'];
        $total_sueldo_n = $dataEmpleado['total_sueldo_normal'];
        $total_sueldo_p = $dataEmpleado['total_sueldo_plus'];
        $total_nomina = $dataEmpleado['total_nomina'];

        $currentDate = date('d-m-Y');

        $nombreDelDocumento = date('M') . "_" . $dni . ".pdf";
        $rutaDelDocumento = "../nominas/" . $dni . "/" . date('Y') . "/" . $nombreDelDocumento;

        if (!file_exists($rutaDelDocumento)) {

            
            $dompdf = new Dompdf();

            // INICIALIZAMOS EL BUFFER DE SALIDA
            ob_start();

            // PLANTILLA HTML
            $html = <<<HTML
                    <!DOCTYPE html>
                    <html lang='es'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Nómina</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                            }

                            .nomina {
                                max-width: 600px;
                                margin: 20px auto;
                                border: 1px solid #ccc;
                                padding: 20px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }

                            .encabezado {
                                text-align: center;
                                font-size: 24px;
                                font-weight: bold;
                                margin-bottom: 20px;
                            }

                            .detalle {
                                margin-bottom: 10px;
                            }

                            .detalle label {
                                display: inline-block;
                                width: 150px;
                                font-weight: bold;
                            }
                        </style>
                    </head>
                    <body>

                        <div class='nomina'>
                            <div class='encabezado'>
                                Nómina de {$nombre}
                            </div>

                            <div class='detalle'>
                                <label>Fecha:</label>
                                {$currentDate} <!-- Puedes ajustar el formato de fecha según tus preferencias -->
                            </div>

                            <div class='detalle'>
                                <label>DNI:</label>
                                {$dni}
                            </div>

                            <div class='detalle'>
                                <label>Categoría:</label>
                                {$categoria}
                            </div>

                            <div class='detalle'>
                                <label>Cantidad turnos:</label>
                                {$cantidadTurnos}
                            </div>

                            <div class='detalle'>
                                <label>Sueldo Base:</label>
                                {$sueldo_normal} euros/turno
                            </div>

                            <div class='detalle'>
                                <label>Horas Extras:</label>
                                {$horas_extras} horas
                            </div>

                            <div class='detalle'>
                                <label>Sueldo Total:</label>
                                {$total_nomina} euros
                            </div>
                        </div>

                    </body>
                    </html>
            HTML;

            // CAPTURAMOS EL CONTENIDO EN EL BUFFER
            $dompdf->loadHtml($html);
            $dompdf->render();

            file_put_contents($rutaDelDocumento, $dompdf->output());
            
            $sendMail = sendNominaReady($dataEmpleado);
            
            if($sendMail){
                return "✅ Documento PDF y mail generado exitosamente: $rutaDelDocumento \n";
            } else {
                return $sendMail;
            }


        } else {
            return "❌ " . $dni . ' ya tiene la nómina del mes ' . date('M') . " creada \n";
        }
    } catch (Exception $e) {
        return 'Excepción Dompdf: ' . $e->getMessage() . "\n";
    }
}
?>