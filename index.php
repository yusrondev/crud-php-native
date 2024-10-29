<?php
include 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (isset($_POST['id'])) { // Update
        $id = $_POST['id'];
        $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
        $message = 'Updated successfully';
    } else { // Create
        $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
        $message = 'Created successfully';
    }
}

if (isset($_GET['delete'])) { // Delete
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    $message = 'Deleted successfully';
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Simple CRUD Application</h2>

        <?php if ($message) : ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="form-group">
                <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= isset($_GET['edit']) ? $_GET['name'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= isset($_GET['edit']) ? $_GET['email'] : '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary"><?= isset($_GET['edit']) ? 'Update' : 'Add' ?> User</button>
        </form>

        <h3 class="mt-4">User List</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <a href="?edit=<?= $user['id'] ?>&name=<?= $user['name'] ?>&email=<?= $user['email'] ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>