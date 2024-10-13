<?php
$title_page = "Blog | ";

// Inclui a conexão com o banco e as classes Post e Comment
include_once dirname(__FILE__) . '/../../config/db.php';
include_once dirname(__FILE__) . '/../../models/Post.php';
include_once dirname(__FILE__) . '/../../models/Comment.php';

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
// Verificação para evitar erro com strtotime
$data = isset($postDetails['created_at']) ? date('d M Y', strtotime($postDetails['created_at'])) : 'Data não disponível';
$post_id = $postDetails['id'];

// Instancia a classe Comment
$comment = new Comment($db);

// Lógica para inserção de comentários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Obtém os dados do formulário
	$author = isset($_POST['author']) ? $_POST['author'] : null;
	$content = isset($_POST['content']) ? $_POST['content'] : null;

	// Verifica se os dados foram enviados
	if ($author && $content) {
		// Atribui os valores aos atributos do comentário
		$comment->post_id = $post_id;
		$comment->author = $author;
		$comment->content = $content;

		$comment->create();
	}
}

// Buscar todos os comentários para este post
$comments = $comment->getCommentsByPostId($post_id);
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

	<section class="mb-4">
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
					<?php if (isset($success_message)) : ?>
						<div class="alert alert-success mb-4">
							<?php echo $success_message; ?>
						</div>
					<?php elseif (isset($error_message)) : ?>
						<div class="alert alert-danger mb-4">
							<?php echo $error_message; ?>
						</div>
					<?php endif; ?>

					<h5 class="topic5">Comentários</h5>

					<?php if ($comments) : ?>
						<?php foreach ($comments as $comment) : ?>
							<div class="comentario mb-3">
								<div class="d-block">
									<h6 class="fw-bold text-primary mb-1"><?php echo htmlspecialchars($comment['author']); ?></h6>
									<p class="text-muted small mb-0">
										Shared publicly - <?php echo date('d M Y', strtotime($comment['created_at'])); ?>
									</p>
								</div>
								<p class="mt-3 mb-4 pb-2">
									<?php echo htmlspecialchars($comment['content']); ?>
								</p>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<p>Não há comentários ainda. Seja o primeiro a comentar!</p>
					<?php endif; ?>
				</div>

				<div class="col-md-12 mt-4 col-lg-10 col-xl-8">
					<h5 class="topic5">Deixe um comentário</h5>
					<form method="POST" class="py-3 border-0">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input class="form-control" type="text" name="author" placeholder="Nome" required style="border: 1px solid #98a8b1;">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control" name="content" placeholder="Mensagem" rows="4" required style="border: 1px solid #98a8b1;"></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="float-right pt-1">
									<button type="submit" class="btn btn-primary btn-sm">PUBLICAR</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<aside>
		<?php $banner = rand(1, 6); ?>
		<a href="<?= $config['whatsapp']; ?>" target="_blank">
			<img src="assets/img/banner/0<?= $banner; ?>.png" class="d-none d-md-block w-100">
			<img src="assets/img/banner/mobile0<?= $banner; ?>.jpg" class="d-block d-md-none w-100">
		</a>
	</aside>
</main>

<?php include dirname(__FILE__) . '/../includes/footer.php'; ?>


<?php include dirname(__FILE__) . '/../includes/footer.php'; ?>