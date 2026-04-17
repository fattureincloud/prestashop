{*
* FattureInCloud Prestashop Module
*
*  @author    Token S.a.s. di Matto Michele & C. <michele@webtoken.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

<link href="{$module_dir|escape:'html':'UTF-8'}views/css/fattureincloud.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$module_dir|escape:'html':'UTF-8'}views/js/fattureincloud.js"></script>

<div class="panel">
	<div class="row moduleconfig-header">
		<div class="col-xs-12 text-center">
			<img src="{$module_dir|escape:'html':'UTF-8'}views/img/logo-completo-nuovo.png" />
		</div>
	</div>
</div>
	
<div class="panel">
	<div class="panel-heading text-center">
		<i class="icon-cogs"></i> Connetti il tuo negozio <b>Prestashop</b> al tuo account <b>Fatture In Cloud - Passo 2</b>
	</div>
	<div class="moduleconfig-content">
		<div class="row">
			<div class="col-xs-12 text-center">
				
				{if isset($controlled_companies_request.error)}
				
					<div class="alert alert-error">{$controlled_companies_request.error_description}</div>
				
				{else}
					
					<a href="#" class="connect-error alert alert-danger hidden">Si è verificato un errore. (<span class="connect-error-details"></span>). Ricarica la pagina o clicca qui per riprovare.</a>
					
					<div class="connect-container">
						
						<h4>
							Seleziona l'azienda da collegare a questo negozio.
						</h4>
						
						{foreach $controlled_companies_request.data.companies as $company}
							<br>
							<p><button class="btn btn-info btn-lg" type="button" data-company-id="{$company.id}">{$company.name} (P.IVA {$company.vat_number} )</button></p>
						{/foreach}
						
						<br>
						<p>
							N.B: Assicurati di selezionare un'azienda che hai autorizzato nel passo precedente.
						</p>
						
					</div>
					
					<script type="text/javascript">
													
						$(document).ready(function() {
							fattureincloud.initSelectCompany();
						});
						
					</script>
				{/if}
			</div>
		</div>
	</div>
</div>
