<html>
	<body>
		<pre>
		<?php
			if($_POST["google_key"]){
				$google_key = $_POST["google_key"];
				$youtube_user = $_POST["youtube_user"];

				$handle = wp_remote_fopen("https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=$youtube_user&key=$google_key");
				$contents = json_decode($handle,true);
								
				$playlist = $contents["items"][0]["contentDetails"]["relatedPlaylists"]["uploads"];
				
			
				update_option('yt_nw_gen_settings', '{"google_key":"' . $google_key . '","youtube_user":"' . $youtube_user . '","playlist":"' . $playlist . '"}');
				update_option('yt_nw_gen_videos','{}');
				
				//wp_schedule_event( time(), 'manytimes', 'yt_nw_gen_update_videos_hook' );
			
				
				// Make first update
				yt_nw_gen_update_videos();
			}
		
			$settings = json_decode(get_option('yt_nw_gen_settings'),true);
		?>
		</pre>
		<h2><?php _e('Settings') ?></h2>
			<form method="post" action="admin.php?page=youtube-new-generation%2Fadmin.php" novalidate="novalidate">

				<table class="form-table">
					<tr>
						<th scope="row"><label for="blogdescription"><?php _e('Youtube Channel') ?></label></th>
						<td><input name="youtube_user" type="text" id="youtube_user" aria-describedby="tagline-description" value="<?php print($settings["youtube_user"]); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname"><?php _e('Google API Key') ?></label></th>
						<td><input name="google_key" type="text" id="google_key" value="<?php print($settings["google_key"]); ?>" class="regular-text" />
						<p class="description" id="tagline-description"><?php _e( 'Leia abaixo como criar a sua API Key do Google' ) ?></p></td>
					</tr>
				</table>
				<?php do_settings_sections('general'); ?>
				
				<?php submit_button(); ?>
			</form>
			<hr />
			<h3>Como utilizar?</h3>
			Basta adicionar o shortcode <b>[yt_new]</b>. Você pode adicionar também o parâmetro "list=false" pra exibir somente o player do vídeo mais recete. Ex.: <b>[yt_new list=false]</b><br><br>
			<hr />
			
			<h3>Como criar a API Key?</h3>
			(Você pode também ver um video tutorial <a href="http://dev.feijaocosta.com.br/tutoriais/como-criar-uma-chave-publica-de-acesso-a-api-do-youtube/">clicando aqui!</a>)
			<ul>
				<li>1. Acesse o <a href="https://console.developers.google.com/project">Console Developers</a> do Google;</li>
				<li>2. Faça login com uma conta google (pode ser o mesmo usuário que você utiliza pra subir os vídeos)</li>
				<li>3. Clique em <b>Create Project</b>;</li>
				<li>4. Digite um nome para ele, e clique em <b>Create</b>;</li>
				<li>5. Selecione o projeto, no topo da página;</li>
				<li>6. Clique em APIs e Autenticação e depois em APIs;</li>
				<li>7. Localize a parte de APIs para Youtube, e clique em Youtube Data API, e depois em Ativa API;</li>
				<li>8. Clique agora em Credenciais;</li>
				<li>9. Em Acesso Público a API, clique em Criar nova chave;</li>
				<li>10. Seleciona a opção <b>Chave do Navegador</b>. Nesse ponto você poderá informar a URL do seu site, pra garantir que não usarão sua chave em outro endereço. Isso é importante, porque existe um limite de requisições que cada chave pode fazer</li>
				<li>11. Ao clicar em criar, ele vai apresentar pra você a sua chave. Copie ela e cole no campo Google API Key do formulário acima;</li>
			</ul>
			
	
	</body>
</html>
