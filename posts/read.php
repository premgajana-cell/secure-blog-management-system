<?php
include("../config/db.php");

$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $result = mysqli_query($conn,
        "SELECT * FROM posts
        WHERE title LIKE '%$search%'
        OR content LIKE '%$search%'
        LIMIT $start, $limit");

    $total_result = mysqli_query($conn,
        "SELECT COUNT(id) as total FROM posts
        WHERE title LIKE '%$search%'
        OR content LIKE '%$search%'");
}
else
{
    $result = mysqli_query($conn,
        "SELECT * FROM posts LIMIT $start, $limit");

    $total_result = mysqli_query($conn,
        "SELECT COUNT(id) as total FROM posts");
}

$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
   <style>
   body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #007bff, #c850c0);
    min-height: 100vh;
}

.container {
    width: 90%;
    margin: auto;
    text-align: center;
    padding-top: 30px;
}

h1 {
    color: white;
    font-size: 50px;
}

.search-box {
    margin: 30px 0;
}

.search-box input {
    width: 500px;
    padding: 18px;
    border: none;
    border-radius: 40px;
    font-size: 18px;
}

.search-box button {
    padding: 18px 30px;
    border: none;
    border-radius: 40px;
    background: #6f42c1;
    color: white;
    font-size: 18px;
    cursor: pointer;
}

.add-post-btn {
    margin-bottom: 30px;
}

.add-post-btn a {
    text-decoration: none;
    color: white;
    background: linear-gradient(45deg, #4facfe, #d66efd);
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 22px;
    font-weight: bold;
}

table {
    width: 100%;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    border-collapse: collapse;
}

th {
    background: linear-gradient(45deg, #007bff, #c850c0);
    color: white;
    padding: 20px;
    font-size: 20px;
}

td {
    padding: 20px;
    border-bottom: 1px solid #ddd;
}

.edit-btn {
    color: blue;
    margin-right: 10px;
    text-decoration: none;
}

.delete-btn {
    color: red;
    text-decoration: none;
}
.pagination {
    text-align: center;
    margin-top: 25px;
}

.pagination a {
    display: inline-block;
    text-decoration: none;
    margin: 0 6px;
    padding: 12px 18px;
    background: white;
    color: #6f42c1;
    font-size: 18px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.pagination a:hover {
    background: linear-gradient(45deg, #007bff, #c850c0);
    color: white;
    transform: translateY(-3px);
}

.pagination a.active {
    background: linear-gradient(45deg, #007bff, #c850c0);
    color: white;
}
</style>
</head>
<body>

<div class="container">

    <h1>All Posts</h1>

    <div class="search-box">
        <form method="GET">
        <input type="text" name="search" placeholder="Search posts...">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="add-post-btn">
        <a href="create.php">+ Add Post</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['title']; ?></td>
            <td><?= $row['content']; ?></td>
            <td>
                <a class="edit-btn" href="update.php?id=<?= $row['id']; ?>">Edit</a>
                <a class="delete-btn" href="delete.php?id=<?= $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <div class="pagination">
<?php for($i=1; $i<=$total_pages; $i++) { ?>
    <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
        <?php echo $i; ?>
    </a>
<?php } ?>
</div>

</div>

</body>
</html>