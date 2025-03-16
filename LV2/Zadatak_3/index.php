<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid vh-100 d-flex flex-column align-items-center">
        <div class="row p-4 mt-4 justify-content-center">
            <?php
            $xml = simplexml_load_file("LV2.xml");

            foreach ($xml->record as $person) {
                $gender_class = "bi bi-gender-female";
                if ($person->spol == "Male") {
                    $gender_class = "bi bi-gender-male";
                }

                echo
                    "<div class='card mb-3 me-3' style='max-width: 580px;' id='user-$person->id'>
                        <div class='row g-0 justify-content-center'>
                            <div class='col-md-4 d-flex align-items-center justify-content-center'>
                                <img src='$person->slika' class='card-img rounded-circle ' style='width: 100px; height: 100px; object-fit: cover;'  alt='...'>
                            </div>
                            <div class='col-md-8 '>
                                <div class='card-body'>
                                    <h5 class='card-title'>$person->ime $person->prezime (<small class='text-muted'>$person->spol</small>)</h5>
                                    <p class='card-text'>$person->zivotopis</p>
                                    <div class='row'>
                                        <div class='col-8'>
                                            <i class='bi bi-envelope'></i>
                                            <small class='text-muted'>$person->email</small>
                                        </div>
                                        <div class='col-4'>
                                            <i class='$gender_class'></i>
                                            <small class='text-muted'>$person->spol</small>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                         </div>
                    </div>";
            }

            ?>
        </div>
    </div>
</body>

</html>