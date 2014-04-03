<?php $this->partial('header'); ?>

	<?php $this->partial('navbar'); ?>

	<div class="container">
	
		<div class="row">
	
			<div class="col-lg-12">
				<h1 class="page-header">
					Contato <small>Página exemplo</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo $this->helper->url('servicos'); ?>">Home</a></li>
					<li class="active">Contato</li>
				</ol>
			</div>
	
			<div class="col-lg-12">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d467688.894951192!2d-46.595299199999985!3d-23.682412399999965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce448183a461d1%3A0x9ba94b08ff335bae!2sS%C3%A3o+Paulo+-+SP!5e0!3m2!1spt-BR!2s!4v1396559690059" width="100%" height="400" frameborder="0" style="border:0"></iframe>
			</div>
	
		</div>
	
		<div class="row">
	
			<div class="col-sm-8">
				<h3>Let's Get In Touch!</h3>
				<p>
					Lid est laborum dolo rumes fugats untras. Etharums ser quidem
					rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums
					unsers sadips amets. Sed ut perspiciatis unde omnis iste natus error
					sit voluptatem accusantium doloremque laudantium, totam rem aperiam,
					eaque ipsa quae ab illo inventore veritatis et quasi architecto
					beatae vitae dicta sunt explicabo.
				</p>
				<?php 
				if ($this->error) {
					foreach($this->error as $key => $row) { 
					?>
					<div class="alert <?php echo $key == 'success' ? 'alert-success' : 'alert-error'; ?>">
                        	<?php echo $row['message']; ?>
                      	</div>
						<?php 
					} 
				}
				?>
				<form action="<?php echo $this->helper->url('contato/enviar'); ?>" role="form" method="POST" action="contact-form-submission.php">
					<div class="row">
						<div class="form-group col-lg-4">
							<label for="input1">Nome</label> 
							<input type="text" name="nome" value="<?php echo $this->data['nome'] ? $this->data['nome'] : ''; ?>" class="form-control" id="input1">
						</div>
						<div class="form-group col-lg-4">
							<label for="input2">Email</label> 
							<input type="email" name="email" value="<?php echo $this->data['email'] ? $this->data['email'] : ''; ?>" class="form-control" id="input2">
						</div>
						<div class="form-group col-lg-4">
							<label for="input3">Telefone</label> 
							<input type="phone" name="telefone" value="<?php echo $this->data['telefone'] ? $this->data['telefone'] : ''; ?>" class="form-control" id="input3">
						</div>
						<div class="clearfix"></div>
						<div class="form-group col-lg-12">
							<label for="input4">Mensagem</label>
							<textarea name="mensagem" class="form-control" rows="6" id="input4"><?php echo $this->data['mensagem'] ? $this->data['mensagem'] : ''; ?></textarea>
						</div>
						<div class="form-group col-lg-12">
							<button type="submit" class="btn btn-primary">Enviar</button>
						</div>
					</div>
				</form>
			</div>
	
			<div class="col-sm-4">
				<h3>Empresa</h3>
				<h4>Slogan</h4>
				<p>
					5555 44th Street N.<br> Bootstrapville, CA 32323<br>
				</p>
				<p>
					<i class="fa fa-phone"></i> <abbr title="Phone">P</abbr>: (555)
					984-3600
				</p>
				<p>
					<i class="fa fa-envelope-o"></i> <abbr title="Email">E</abbr>: <a
						href="mailto:feedback@startbootstrap.com">feedback@startbootstrap.com</a>
				</p>
				<p>
					<i class="fa fa-clock-o"></i> <abbr title="Hours">H</abbr>: Monday -
					Friday: 9:00 AM to 5:00 PM
				</p>
				<ul class="list-unstyled list-inline list-social-icons">
					<li class="tooltip-social facebook-link"><a href="#facebook-page"
						data-toggle="tooltip" data-placement="top" title="Facebook"><i
							class="fa fa-facebook-square fa-2x"></i></a></li>
					<li class="tooltip-social linkedin-link"><a
						href="#linkedin-company-page" data-toggle="tooltip"
						data-placement="top" title="LinkedIn"><i
							class="fa fa-linkedin-square fa-2x"></i></a></li>
					<li class="tooltip-social twitter-link"><a href="#twitter-profile"
						data-toggle="tooltip" data-placement="top" title="Twitter"><i
							class="fa fa-twitter-square fa-2x"></i></a></li>
					<li class="tooltip-social google-plus-link"><a
						href="#google-plus-page" data-toggle="tooltip" data-placement="top"
						title="Google+"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
				</ul>
			</div>
	
		</div>
	
	</div>

<?php $this->partial('footer'); ?>