/**
* FattureInCloud Prestashop Module
*
*  @author    Websuvius di Michele Matto <michele@websuvius.it>
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
	
	return {
		initConnect: initConnect,
		initSelectCompany: initSelectCompany
	}
}();