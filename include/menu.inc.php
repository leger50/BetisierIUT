<div id="menu">
	<div id="menuInt">

		<p><a href="index.php?page=0"><img class = "icone" src="image/accueil.gif"  alt="Accueil"/>Accueil</a></p>

		<?php if (isset($_SESSION['estConnecte'])){?>
		<p><img class = "icone" src="image/personne.png" alt="Personne"/>Personne</p>
		<ul>
			<li><a href="index.php?page=1">Lister</a></li>
			<li><a href="index.php?page=2">Ajouter</a></li>

			<?php if ($_SESSION['admin']){?>
			<li><a href="index.php?page=4">Supprimer</a></li>
			<?php } ?>
		</ul>

		<p><img class="icone" src="image/citation.gif"  alt="Citation"/>Citations</p>
		<ul>
			<li><a href="index.php?page=7">Ajouter</a></li>
			<li><a href="index.php?page=6">Lister</a></li>
			<li><a href="index.php?page=8">Rechercher</a></li>

			<?php if ($_SESSION['admin']){?>
			<li><a href="index.php?page=9">Valider</a></li>
			<li><a href="index.php?page=10">Supprimer</a></li>
			<?php } ?>
		</ul>

		<p><img class = "icone" src="image/ville.png" alt="Ville"/>Ville</p>
		<ul>
			<li><a href="index.php?page=11">Lister</a></li>
			<li><a href="index.php?page=12">Ajouter</a></li>
			<li><a href="index.php?page=13">Modifier</a></li>

			<?php if ($_SESSION['admin']){?>
			<li><a href="index.php?page=14">Supprimer</a></li>
			<?php } ?>
		</ul>

	<?php }else{ ?>
		<p><img class = "icone" src="image/personne.png" alt="Personne"/>Personne</p>
		<ul>
			<li><a href="index.php?page=1">Lister</a></li>
		</ul>

		<p><img class="icone" src="image/citation.gif"  alt="Citation"/>Citations</p>
		<ul>
			<li><a href="index.php?page=6">Lister</a></li>
		</ul>

		<p><img class = "icone" src="image/ville.png" alt="Ville"/>Ville</p>
		<ul>
			<li><a href="index.php?page=11">Lister</a></li>
		</ul>
	<?php } ?>
	</div>
</div>
