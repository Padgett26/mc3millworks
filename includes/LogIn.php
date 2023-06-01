<?php
if ($loginErr != "") {
    echo $loginErr;
}
if ($loggedIn == 1) {
    ?>
    <form action="index.php" method="get"><input type="hidden" name="logout" value="yep" /><input type="submit" value=" Log Out " /></form>
    <div style="margin: 30px 0px;">
        <h3>Manage Users:</h3><br />
        <table cellspacing="2px" cellpadding="5px" style="border:1px solid black;">
            <tr>
                <td style='text-align:center;'>User Name</td>
                <td style='text-align:center;'>New Password</td>
                <td style='text-align:center;'>Delete User</td>
                <td style='text-align:center;'>Make Changes</td>
            </tr>
            <?php
            $userStmt = $db->prepare("SELECT id,userName FROM users");
            $userStmt->execute();
            while ($userRow = $userStmt->fetch()) {
                $userId = $userRow['id'];
                $userName = $userRow['userName'];
                echo "<form action='index.php?show=LogIn' method='post'><tr>\n";
                echo "<td style='text-align:center;'>$userName</td>\n";
                echo "<td><input type='password' name='pwd' /></td>\n";
                echo "<td><input type='checkbox' name='delUser' value='1' /></td>\n";
                echo "<td><input type='hidden' name='updateUser' value='$userId' /><input type='submit' value=' Update ' /></td>\n";
                echo "</tr></form>\n";
            }
            ?>
            <form action='index.php?show=LogIn' method='post'><tr>
                    <td><input type='text' name='userName' /></td>
                    <td><input type='password' name='pwd' /></td>
                    <td>&nbsp;</td>
                    <td><input type='hidden' name='newUser' value='1' /><input type='submit' value=' Create ' /></td>
                </tr></form>
        </table>
    </div>
    <?php
} else {
    ?>
    Please log in:<br /><br />
    <form action="index.php?show=LogIn" method="post">
        <table cellspacing="0px" style="border:none;">
            <tr>
                <td>
                    User:
                </td>
                <td><input type="text" name="userName" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="pwd" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="login" value="1" />
                    <input type="submit" value=" Log In " />
                </td>
            </tr>
        </table>
    </form>
<?php } ?>