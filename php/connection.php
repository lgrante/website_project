<?php 



?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
    	<link href="style/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
    	<h3>Inscrivez vous pour pouvoir rédiger vos propres articles pour la communauté !</h3>
	    <form method="post">
	    	<table>
	    		<tr>
	    			<td>Email ou nom d'utilisateur</td>
	    			<td><input type="text" name="id" placeholder="Tesla ou aa@aa.aa"></td>
	    		</tr>
	    		<tr>
	    			<td>Mot de passe</td>
	    			<td><input type="password" name="password" placeholder="Tesla"></td>
	    		</tr>
	    		<tr>
	    			<td></td>
	    			<td><br />
	    				<input type="submit" value="Valider !">
	    			</td>
	    		</tr>
	    	</table>
	    	<div id="errorArea">
	    		<p style="color: red;"><?php if(isset($error)) { echo $error; } ?></p>
	    	</div>
    	</form>
	</body>
</html>