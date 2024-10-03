
<?php
$conn = new mysqli('localhost', 'root', '', 'poll');

$fetchSql = "SELECT * FROM prayojan";
$fetchResults = mysqli_query($conn,$fetchSql);

// $users= [];
// while($row = mysqli_fetch_array($fetchResults)){
//     array_push($users, $row);
// }
?>

<table border = "1" style= "border-collapse: collapse;">
    <!-- <tr>
    <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Address</th>
    </tr> -->

    <?php while ($d =mysqli_fetch_array($fetchResults)) { ?>
        <ul>
            <li> <?php echo $d["id"]; ?> </li>
            <li> <?php echo $d["name"]; ?> </li>
            <li> <?php echo $d["email"]; ?> </li>
            <li> <?php echo $d["phone"]; ?> </li>
            <li> <?php echo $d["password"]; ?> </li>
            <li> <?php echo $d["country"]; ?> </li>
            <ul>
    <?php } ?>

</table>