<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <form action="index.php" method="POST" class="col-4 my-4 mx-4">
                <h1>Odaberi broj stranice</h1>
                <div class="row mb-3">
                    <div class="col-6">
                        <select name="page_number" class="form-select" aria-label="Default select example"
                            id="page-num-select">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary">Odaberi</button>
                    </div>
                </div>
            </form>
        </div>


        <div class="row">
            <?php include('curl.php'); ?>
        </div>
    </div>

</body>

</html>