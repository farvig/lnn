<?php
// Currently not in use
// WP wont include it.
// 
// Find out why is TODO
?>
<div class="inpage-login-form">
	<p class="message message--error">Du skal være logget ind for at se denne side.</p>
	<?php  wp_login_form( array('label_username' => 'Email') ); ?>
	<p>Har du ikke en profil? <a href="/bliv-underviser" title="Opret profil">Opret en gratis her</a>.</p>
</div>