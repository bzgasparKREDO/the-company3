<?php
session_start();
require "../classes/User.php";
$user_obj = new User;

$user = $user_obj->getUser();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Edit User</title>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom:80px;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
                <form action="../actions/logout.php" method="post" class="d-flex ms-2">
                    <button class="text-danger bg-transparent border-0" type="submit">Log out</button>
                </form>

            </div>
        </div>
    </nav>
    <main class="row justify-content-center gx-0">
        <div class="col-4">
            <h2 class="text-center">EDIT USER</h2>
            <form action="../actions/edit-user.php" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center mb-3">
                    <div class="col-6">
                        <?php
                        if($user['photo']){
                            ?>
                        <img src="../assets/images/<?php echo $user['photo']?>" alt="<?= $user['photo']?>"
                            class="d-block mx-auto edit-photo">
                        <?php }else{
                                ?>
                        <i class="fa-solid fa-user text-secondary d-block text-center edit-icon"></i>
                        <?php } ?>
                        <input type="file" name="photo" class="form-control mt-2" accept="image/*">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input required value="<?php echo $user['first_name'] ?>" type="text" class="form-control" name="first_name" id="first_name" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input required value="<?php echo $user['last_name'] ?>" type="text" class="form-control" name="last_name" id="last_name" placeholder="">
                </div>
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input required value="<?php echo $user['username'] ?>" type="text" class="form-control" name="username" id="username" placeholder="">
                </div>
                <div class="text-end">
                            <a href="dashboard.php" class="btn btn-secondary btn-sm px-5">Cancel</a>
                            <button type="submit" class="btn btn-warning btn-sm px-5">Save</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>