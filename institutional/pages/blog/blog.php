<?php

$title_page = "Blog | ";
include dirname(__FILE__) . '/../includes/header.php';

// Inclui a conexão com o banco e a classe Post
include_once dirname(__FILE__) . '/../../config/db.php';
include_once dirname(__FILE__) . '/../../models/Post.php';

// Instancia a conexão com o banco de dados
$database = new Database();
$db = $database->connect();

// Instancia a classe Post para obter os posts
$post = new Post($db);

// Parâmetros de paginação e busca
$limit = 6; // Limite de notícias por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página atual
$offset = ($page - 1) * $limit; // Calcular o offset

$search = isset($_GET['search']) ? $_GET['search'] : ''; // Busca

// Obter os posts paginados
$result = $post->getPaginatedPosts($limit, $offset, $search);

// Contar o número total de posts
$total_posts = $post->countPosts($search);

// Calcular o total de páginas
$total_pages = ceil($total_posts / $limit);

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

	<section class=" mb-0">
		<div class="container">

			<div class="row">

				<div class="col-12 mb-4">
					<form class="row" method="GET">
						<div class="col-lg-9 col-8">
							<input class="form-control form-control-lg" name="search" value="<?php echo htmlspecialchars($search); ?>" style="border: 1px solid #98a8b1;padding: 11px;" type="text" placeholder="Buscar">
						</div>
						<div class="col-lg-3 col-4">
							<button type="submit" class="btn btn-primary w-100">BUSCAR</button>
						</div>
					</form>
				</div>

				<?php
				// Loop através dos resultados e exibição dos posts
				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$titulo = $row['title'];
					$conteudo = $row['content'];
					$imagem = $row['image'];
					$imagemUrl = "http://localhost:8000/storage/images/" . $imagem;
					$slug = $row['slug'];
				?>

					<div class="col-lg-4 mb-5">
						<div class="blog_content box-shadow mb-3">
							<a href="blog/<?php echo $slug; ?>" class="zoom_image mb-3"> <!-- Ajusta o link para usar o slug -->
								<img src="<?php echo $imagemUrl; ?>" alt="<?php echo $titulo; ?>" style="width: 100%; height: 250px; object-fit: cover;" />
							</a>

							<div class="chamada_blog">
								<h3 class=""><?php echo $titulo; ?></h3>

								<p><?php echo substr($conteudo, 0, 150); ?>...</p>
							</div>
						</div>
						<a href="blog/<?php echo $slug; ?>" class="leia">Saiba mais</a> <!-- Ajusta o link para usar o slug -->
					</div><!-- col-lg-4 -->

				<?php } ?>

				<div class="col-12 my-3">

					<nav aria-label="Paginação">
						<ul class="pagination justify-content-center">
							<?php if ($page > 1): ?>
								<li class="page-item">
									<a class="page-link" href="/blog?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" tabindex="-1">Anterior</a>
								</li>
							<?php endif; ?>

							<?php for ($i = 1; $i <= $total_pages; $i++): ?>
								<li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
									<a class="page-link" href="/blog?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
								</li>
							<?php endfor; ?>

							<?php if ($page < $total_pages): ?>
								<li class="page-item">
									<a class="page-link" href="/blog?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Próximo</a>
								</li>
							<?php endif; ?>
						</ul>
					</nav>

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