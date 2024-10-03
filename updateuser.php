 <?php
$connection=mysqli_connect('localhost', 'root', '', 'poll');
if(!$connection){
    die('Database connnection error');
}
$id=$_GET['id'];
$fetchSql = "SELECT * FROM prayojan where id= $id";
$fetchResults = mysqli_query($connection,$fetchSql);
$d = mysqli_fetch_assoc($fetchResults);
$updateSql = "UPDATE prayojan SET name = '$name', email = '$email',  password = '$password' where id = $id ";
$updateResult = mysqli_query($connection,$updateSql);
if($updateResult){
    echo "User have been updated successfully";
}else {
    echo "Update has been failed in database";
}
?>
<form method="post" action="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" required>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-secondary">Reset</button>   
        </form>