<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pacientes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #5d5c5c; padding: 8px; text-align: left; }
        th { background-color: #d3979a; color: white; }
    </style>
</head>
<body>
    <h2 class="text-center text-xl leading-tight text-[#d3979a]">REPORTE DE PACIENTES</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombres y Apellidos</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Cédula</th>
                <th>Género</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $index => $paciente)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $paciente->nombres_pc }} {{ $paciente->ap_pat_pc }} {{ $paciente->ap_mat_pc }}</td>
                    <td>{{ $paciente->edad }}</td>
                    <td>{{ $paciente->tel_pac }}</td>
                    <td>{{ $paciente->direccion_pc }}</td>
                    <td>{{ $paciente->ci_pc }}</td>
                    <td>{{ $paciente->genero_pc }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
