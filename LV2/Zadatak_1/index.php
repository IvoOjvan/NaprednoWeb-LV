<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid vh-100 mt-4 d-flex flex-column justify-content-center align-items-center">
        <div class="row p-4">
            <?php
            $db_name = "radovi";
            $dir = "backup/$db_name";

            if (!is_dir($dir)) {
                // Dodana dozvola za pisanje na disk
                if (!@mkdir($dir, 0777, true)) {
                    die("
                        <div class='alert alert-danger' role='alert'>
                            Failed to create directory: $dir
                        </div>
                    ");
                }
            }
            $time = time();

            $dbc = @mysqli_connect(
                "localhost",
                "admin",
                'admin',
                $db_name
            ) or die("
                <div class='alert alert-danger' role='alert'>
                    Failed to connect to database: $db_name
                </div>"
                );

            $r = mysqli_query($dbc, "SHOW TABLES");
            if (mysqli_num_rows($r) > 0) {
                while (list($table) = mysqli_fetch_array($r, MYSQLI_NUM)) {

                    $q = "SELECT * FROM $table";
                    $r2 = mysqli_query($dbc, $q);
                    $columns = mysqli_fetch_fields($r2);

                    $column_names = [];
                    //echo json_encode($columns);
                    foreach ($columns as $field) {
                        $column_names[] = $field->name;
                    }

                    $backup_query_field_names = implode(', ', $column_names);

                    if (mysqli_num_rows($r2) > 0) {
                        if ($fp = gzopen("$dir/{$table}_{$time}.sql.gz", "w9")) {
                            while ($row = mysqli_fetch_array($r2, MYSQLI_NUM)) {
                                $backup_format = "INSERT INTO $table ($backup_query_field_names) VALUES (";
                                foreach ($row as $value) {
                                    $backup_format .= "'$value',";
                                }
                                $backup_format = rtrim($backup_format, ",");
                                $backup_format .= ");";

                                gzwrite($fp, $backup_format . "\n");
                                //echo "<p>$backup_format</p>";
                            }
                            gzclose($fp);
                            echo
                                "<div class='alert alert-success' role='alert'>
                                File created: $dir/{$table}_{$time}.sql.gz
                            </div>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>
                                Failed to create file: $dir/{$table}_{$time}.sql.gz
                            </div>";
                        }
                    }

                }
            }

            ?>
        </div>
    </div>
</body>

</html>