<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid vh-100 d-flex flex-column align-items-center">

        <div class="card col-6 mt-4 mb-2">
            <div class="card-header">
                Image Selector
            </div>
            <div class="card-body">
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Select image</label>
                        <input class="form-control" type="file" id="fileToUpload" name="fileToUpload">
                    </div>
                    <div class="mb-2 d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        include("server.php");
        ?>
        <div class="card col-6 mt-4">
            <div class="card-header">
                Encrpyted files
            </div>
            <div class="card-body">
                <?php
                include("download.php");
                ?>
            </div>
        </div>
    </div>

</body>

</html>