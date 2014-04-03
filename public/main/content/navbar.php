	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $this->helper->url('..'); ?>">Projeto Exemplo</a>
            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo $this->helper->url('sobre'); ?>">Sobre</a></li>
                    <li><a href="<?php echo $this->helper->url('servicos'); ?>">Serviços</a></li>
                    <li><a href="<?php echo $this->helper->url('contato'); ?>">Contato</a></li>
                </ul>
            </div>
        </div>
    </nav>