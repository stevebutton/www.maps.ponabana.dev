(function($){
	
	"use strict";
	
	$(function(){
		
		
		function set_form_loading($searchform)
		{
			$searchform.stop(true, true).fadeIn("fast");
		}
		
		initSearchForms();
		
		$(".searchandfilter[data-ajax-shortcode=1]").submit(function(e)
		{
			var $thisform = $(this);
			
			var template_is_loaded = $thisform.attr("data-template-loaded");
			var use_ajax = $thisform.attr("data-ajax");
			var use_ajax_shortcode = $thisform.attr("data-ajax-shortcode");
			
			var $ajax_target_object = jQuery($thisform.attr("data-ajax-target"));
			var $ajax_results_url = $thisform.attr("data-results-url");
			
			if($ajax_target_object.length==0)
			{
				//alert("TARGET NOT FOUND");
				//alert($ajax_results_url);
				//$this.attr("action", $ajax_results_url);
				return false;
				
			}
			else
			{
				$ajax_target_object.attr("data-paged", 1);
				
				if(use_ajax_shortcode==1)
				{
					var form_id = $thisform.attr("data-sf-form-id");
					
					if(use_ajax==1)
					{
						
						e.preventDefault();
						
						var timestamp = new Date().getTime();
						
						$thisform.find("input[name=_sf_ajax_timestamp]").remove();
						$thisform.append('<input type="hidden" name="_sf_ajax_timestamp" value="'+timestamp+'" />');
						postAjaxResults($thisform, form_id);
						
						return false;
					}
					
				}
				
			}
		});
		
		function postAjaxResults($thisform, form_id)
		{
			var use_history_api = 0;
			
			if (window.history && window.history.pushState)
			{
				use_history_api = $thisform.attr("data-use-history-api");
			}
			
			var ajax_target_attr = $thisform.attr("data-ajax-target");
			var ajax_links_selector = $thisform.attr("data-ajax-links-selector");
			
			//var $ajax_target_object = jQuery(ajax_target_attr);
			var $ajax_target_object = jQuery($thisform.attr("data-ajax-target"));
			
			$ajax_target_object.animate({ opacity: 0.5 }, "fast"); //loading
			var pageNumber = $ajax_target_object.attr("data-paged");
			
			
			$thisform.trigger("sf:ajaxstart", [ "Custom", "Event" ]);
			
			var jqxhr = $.post(SF_LDATA.ajax_url+"?action=get_results&paged="+pageNumber, $thisform.serialize(), function(data, status, request)
			{
				$ajax_target_object.html(data);
				
				//setup pagination
				var $pagiLink =  $ajax_target_object.find(".pagi-prev, .pagi-next, .pagi-first, .pagi-last, .pagi-num")
				setupPagination($pagiLink, $ajax_target_object, $thisform, form_id);
				
			
			}).fail(function()
			{
				
			}).always(function()
			{
				$ajax_target_object.stop(true,true).animate({ opacity: 1}, "fast"); //finished loading				
				$thisform.trigger("sf:ajaxfinish", [ "Custom", "Event" ]);
			});
		}
		
		function setupPagination($pagiLink, $ajax_target_object, $thisform, form_id)
		{
			if($pagiLink.length>0)
			{
				$pagiLink.click(function(e){
					
					e.preventDefault();
					
					if(!$(this).hasClass("disabled"))
					{
						var pageNumber = $(this).attr("data-page-number");
						$ajax_target_object.attr("data-paged", pageNumber);
						
						postAjaxResults($thisform, form_id);
					}
					
					return false;
				});
			}
		}
		
		function initSearchForms()
		{
			var $search_forms = $('.searchandfilter');
			
			if($search_forms.length>0)
			{//loop through each page form, and see if they have pagination
				
				$search_forms.each(function(){
					
					//submit without submit button
					
					var $thisform = $(this);
					var use_shortcode = $thisform.attr("data-ajax-shortcode");
					
					if(use_shortcode==1)
					{
						$(this).find('input').keypress(function(e) {
							// Enter pressed?
							if(e.which == 10 || e.which == 13) {
								$thisform.submit();
								$ajax_target_object.attr("data-paged", 1);
							}
						});
						
						var template_is_loaded = $thisform.attr("data-template-loaded");
						var use_ajax = $thisform.attr("data-ajax");
						var auto_update = $thisform.attr("data-auto-update");
						var auto_count = $thisform.attr("data-auto-count");
						
						var $ajax_target_object = jQuery($thisform.attr("data-ajax-target"));
						$ajax_target_object.attr("data-paged", 1);
						
						var form_id = $thisform.attr("data-sf-form-id");
						
						//init combo boxes
						var $chosen = $thisform.find("select[data-combobox=1]");
						
						if($chosen.length>0)
						{
							
							$chosen.chosen();
						}
						
						//$($thisform).on('input', 'input.datepicker', dateInputType);
						
						//if(template_is_loaded==1)
						//{//if a template is loaded then use ajax
							
							if(use_ajax==1)
							{
							
								//postAjaxResults($thisform,form_id); //load initial results
								var $pagiLink =  $(".pagi-prev, .pagi-next, .pagi-first, .pagi-last, .pagi-num");
								setupPagination($pagiLink, $ajax_target_object, $thisform, form_id);
				
								if(auto_update==1)
								{
									
										$($thisform).on('change', 'input[type=radio], input[type=checkbox], select', function(e)
										{
											inputUpdate(200);
										});
										$($thisform).on('change', '.meta-slider', function(e)
										{
											inputUpdate(200);
										});
										$($thisform).on('input', 'input[type=number]', function(e)
										{
											inputUpdate(800);
										});
										
										$($thisform).on('input', 'input[type=text]:not(.datepicker)', function()
										{
											inputUpdate(1200);									
										});
										$($thisform).on('input', 'input.datepicker', dateInputType);
									
								}
								
								
								var use_history_api = $thisform.attr("data-use-history-api");
								var ajax_target_attr = $thisform.attr("data-ajax-target");
								
								$thisform.trigger("sf:init", [ "Custom", "Event" ]);
								//udpate
								return false;
							}
						//}
						
						$thisform.trigger("sf:init", [ "Custom", "Event" ]);
					}
				});
				
			}
			
		}
		
		function inputUpdate(delayDuration)
		{
			if(typeof(delayDuration)=="undefined")
			{
				var delayDuration = 300;
			}
			
			resetTimer(delayDuration);
		}
			
		var firstInput = false;
		var inputTimer = 0;
		var ajaxLastTimestamp = 0;
		
		function resetTimer(delayDuration)
		{
			
			clearTimeout(inputTimer)
			inputTimer = setTimeout(submitForm, delayDuration);
			
		}
		function submitForm()
		{
			
			var $thisform = $('.searchandfilter');
			
			var auto_update = $thisform.attr("data-auto-update");
			var use_ajax_shortcode = $thisform.attr("data-ajax-shortcode");
			
			if(use_ajax_shortcode=="1")
			{
				if(auto_update==1)
				{
					$thisform.submit();
				}
			}
			
			
		}
		function dateInputType()
		{
			var $this = $(this);
			var $thisform = $this.closest(".searchandfilter");
			var auto_update = $thisform.attr("data-auto-update");
			
			if(auto_update==1)
			{
				var $tf_date_pickers = $thisform.find(".datepicker");
				var no_date_pickers = $tf_date_pickers.length;
				
				if(no_date_pickers>1)
				{					
					//then it is a date range, so make sure both fields are filled before updating
					var dp_counter = 0;
					var dp_empty_field_count = 0;
					$tf_date_pickers.each(function(){
					
						if($(this).val()=="")
						{
							dp_empty_field_count++;
						}
						
						dp_counter++;
					});
					
					if(dp_empty_field_count==0)
					{
						inputUpdate(1200);
					}
				}
				else
				{
					inputUpdate(1200);
				}
			}
		}
		function dateSelect()
		{
			var $this = $(this);
			var $thisform = $this.closest(".searchandfilter");
			var auto_update = $thisform.attr("data-auto-update");
			
			if(auto_update==1)
			{
				var $tf_date_pickers = $thisform.find(".datepicker");
				var no_date_pickers = $tf_date_pickers.length;
				
				if(no_date_pickers>1)
				{					
					//then it is a date range, so make sure both fields are filled before updating
					var dp_counter = 0;
					var dp_empty_field_count = 0;
					$tf_date_pickers.each(function(){
					
						if($(this).val()=="")
						{
							dp_empty_field_count++;
						}
						
						dp_counter++;
					});
					
					if(dp_empty_field_count==0)
					{
						inputUpdate(1);
					}
				}
				else
				{
					inputUpdate(1);
				}
			}
		}
		
		function getURLParameter(name) {
			return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
		}
		
		
	});
	
})(window.jQuery);
