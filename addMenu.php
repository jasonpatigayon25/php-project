<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_name = trim($_POST['menu_name']);
    $menu_desc = trim($_POST['menu_desc']);
    $price = trim($_POST['price']);
    
    if (strlen($menu_name) > 100) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Menu Name is too long',
                    text: 'Menu Name should be up to 100 characters.',
                });
            </script>";
    } elseif (strlen($menu_desc) > 1000) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Menu Description is too long',
                    text: 'Menu Description should be up to 1000 characters.',
                });
            </script>";
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            background-color: lightyellow;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Add Menu Item</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="menuForm">
            <div class="mb-3">
                <label for="menu_name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" required maxlength="100">
            </div>
            <div class="mb-3">
                <label for="menu_desc" class="form-label">Description:</label>
                <textarea class="form-control" id="menu_desc" name="menu_desc" required maxlength="1000"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" required step="0.01">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.all.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#menuForm').submit(function (e) {
            e.preventDefault();

            const menuName = $('#menu_name').val();
            const menuDesc = $('#menu_desc').val();
            const price = $('#price').val();

            if (menuName.length > 100) {
                Swal.fire('Error', 'Menu name should not exceed 100 characters!', 'error');
                return;
            } else if (menuDesc.length > 1000) {
                Swal.fire('Error', 'Menu description should not exceed 1000 characters!', 'error');
                return;
            } else if (price <= 0) {
                Swal.fire('Error', 'Price should be greater than 0!', 'error');
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'connectdb.php', 
                data: $(this).serialize(),  
                success: function (data) {

                    const response = JSON.parse(data);

                    if (response.status === 'success') {
                        Swal.fire('Success', 'Menu item added successfully!', 'success');
                        $('#menuForm')[0].reset(); 
                    } else {
                        Swal.fire('Error', 'There was a problem adding the menu item!', 'error');
                    }
                },
                error: function (error) {
                    Swal.fire('Error', 'Could not send the data. Please try again later.', 'error');
                }
            });
        });
    });
    </script>
</body>
</html>