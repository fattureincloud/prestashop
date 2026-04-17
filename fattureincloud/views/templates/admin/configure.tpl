{*
* FattureInCloud Prestashop Module
*
*  @author    Token S.a.s. di Matto Michele & C. <michele@webtoken.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

<script type="text/javascript" src="{$module_dir|escape:'html':'UTF-8'}views/js/fattureincloud.js"></script>

<div class="panel">
	<div class="row moduleconfig-header">
		<div class="col-xs-12 text-center">
			<img src="{$module_dir|escape:'html':'UTF-8'}views/img/logo-completo-nuovo.png" />
		</div>
	</div>
</div>

<script type="text/javascript">
		
	$(document).ready(function() {
		fattureincloud.initConfig();
	});
	
</script>
