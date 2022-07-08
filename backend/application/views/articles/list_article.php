<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('_partials/head.php'); ?>
</head>

<body>

	<?php $this->load->view('_partials/navbar.php'); ?>

	<div class="container">
		<div style="color:darkgoldenrod;font-family: sans-serif;"><h3>List Artikel</h3></div>
		<hr>
			<?php foreach ($articles as $article) : ?>
					<br>
					<div style="color:red;font-family: sans-serif;font-size:1em;"><b><a href="<?= site_url('article/show/' . $article->slug) ?>">
						<?= $article->title ? html_escape($article->title) : "No Title" ?>
						
					</a><b></div>
					<div style="font-family: sans-serif;font-size:0.8em;color: gray;">
						<br>
						Lokasi : <?= $article->alamat ?> <br>
						Jenis Wisata : <?= $article->jenis_id ?><br>
						Harga Tiket : <?= $article->harga_tiket ?><br><br>
					</div>
				
				
			<?php endforeach ?>
			<hr>

		<div align="center";><?=  $this->pagination->create_links(); ?></div>
	</div>

	<?php $this->load->view('_partials/footer.php'); ?>
</body>

</html>