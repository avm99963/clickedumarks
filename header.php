<nav>
	<?php if (isset($morenav)) { echo $morenav; } ?> (<?=$_SESSION["id_usuari"]?><?=(isset($_SESSION["id_usuari_2"]) && !empty($_SESSION["id_usuari_2"]) ? " actuando como ".$_SESSION["id_usuari_2"] : "")?>, <a href="logout.php">Logout</a>)
	<hr>
</nav>