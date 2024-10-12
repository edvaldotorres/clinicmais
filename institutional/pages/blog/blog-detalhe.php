<?php
$title_page = "Blog | ";

// Inclui a conexão com o banco e a classe Post
include_once dirname(__FILE__) . '/../../config/db.php';
include_once dirname(__FILE__) . '/../../models/Post.php';

// Instancia a conexão com o banco de dados
$database = new Database();
$db = $database->connect();

// Instancia a classe Post para obter o post
$post = new Post($db);

// Obter o slug da URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

// Buscar o post pelo slug
$postDetails = $post->getPostBySlug($slug);

// Se o post não for encontrado, redireciona para a página 404
if (!$postDetails) {
	include dirname(__FILE__) . '/../erros/404.php'; // Caminho para a sua página 404
	exit;
}

// Inclui o cabeçalho apenas se o post for encontrado
include dirname(__FILE__) . '/../includes/header.php';

// Se o post for encontrado, exibe os detalhes
$titulo = $postDetails['title'];
$conteudo = $postDetails['content'];
$imagem = $postDetails['image'];
$imagemUrl = "http://localhost:8000/storage/images/" . $imagem;
$data = date('d M Y', strtotime($postDetails['created_at']));

?>


<main class="main mb-0" data-animate="top" data-delay="3">
	<aside class="banner_topo bnr-blog"></aside>

	<header class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1>
						<span>Blog</span>
					</h1>
				</div>
			</div>
		</div>
	</header>

	<section class=" mb-4">
		<div class="container">

			<div class="row">

				<article class="col-12">
					<div class="cabecalho mb-4 pb-2">
						<h2 class="topic5"><?php echo $titulo; ?></h2>
						<time style="color:#3056bb">
							<img src="assets/img/icones/calendar.jpg" style="vertical-align: baseline;" alt="">
							<?php echo $data; ?>
						</time>
						<hr class="">
					</div>

					<p class="text-center">
						<img src="<?php echo $imagemUrl; ?>" alt="<?php echo $titulo; ?>" class="img-fluid mb-3">
					</p>

					<p><?php echo nl2br($conteudo); ?></p>

					<p>
						<a href="javascript:history.go(-1);" class="btn btn-1 mt-3"> &laquo; Voltar</a>
					</p>
				</article>


				<div class="col-md-12 mt-4 col-lg-10 col-xl-8">
					<h5 class="topic5">Comentários</h5>
					<div class="comentario mb-3">
						<div class="d-block">
							<h6 class="fw-bold text-primary mb-1">Pedro Paulo</h6>
							<p class="text-muted small mb-0">
								Shared publicly - Jan 2020
							</p>
						</div>

						<p class="mt-3 mb-4 pb-2">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac arcu a lacus posuere facilisis nec a sapien. Proin mattis, diam id pharetra vulputate, lectus sapien tristique justo, nec vehicula enim turpis sit amet sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque a nunc erat. Cras ut dui ut mi scelerisque cursus.
						</p>
					</div>

					<div class="comentario mb-3">
						<div class="d-block">
							<h6 class="fw-bold text-primary mb-1">José Carol</h6>
							<p class="text-muted small mb-0">
								Shared publicly - Jan 2020
							</p>
						</div>

						<p class="mt-3 mb-4 pb-2">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac arcu a lacus posuere facilisis nec a sapien. Proin mattis, diam id pharetra vulputate, lectus sapien tristique justo, nec vehicula enim turpis sit amet sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque a nunc erat. Cras ut dui ut mi scelerisque cursus.
						</p>
					</div>


					<form class=" py-3 border-0">
						<h5 class="topic5">Deixe um comentário</h5>
						<div class="row ">
							<div class="col-md-12">
								<div class="form-group">
									<input class="form-control" type="text" name="" placeholder="Nome" style="border: 1px solid #98a8b1;">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control" id="" placeholder="Mensagem" rows="4" style="border: 1px solid #98a8b1;"></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="float-right pt-1">
									<button type="button" class="btn btn-primary btn-sm" data-mdb-button-initialized="true">PUBLICAR</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>

		</div><!-- row -->

		</div> <!-- container -->
	</section>

	<aside>
		<?php
		$banner = rand(1, 6);
		?>
		<a href="<?= $config['whatsapp']; ?>" target="_blank">
			<img src="assets/img/banner/0<?= $banner; ?>.png" class="d-none d-md-block w-100">
			<img src="assets/img/banner/mobile0<?= $banner; ?>.jpg" class="d-block d-md-none w-100">
		</a>
	</aside>
</main>


<?php

include dirname(__FILE__) . '/../includes/footer.php';

?>