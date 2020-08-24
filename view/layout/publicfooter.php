<section id="footer-bar" >
				<div class="row">
					<div class="span3">
						<h4>Navigation</h4>
						<ul class="nav">
							<li><a href="<?= PUBLIC_URL ?>">Home</a></li>  
							<li><a href="<?= PUBLIC_URL."about" ?>">About Us</a></li>
							<li><a href="<?= PUBLIC_URL ?>contact">Contact Us</a></li>							
						</ul>					
					</div>
					<div class="span4">
						<h4>Navigation</h4>
						<ul class="nav">
							<li><a href="<?= PUBLIC_URL."product/". urlencode("Top Seller") ?>">Top Seller</a></li>
							<li><a href="<?= PUBLIC_URL."product/". urlencode("Best Seller") ?>">Best Seller</a></li>
						</ul>
					</div>
					<div class="span5">
						<?php echo html_entity_decode(htmlspecialchars_decode(stripcslashes($this->getfooter("")))) ?>
					</div>					
				</div>	
			</section>
<p id='templatedirectory' style="display: none"><?php echo SRC_URL ?></p>
			<section id="copyright">
                            <span>Copyright <?php echo date("Y")." ".SITE_NAME ?>.  All right reserved. Powered By::<a href="http://technets.in" target="_blank">technets.in</a></span>
			</section>
		</div>
		<script src="<?php echo SRC_URL ?>js/common.js"></script>
		<script src="<?php echo SRC_URL ?>js/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
			$(function() {
				$(document).ready(function() {
					$('.flexslider').flexslider({
						animation: "fade",
						slideshowSpeed: 4000,
						animationSpeed: 600,
						controlNav: false,
						directionNav: true,
						controlsContainer: ".flex-container" // the container that holds the flexslider
					});
				});
			});
		</script>
    </body>
</html>