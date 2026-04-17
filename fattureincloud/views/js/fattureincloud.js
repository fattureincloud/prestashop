/**
* FattureInCloud Prestashop Module
*
*  @author    Token S.a.s. di Matto Michele & C. <michele@webtoken.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

var fattureincloud = function() {
	
	var initConnect = function(interval, device_code) {
		
		try {
			
			$(".connect-error").click(function() {
				location.reload();
			});
			
			pollForAccessToken(interval, device_code);
			
		} catch(e) {
			console.error(e);
		}
	}
	
	var pollForAccessToken = function(interval, device_code) {
		
		try {
			
			$.ajax({
				url: admin_controller_link,
				data: {
					ajax: true,
					action: 'getaccesstoken',
					device_code: device_code
				},
				dataType: "json",
				success : function(result){
					
					if (typeof result.error !== "undefined") {
						if (result.error == "authorization_pending") {
							setTimeout(function() { 
								pollForAccessToken(interval, device_code); 
							}, interval * 1000);
						
						} else {
							
							$(".connect-container").addClass("hidden");
							
							var errorDetails = result.error + ": " + result.error_description;
							$(".connect-error-details").html(errorDetails);
							$(".connect-error").removeClass("hidden");
						}
						
					} else {
						location.reload();
					}
				}
			});
			
		} catch(e) {
			console.error(e);
		}
	}
	
	var initSelectCompany = function() {
		
		try {
			
			$(".connect-error").click(function() {
				location.reload();
			});
				
			$("button[data-company-id]").click(function() {
				
				$("button[data-company-id]").addClass("disabled");
				$("button[data-company-id]").prop("disabled", true);
				
				saveCompanyId($(this).data("company-id"));
			});
		
		} catch(e) {
			console.error(e);
		}
		
	}
	
	var saveCompanyId = function(company_id) {
		
		try {
			
			$.ajax({
				url: admin_controller_link,
				data: {
					ajax: true,
					action: 'savecompanyid',
					company_id: company_id
				},
				dataType: "json",
				success : function(result){
					
					if (typeof result.error !== "undefined") {
						
						$(".connect-container").addClass("hidden");
												
						var errorDetails = result.error + ": " + result.error_description;
						$(".connect-error-details").html(errorDetails);
						$(".connect-error").removeClass("hidden");
												
					} else {
						location.reload();
					}
				}
			});
			
		} catch(e) {
			console.error(e);
		}
	}
	
	var toggleEinvoice = function() {
		
		var createInvoices = $('input[name="FATTUREINCLOUD_INVOICES_CREATE"]:checked').val();
		
		if (createInvoices == '1') {
			$('input[name="FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE"]').prop('disabled', false);
		} else {
			$('input[name="FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE"][value=""]').prop('checked', true);
			$('input[name="FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE"]').prop('disabled', true);
		}
		
		var createEInvoices = $('input[name="FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE"]:checked').val();
		
		if (createEInvoices == '1') {
			$('input[name="FATTUREINCLOUD_INVOICES_SEND_TO_SDI"]').prop('disabled', false);
		} else {
			$('input[name="FATTUREINCLOUD_INVOICES_SEND_TO_SDI"][value=""]').prop('checked', true);
			$('input[name="FATTUREINCLOUD_INVOICES_SEND_TO_SDI"]').prop('disabled', true);
		}
	}
	
	var initConfig = function() {
		
		try {
			
			toggleEinvoice();
			
			$('input[name="FATTUREINCLOUD_INVOICES_CREATE"]').on('change', function () {
				toggleEinvoice();
			});
			
			$('input[name="FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE"]').on('change', function () {
				toggleEinvoice();
			});
			
		} catch(e) {
			console.error(e);
		}
	}
	
	return {
		initConnect: initConnect,
		initSelectCompany: initSelectCompany,
		initConfig: initConfig
	}
}();