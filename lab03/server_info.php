<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Information</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <h1>Informasi Server</h1>
    <table>
        <tr>
            <th>Variabel</th>
            <th>Nilai</th>
        </tr>
        <tr>
            <td>Server Name</td>
            <td><?php echo $_SERVER['SERVER_NAME']; ?></td>
        </tr>
        <tr>
            <td>Server Address</td>
            <td><?php echo $_SERVER['SERVER_ADDR']; ?></td>
        </tr>
        <tr>
            <td>Server Port</td>
            <td><?php echo $_SERVER['SERVER_PORT']; ?></td>
        </tr>
        <tr>
            <td>Document Root</td>
            <td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
        </tr>
        <tr>
            <td>Current Script</td>
            <td><?php echo $_SERVER['PHP_SELF']; ?></td>
        </tr>
        <tr>
            <td>Request Method</td>
            <td><?php echo $_SERVER['REQUEST_METHOD']; ?></td>
        </tr>
        <tr>
            <td>User Agent</td>
            <td><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td>
        </tr>
        <tr>
            <td>Client IP</td>
            <td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
        </tr>
        <tr>
            <td>Protocol</td>
            <td><?php echo $_SERVER['SERVER_PROTOCOL']; ?></td>
        </tr>
        <tr>
            <td>PHP Version</td>
            <td><?php echo phpversion(); ?></td>
        </tr>
    </table>
</body>

</html>