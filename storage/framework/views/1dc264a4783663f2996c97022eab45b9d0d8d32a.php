<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <div class="row mt-5 justify-content-center">
        <div class="col-sm-3 align-self-center">
            <h2 class="text-center">LOGIN</h2>
            <form action="">
            <?php echo csrf_field(); ?>
                <input class="form-control form-control-sm" type="text" placeholder="Usuario">
                <input class="form-control form-control-sm" type="text" placeholder="Contraseña">
                <input class="btn btn-primary form-control" type="submit" value="Acceder">
            </form>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Pruebas\backend\resources\views/index.blade.php ENDPATH**/ ?>