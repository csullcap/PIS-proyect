<!DOCTYPE html>
<html lang="en">
<style>
    @font-face {
        font-family: 'Calibri';
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        src: url('fonts/calibri.ttf') format("truetype");
    }

    @font-face {
        font-family: 'Calibri';
        font-weight: bold;
        font-style: normal;
        font-variant: normal;
        src: url('fonts/calibrib.ttf') format("truetype");
    }

    /*

    @font-face {
        font-family: 'Calibri';
        font-weight: normal;
        font-style: italic;
        font-variant: normal;
        src: url('fonts/calibrii.ttf') format("truetype");
    }

    @font-face {
        font-family: 'Calibri';
        font-weight: bold;
        font-style: italic;
        font-variant: normal;
        src: url('fonts/calibriz.ttf') format("truetype");
    } */

    .encabezado {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        border: 0.5px solid black;
        text-align: center;
    }

    .encabezado-columna-1 {
        width: 20%;
    }

    .encabezado-columna-2 {
        width: 60%;
    }

    .encabezado-columna-3 {

        width: 10%;
    }

    .encabezado-columna-4 {
        width: 10%;
    }

    .encabezado tbody tr td {
        border: 0.5px solid black;

    }

    .encabezado tbody tr {
        border: 0.5px solid black;
    }

    .lista {
        font-size: 14px;
    }

    .lista ol {
        padding-inline-start: 0;
        list-style: none;
        counter-reset: contador;
    }

    .lista ol .op {
        counter-increment: contador;
    }

    .lista ol .op::before {
        content: "("counter(contador) ") ";
    }

    body {
        font-family: 'Calibri';
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        font-size: 12px;
    }
</style>

<body>
    <table class="encabezado">
        <tbody>
            <tr>
                <td class="encabezado-columna-1" rowspan="3">
                    <img src='img/logo_unsa.png' width="100%" alt="logo">
                </td>
                <td class="encabezado-columna-2"> <b>FORMATO</b> </td>
                <td class="encabezado-columna-3"> <b>Código</b></td>
                <td class="encabezado-columna-4">F-PE01.04-05</td>
            </tr>
            <tr>
                <td rowspan="2"> <b>PLAN DE MEJORA</b></td>
                <td> <b>Versión</b></td>
                <td>1.0</td>
            </tr>
            <tr>
                <td> <b>Página</b></td>
                <td>Página 1 de 72</td>
            </tr>
        </tbody>
    </table>

    <div class="lista">
        <ol>
            <li class="op"> Registrar en la columna el código de la acción de la mejora
                continua, por ejemplo: OM
                – 01:2020, que refiere
                a la oportunidad de mejora 01 correspondiente al año 2020.</li>
            <li class="op">
                Registrar si la fuente de la Mejora proviene de:
                <ul style="list-style-type: disc">
                    <li>Solicitudes de acción correctiva. </li>
                    <li>Servicios no conformes. </li>
                    <li>Quejas. </li>
                    <li>Evaluación de competencias. </li>
                    <li>Evaluación de los objetivos Educacionales. </li>
                    <li> Actividades diarias. </li>
                    <li> Lineamientos institucionales. </li>
                    <li>Acuerdos de Consejo de Facultad y Asamblea Docente. </li>
                    <li>Buenas prácticas de otras organizaciones. </li>
                    <li>Otros. </li>

                </ul>
            </li>
            <li class="op">Registre el problema / oportunidad que genera la mejora</li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
            <li class="op"> </li>
        </ol>
    </div>

</body>

</html>
