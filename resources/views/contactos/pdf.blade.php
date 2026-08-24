<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Directorio de Contactos</title>

    <style>
        @page {
            margin: 35px 30px 40px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #343a40;
        }

        .header {
            margin-bottom: 20px;
        }

        .titulo {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .filtros {
            font-size: 9px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .fecha {
            font-size: 8px;
            color: #6c757d;
        }

        .resultados {
            margin-top: 8px;
            font-size: 8px;
            color: #6c757d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            padding: 7px 6px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 7px 6px;
            vertical-align: top;
            line-height: 1.4;
        }

        tr {
            page-break-inside: avoid;
        }

        .nombre {
            font-weight: bold;
        }

        .contacto-linea {
            margin-bottom: 3px;
        }

        .contacto-label {
            font-weight: bold;
        }

        .vacio {
            color: #adb5bd;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #adb5bd;
        }
    </style>
</head>

<body>

    <div class="header">

        <div class="titulo">
            Directorio de Contactos
        </div>

        <div class="filtros">
            <strong>Filtros aplicados:</strong>
            {{ $filtrosAplicados }}
        </div>

        <div class="fecha">
            <strong>Fecha de generación:</strong>
            {{ $fechaGeneracion }}
        </div>

        <div class="resultados">
            <strong>Resultados:</strong>
            {{ $asignaciones->count() }} contactos
        </div>

    </div>


    <table>

        <thead>
            <tr>
                <th style="width: 23%;">
                    Nombre
                </th>

                <th style="width: 20%;">
                    Puesto
                </th>

                <th style="width: 22%;">
                    Ente
                </th>

                <th style="width: 35%;">
                    Contacto
                </th>
            </tr>
        </thead>

        <tbody>

            @foreach($asignaciones as $asignacion)

                @php
                    $contacto = $asignacion->contacto;

                    $nombreCompleto = trim(
                        ($contacto->nombre ?? '') . ' ' .
                        ($contacto->apellido_paterno ?? '') . ' ' .
                        ($contacto->apellido_materno ?? '')
                    );
                @endphp

                <tr>

                    <td class="nombre">
                        {{ $nombreCompleto }}
                    </td>

                    <td>
                        {{ $asignacion->puesto->nombre ?? 'Sin puesto asignado' }}
                    </td>

                    <td>
                        {{ $asignacion->ente->nombre ?? 'Sin ente' }}
                    </td>

                    <td>

                        @if($asignacion->correo)
                            <div class="contacto-linea">
                                <span class="contacto-label">
                                    Correo:
                                </span>
                                {{ $asignacion->correo }}
                            </div>
                        @endif


                        @if($asignacion->telefono)
                            <div class="contacto-linea">
                                <span class="contacto-label">
                                    Teléfono:
                                </span>

                                {{ $asignacion->telefono }}

                                @if($asignacion->extension)
                                    · <span class="contacto-label">
                                        Ext.
                                      </span>
                                    {{ $asignacion->extension }}
                                @endif
                            </div>

                        @elseif($asignacion->extension)

                            <div class="contacto-linea">
                                <span class="contacto-label">
                                    Ext.
                                </span>

                                {{ $asignacion->extension }}
                            </div>

                        @endif


                        @if($asignacion->celular)
                            <div class="contacto-linea">
                                <span class="contacto-label">
                                    Celular:
                                </span>
                                {{ $asignacion->celular }}
                            </div>
                        @endif


                        @if(
                            !$asignacion->correo &&
                            !$asignacion->telefono &&
                            !$asignacion->celular &&
                            !$asignacion->extension
                        )
                            <span class="vacio">
                                Sin medios de contacto registrados
                            </span>
                        @endif

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <div class="footer">
        Directorio de Contactos
    </div>

</body>
</html>