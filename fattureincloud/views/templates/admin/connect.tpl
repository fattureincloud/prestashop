{*
* FattureInCloud Prestashop Module
*
*  @author    Websuvius di Michele Matto <michele@websuvius.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

<link href="{$module_dir|escape:'html':'UTF-8'}views/css/fattureincloud.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$module_dir|escape:'html':'UTF-8'}views/js/fattureincloud.js"></script>

<div class="panel">
	<div class="row moduleconfig-header">
		<div class="col-xs-12 text-center">
			<img src="{$module_dir|escape:'html':'UTF-8'}views/img/logo-completo.png" />
		</div>
	</div>
</div>
	
<div class="panel">
	<div class="panel-heading text-center">
		<i class="icon-cogs"></i> Connetti il tuo negozio <b>Prestashop</b> al tuo account <b>FattureInCloud - Passo 1</b>
	</div>
	<div class="moduleconfig-content">
		<div class="row">
			<div class="col-xs-12 text-center">
				
				{if isset($device_code_request.error)}
				
					<div class="alert alert-error">{$device_code_request.error_description}</div>
				
				{else}
					
					<a href="#" class="connect-error alert alert-danger hidden">Il codice è scaduto o non è più valido (<span class="connect-error-details"></span>). Ricarica la pagina o clicca qui per generare un nuovo codice.</a>
					
					<div class="connect-container">
						
						<p>
							<h4>
								Vai a questo indirizzo <a href="{$device_code_request.data.verification_uri}" target="_blank">{$device_code_request.data.verification_uri}</a> e utilizza il codice qui sotto:
							</h4>
						</p>
						
						<h1>{$device_code_request.data.user_code}</h1>
						
						<br>
						<p><a href="https://fattureincloud.it/connetti" class="btn btn-info btn-lg" target="_blank">Vai a {$device_code_request.data.verification_uri}</a></p>
						
						<br>
						<p>Una volta inserito il codice, attendi che qui compaia la selezione dell'azienda da collegare.</p>
					
					</div>
					
					<script type="text/javascript">
							
						$(document).ready(function() {
							fattureincloud.initConnect({$device_code_request.data.interval}, "{$device_code_request.data.device_code}");
						});
						
					</script>
				{/if}
			</div>
		</div>
	</div>
</div>
