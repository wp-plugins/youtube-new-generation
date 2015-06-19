=== YouTube New Generation ===
Contributors: feijao
Tags: YouTube, list videos, youtube channel
Donate link: https://pagseguro.uol.com.br/checkout/doacao.jhtml?email_cobranca=feijao.costa@gmail.com&moeda=BRL
Requires at least: 3.5
Tested up to: 4.2.2
Stable tag: trunk
License: GPL2
License URI: https://github.com/feijaocosta/youtube-new-generation/blob/master/LICENSE

Show the last uploads videos from a specific Youtube channel. 

== Description ==
Show the last uploads videos from a specific Youtube channel. This data is update six times for hour, and saved on DB. 

Using the shortcode [yt_new], you can show the latest video and a list of thumbnails. If you add the parameter [yt_new list=false], you can only show the latest video, without a list of thumbnails.

For more information, visit our site: http://dev.feijaocosta.com.br/youtube-new-generation

== Installation ==
Upload youtube-new-generation.zip to the /wp-content/plugins/ directory
Unzip youtube-new-generation.zip
Activate the plugin through the 'Plugins' menu in WordPress
Click on YouTube New Generation item on admi panel menu
Set your YouTube user (it is a part o your channel URL on youtube: http://youtube.com/user/your_user_name)

If you don't have a Google Developer API Key, follow this steps:
Open the [Google Console Developers] https://console.developers.google.com/project
Sign in with a Google account (you can use the same user of your youtube channel)
Click on Create Projetc
Insert a name for them, and click on Create
Select this project on top page
Click on APIs and Authentication
Find APIs for Youtube, and click on Youtube Data API, and them click on Activate API
Click on Credentials
On API Public Access, click on Create new Key
Select Browser Key option. For your security, insert a list of urls that can use your Key. With this, if anybody try use your key on different URL get a error. 
Click on create, copy the API Key code showed and paste on Google API Key field, on wordpress admin.

You can see this steps on a video tutorial, on this link: http://dev.feijaocosta.com.br/tutoriais/como-criar-uma-chave-publica-de-acesso-a-api-do-youtube/

If you have any trouble with this process, access our site and write a commentary on plugin page: http://dev.feijaocosta.com.br/youtube-new-generation

== Frequently Asked Questions ==

== Changelog ==

== Upgrade Notice ==

== Screenshots ==
1. Plugin Configuration
2. Showing one video and thumbnails
3. Showing only one video
