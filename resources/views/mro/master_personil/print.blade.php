<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {

            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;

        }

        thead th {
            background: #0d2c7a;
            color: white;
        }
    </style>

</head>

<body>

    <h2>DATA PERSONIL MRO</h2>

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Jobdesk</th>
                <th>Spesialisasi</th>
                <th>Catatan</th>
                <th>Penempatan</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($data as $row)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $row->nama }}</td>

                    <td>{{ $row->nip }}</td>

                    <td>{{ $row->jabatan }}</td>

                    <td>{{ $row->status }}</td>

                    <td>{!! nl2br(e($row->jobdesk)) !!}</td>

                    <td>{{ $row->spesialisasi }}</td>

                    <td>{!! nl2br(e($row->catatan)) !!}</td>

                    <td>{{ $row->penempatan }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

    <script>
        window.print();
    </script>

</body>

</html>
