
<?php
$conn = new mysqli('localhost', 'root', '', 'poll');

$fetchSql = "SELECT * FROM prayojan";
$fetchResults = mysqli_query($conn,$fetchSql);

    $users= [];
    while($d = mysqli_fetch_array($fetchResults)){
        array_push($users, $d);
    }
    ?>

    <br>
    <table border = "1" style= "border-collapse: collapse;">
    <tr>
    <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Gender</th>
            <th>Country</th>
            <th colspan="2">Action</th>
    </tr>

    <?php foreach ($users as $d) { ?>
        <tr>
            <td> <?php echo $d["id"]; ?> </td>
            <td> <?php echo $d["name"]; ?> </td>
            <td> <?php echo $d["email"]; ?> </td>
            <td> <?php echo $d["phone"]; ?> </td>
            <td> <?php echo $d["password"]; ?> </td>
            <td> <?php echo $d["country"]; ?> </td>
            <td>
                <a href="updateuser.php?id= <?php echo $d["id"]; ?>">
              Edit
                </a>
            </td>
            <td><a href="deleteuser.php?id=<?php echo $d["id"]; ?>">Delete</a></td>
        </tr>

    <?php } ?>

</table>
    
</body>

</html>
