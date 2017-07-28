<h3>Connectez vous à votre compte pour rejoindre la communauté !</h3>
<form method="post">
	<table>
	    <tr>
	    	<td><label for="login">Email ou nom d'utilisateur</label></td>
	    	<td><input type="text" name="login" placeholder="Tesla ou aa@aa.aa"></td>
	    </tr>
	    <tr>
	    	<td><label for="password">Mot de passe</label></td>
	    	<td><input type="password" name="password" placeholder="yoursecretpassword"></td>
	    </tr>
	    <tr>
	    <?php if(!isset($_GET['first_connection'])) { ?>
	    	<td><a href="index.php?p=registration">Je n'ai pas de compte</a></td>
	    <?php } ?>
	    	<td><br />
	    		<input type="submit" value="Valider !">
	    	</td>
	    </tr>
	</table>
	<div id="errorArea">
	    <p style="color: red;"><?php if(isset($error)) { echo $error; } ?></p>
	</div>
</form>