<?php 
session_start();
include("header.php");
include("nav.php");
?>
<div class="container">
    <form id="form11" action="checkpwd.php" method="post" name="myForm">
        <table class="table" align="center">
            <tbody>
            <tr>
                <td>                
                    <input class="input is-dark" name="studentID" type="text" size="15" placeholder="帳號 注意大小寫!">
                </td>
            </tr>
            <tr>
                <td >                    
                    <input class="input is-dark" id="pw" name="password" type="password" size="15" onkeypress="if (event.keyCode == 13) {check_login()}" placeholder="密碼">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <a class="button is-dark is-outlined" type="button" onClick="check_login()">登入</a>
                    <a class="button is-dark is-outlined" type="button" href="/boom/showpage/forgotpassword.php" >忘記密碼/開通帳號</a>
                    
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<?php include("footer.php");?>