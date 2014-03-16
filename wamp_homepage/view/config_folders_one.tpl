<h2>Folders</h2>
<br>
<form method="post">
<table class="span11" style="color: black">

	<?php foreach ($config as $key => $val): ?>
		<tr style="text-align:left">
			<td><?= $key; ?></td>
			<td>

				<?php if ($key == 'couleur'): ?>
					<select style="width: 300px" name="couleur">

						<?php foreach ($colors as $color): ?>
							<option value="<?= $color; ?>" <?php if ($color == $val): ?>selected<?php endif; ?>>
								<?= $color; ?>
							</option>
						<?php endforeach; ?>

					</select>
				<?php else: ?>
					<input style="width: 300px" type="text" name="<?= $key; ?>" value="<?= $val; ?>">

					<?php if ($key == 'icone'): ?>
						<a style="color: black;font-size:12px" target="_blank" href="/index.php/icones">
							Icones
						</a>
					<?php endif; ?>

				<?php endif; ?>

			</td>
		</tr>
	<?php endforeach; ?>

	<tr>
		<td></td>
		<td style="text-align:left;padding-top:10px">
			<button class="button">Enregistrer</button>
		</td>
	</tr>
</table>

</form>