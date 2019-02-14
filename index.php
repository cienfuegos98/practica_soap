
<?php
$wsdl = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?wsdl";

$client = new SoapClient($wsdl);

$provincias = $client->ObtenerProvincias();
$provincias = simplexml_load_string($provincias->any);
$provincias = $provincias->provinciero->prov;

$desplegable = "<select name='prov'>";
foreach ($provincias as $prov) {
    $desplegable .= "<option value='$prov->np'> $prov->np</option>";
}
$desplegable .= "</select>";

if ($_POST['enviar']) {
    $provincia = $_POST['prov'];
    $municipio = $client->ObtenerMunicipios($provincia);
    $municipio = simplexml_load_string($municipio->any);
    $municipio = $municipio->municipiero->muni;
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
            <input type="submit" name="enviar" value="ENVIAR">
            <br/>
            <?php
            foreach ($municipio as $m) {
                echo $m->nm . "<br>";
            }
            ?>
        </form>
    </body>
</html>
