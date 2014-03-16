<h2>Ignore a folder</h2>
<br>

<form method="post">
	<table style="width: 300px">
		<tr style="text-align:left">
			<td>
				<input type="text" name="dir" style="width: 300px;" placeholder="Nom du dossier a ignorer">
			</td>
			<td style="padding-left:10px">
				<button class="button">Ajouter</button>
			</td>
		</tr>
	</table>
</form>

<br><br>

<h2>Ignored folders</h2>
<br>

<table style="width: 300px">
	<?php foreach ($ignored as $value): ?>
	<tr style="text-align:left">
		<td style='color:black;'><?= $value->directory; ?></td>
		<?php if ($value->directory != '.' && $value->directory != '..' && $value->directory != 'wamp_homepage'): ?>
			<td style="padding-left:10px">
				<form method="post">
					<input type="hidden" name="delete" value="true">
					<input type="hidden" name="dir" value="<?= $value->directory; ?>">
					<button class="button red">Supprimer</button>
				</form>
			</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
</table>