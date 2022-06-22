<style>
    <?php include 'CSS/login.css';?>
</style>

<section>
    <img src="IMG/CampoLogoBlack.png" alt="">
    <div class="loginCard">
        <h1>WECOME TO CAMPO</h1>
        <p>Login to Continue</p>
        <form action="">
            <div class="loginContinue">
                <div class="selectRole">
                    <div>
                        <label for="pRole">Role</label>
                        <select name="pRole" id="pRole">
                            <option value="inventory">Inventory</option>
                            <option value="chef">Chef</option>
                            <option value="cashier">Cashier</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label for="pUsername">Username</label>
                        <input type="text" id="pUsername" name="pUsername">
                    </div>
                    <div>
                        <label for="pPassword">Password</label>
                        <input type="password" id="pPassword" name="pPassword">
                    </div>
                    <div>
                        <button>LOGIN</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>