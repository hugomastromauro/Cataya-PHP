	
	<div class="container">

        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Cataya-PHP 2014</p>
                </div>
            </div>
        </footer>

    </div>
            
    <?php 
	foreach ($this->assets->getAllJavascript() as $assets) {
		echo $assets;
	}
	?>
	
</body>
</html>