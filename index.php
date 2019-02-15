
<?php
$wsdl = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?wsdl";

$client = new SoapClient($wsdl);

$provincias = $client->ObtenerProvincias();
$provincias = simplexml_load_string($provincias->any);
$provincias = $provincias->provinciero->prov;

$desplegable = "<select name='prov' style='padding:2px; width:25%'>";
foreach ($provincias as $prov) {
    $desplegable .= "<option value='$prov->np'> $prov->np</option>";
}
$desplegable .= "</select><br>";

if ($_POST['enviar']) {
    $provincia = $_POST['prov'];
    $municipio = $client->ObtenerMunicipios($provincia);
    $municipio = simplexml_load_string($municipio->any);
    $municipio = $municipio->municipiero->muni;

    $desplegable2 = "<select style='margin-top: 15px; padding:2px; width:25%' name='muni'>";
    foreach ($municipio as $m) {
        $desplegable2 .= "<option value='$m->nm'>$m->nm</option>";
    }
    $desplegable2 .= "</select><br/><input type='submit' style='margin-top: 5px;' name='enviar2' "
            . "value='ENVIAR MUNICIPIO'>";
    if (isset($_POST['enviar2'])) {
        $muni = $_POST['muni'];
        if ($muni === "CAMPILLO DE DUEÑAS") {
            $txt = "Has seleccionado " . $muni . ", el mejor pueblo de todos, de $provincia";
        } else {
            $txt = "Has seleccionado " . $muni . ", de $provincia";
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <form action="." method="POST">
            <?php echo $desplegable ?>
            <input type="submit" style='margin-top: 5px;' name="enviar" value="ENVIAR PROVINCIA">
            <br/>
            <?php echo $desplegable2; ?>
            <?php echo $txt ?>
        </form>

    </body>
</html>
