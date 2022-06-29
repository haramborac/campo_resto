<?php include 'header.php';
      include 'db.php'; ?>
<style>
    <?php include 'CSS/settings.css' ?>
</style>


    <div class="addEmployee addCSS">
        <div class="registeredCSS register">
            <form action="loginFormCode.php" method="POST">
                <div>
                    <label for="cssName">Fullname</label>
                    <input type="text" name="fullname" placeholder="Ex. Juan Dela Crus">
                </div>
                <div>
                    <label for="cssUsername">Username</label>
                    <input type="text" name="username" placeholder="Ex. Juan">
                </div>
                <div>
                    <label for="cssPassword">Password</label>
                    <input type="password" name="password">
                </div>
                <button type="submit" name="cssCreate">Register</button>
            </form>
        </div>
    </div>

    <div class="registeredCSS registered">
        <p>Registered CSS</p>
        <table>
            <tr>
                <th width="50%">CSS Username</th>
                <th width="50%">Tool</th>
            </tr>
            <?php 
                $cssQ = "SELECT * FROM employee_login LIMIT 5";
                $ccsCQ = mysqli_query($connection,$cssQ);
                while($cssRow = mysqli_fetch_assoc($ccsCQ)){
                    $name = $cssRow['username'];
            ?>
                <tr id="main">
                    <td id="disCssUser" width="50%">CSS <span id="cssAccessAcc"><?php echo $name ?></span></td>
                    <td id="delCSS" width="50%">
                        <a href="Settings.php?delete_css=<?php echo $cssRow['id'] ?>"><button id="delAccCSS" type="button">Delete</button></a>
                    </td>
                </tr>
            <?php }?>
            <script>
                var accessAccount   = document.getElementById("cssAccessAcc");
                var mainAdmin       = document.getElementById("disCssUser");
                var mainDelfunc     = document.getElementById("delCSS");

                if(accessAccount.innerHTML = "Chatspeak Admin"){
                    mainAdmin.style.display     = "none";
                    mainDelfunc.style.display     = "none";
                }
            </script>
        </table>
        
    </div>

    <?php 
        //DELETE CSS
        if(isset($_GET['delete_css'])){
            $del_css_id = $_GET['delete_css'];
            $del_css = "DELETE FROM employee_login WHERE id = $del_css_id ";
            mysqli_query($connection, $del_css);
            header('location:Settings.php');
        }
        ?>