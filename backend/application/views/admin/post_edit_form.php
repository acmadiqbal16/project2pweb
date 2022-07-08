<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('admin/_partials/head.php') ?>
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
	<main class="main">
		<?php $this->load->view('admin/_partials/side_nav.php') ?>

		<div class="content">
			<h1>Edit Article</h1>

			<form action="" method="POST">
				<div>
					<label for="title">Nama Tempat Wisata</label>
					<input type="text" name="title" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->title ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Jenis Wisata</label>
					<input type="text" name="jnwisata" class="<?= form_error('title') ? 'invalid' : '' ?>" value="<?= form_error('title') ? set_value('title') : $article->jenis_id ?>" maxlength="128" />
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Kecamatan</label>
					<input type="text" name="kec" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->id_kecamatan ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Alamat</label>
					<input type="text" name="alamat" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->alamat ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Lattitude, Longitude</label>
					<input type="text" name="latlong" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->latlong ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Skor Rating</label>
					<input type="text" name="rating" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->skor_rating ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Harga Tiket</label>
					<input type="text" name="htiket" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->harga_tiket ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>
				<div>
					<label for="title">Website</label>
					<input type="text" name="nmweb" class="<?= form_error('title') ? 'invalid' : '' ?>"
					value="<?= form_error('title') ? set_value('title') : $article->website ?>" 
					required maxlength="128"/>
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>

				<div>
					<label for="content">Konten</label>
					<?php $content = form_error('content') ? set_value('content') : $article->content ?>
					<input type="hidden" name="content" value="<?= html_escape($content) ?>">
					<div id="editor" style="min-height: 160px;"><?= $content ?></div>
				</div>

				<div>
					<button type="submit" name="draft" class="button" value="true">Save to Draft</button>
					<button type="submit" name="draft" class="button button-primary" value="false">Publish Update</button>
					<div class="invalid-feedback">
						<?= form_error('draft') ?>
					</div>
				</div>
			</form>

			<?php $this->load->view('admin/_partials/footer.php') ?>
			<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
			<script>
				var quill = new Quill('#editor', {
					theme: 'snow',
					modules: {
						toolbar: [
								[{ header: [1, 2, 3, 4, 5, 6, false] }],
								[{ font: [] }],
								["bold", "italic"],
								["link", "blockquote", "code-block", "image"],
								[{ list: "ordered" }, { list: "bullet" }],
								[{ script: "sub" }, { script: "super" }],
								[{ color: [] }, { background: [] }],
						]
				},
				});
				quill.on('text-change', function(delta, oldDelta, source) {
					document.querySelector("input[name='content']").value = quill.root.innerHTML;
				});
			</script>
		</div>
	</main>
</body>

</html>