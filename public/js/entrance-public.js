jQuery(function( $ ) {
	'use strict';

	// Submit form
	$(document).on('click', '.submitform', function () {
		$('.loading').attr('class', 'loading2');
		$('#register-form').ajaxSubmit({
			method: "post",
			url: submitform_ajaxurl.ajaxurl,
			data: {
				action: "entrance_registration_form_data_store",
				nonce: submitform_ajaxurl.nonce
			},
			beforeSend: () => {
				$('.loading2').css('visibility','visible')
			},
			dataType: "json",
			success: function (response) {
				$('.loading2').css('visibility', 'hidden')

				if (response.success) {
					location.href = response.success;
				}
				
				if (response.error) {
					window.history.pushState('', '', '?error='+response.error);
					location.reload();
				}
			}
		})
	});


	let access = false;
	let email_access = true;

	$('.entranceform').children().find('input').on('keyup', function () {
		if ($(this).val().length > 1) {
			$(this).css('border-color', '#ddd');
		}
	});

	$('.entranceform').children().find('select').on('change', function () {
		if ($(this).val() !== '-1') {
			$(this).css('border-color', '#ddd');
		}
	});

	$('.ent-password').on('keyup', function () {
		if ($(this).val().length < 6) {
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', '#ddd');
		}
	});

	function validate_data(id) {
		let inputs = $('#'+id).children().find('input,select');
		inputs.each(function () {
			if ($(this).val() == "" || $(this).val() == '-1') {
				$(this).css('border-color', 'red');
				access = false;
				return false;
			} else {
				$(this).css('border-color', '#ddd');
				access = true;
			}
		});

		if ($('.ent-password').val().length < 6) {
			$('.ent-password').css('border-color', 'red');
			access = false;
			return false;
		}
	}

	function loading(time) {
		$('.loading').css('visibility','visible')
		setTimeout(() => {
			$('.loading').css('visibility','hidden')
		}, time);
	}

	$('#entemail').on("keyup", function () {
		let email = $(this).val();

		if (email.indexOf('@') != -1) {
			$.ajax({
				type: "get",
				url: submitform_ajaxurl.ajaxurl,
				data: {
					action: "entrance_get_mymail",
					nonce: submitform_ajaxurl.nonce,
					email: email
				},
				dataType: "json",
				success: function (response) {
					if (response.success) {
						email_access = true;
						$('.reg-error').html("");
						$('#entemail').css('border-color', '#ddd');
					}
					if (response.exist) {
						email_access = false;
						$('.reg-error').html('<div class="errors"><p><span class="error-icon">⊘</span>&nbsp;' + response.exist + '</p></div>');
						$('#entemail').css('border-color', 'red');
						return false;
					}
				}
			});
		}
	});

	$('.tbbtn').each(function () {
		$(this).on("click", function () {
			loading(500);
			// Process data
			validate_data($(this).prev().attr('data-name'));
			if (email_access == false) {
				$('#entemail').css('border-color', 'red');
			} else {
				$('#entemail').css('border-color', '#ddd');
			}

			if (access == true && email_access == true) {
				$('.next-btn').text('NEXT');
				$('.tbbtn').each(function () {
					$(this).removeClass('ent-active');
				});
			
				$('.tabs').each(function () {
					$(this).addClass('ent-none');
				});

				$(this).addClass('ent-active');
				let section = $(this).attr('data-name');
				$('#' + section).removeClass('ent-none');

				// SHow head section
				if ($('#' + section).attr('data-section') == '1') {
					$('.ent-register-header').show();
				} else {
					$('.ent-register-header').hide();
				}
				$('.next-btn').attr('data-name', section)
			}
			
		});
	});

	$('.next-btn').on('click', function (e) {
		e.preventDefault();
		let nextbtn = $(this);
		loading(500);
		// Process data
		validate_data(validate_data($(this).attr('data-name')));
		if (email_access == false) {
			$('#entemail').css('border-color', 'red');
		} else {
			$('#entemail').css('border-color', '#ddd');
		}

		if (access == true && email_access == true) {
			$('.tabs').each(function () {
				if (!$(this).hasClass('ent-none')) {
				
					if ($(this).attr('data-section') == '3') {
						nextbtn.text('Submit').addClass('submitform');
						return false;
					}

					$('.tbbtn.ent-active').removeClass('ent-active').next().addClass('ent-active');
					$('.tabs').each(function () {
						$(this).addClass('ent-none');
					});

					$(this).next().removeClass('ent-none');
					// SHow head section
					if ($(this).next().attr('data-section') == '1') {
						$('.ent-register-header').show();
					} else {
						$('.ent-register-header').hide();
					}
				
					nextbtn.attr('data-name', $(this).next().attr('id'));
					return false;
				}
			});
		}
	});

	$('.skipbtn').on('click', function (e) {
		e.preventDefault();
		$('.loading').css('visibility','visible')
		setTimeout(() => {
			$('.next-btn').attr('data-name', 'petdetails');
			$('.next-btn').text('Submit').addClass('submitform');
			$('.loading').css('visibility', 'hidden');
			$('#shippingdetails').children().find('input').css('border-color', '#ddd');
			$("#addr_type option:selected").prop("selected", false);
			$('#shippingdetails').children().find('input').each(function () {
				$(this).val('');
			});
		}, 1000);
		
	});

	let itemnumber = 2;
	$('.add_dog').on("click", function (e) {
		loading(500);
		let btn = $(this)
		e.preventDefault();

		$('#petdetailwrap').children().each(function () {
			if ($('#petdetailwrap').children().length < 3) {
				$(this).hide();
			}
		});

		if ($('#petdetailwrap').children().length < 3) {
			$('#petdetailwrap').children().first().clone().appendTo('#petdetailwrap').show().attr('data-id', itemnumber++);
			$('#petdetailwrap').children().last().children().find('input').val('')

			$('#petdetailwrap').children().last().children().find('input,select').each(function () {
				$(this).attr('name', $(this).attr('name') + '_' + (itemnumber-1));
			});
			
			if ($('#petdetailwrap').children().length == 2) {
				$('.badded').each(function () {
					$(this).removeClass('active');
				})
				$('.pets_breadcrumbs').css('display', 'block').append('<span data-id="2" class="badded active">Second dog</span>');
			}

			if ($('#petdetailwrap').children().length == 3) {
				btn.hide();
				$('#petdetailwrap').children().last().addClass('lastitem');
				$('.badded').each(function () {
					$(this).removeClass('active');
				})
				$('.pets_breadcrumbs').css('display', 'block').append('<span data-id="3" class="badded active">Third dog</span>');
			}

			$('#petdetailwrap').children().find('input').on('keyup', function () {
				if ($(this).val().length > 1) {
					$(this).css('border-color', '#ddd');
				}
			});
		
			$('#petdetailwrap').children().find('select').on('change', function () {
				if ($(this).val() !== '-1') {
					$(this).css('border-color', '#ddd');
				}
			});
		}
	});

	$(document).on('click', '.badded', function () {
		let data = $(this).attr('data-id');
		$(this).siblings().removeClass('active');
		$(this).addClass('active');

		$('#petdetailwrap').children().each(function () {
			if ($(this).attr('data-id') == data) {
				$(this).siblings().hide();
				$(this).show();
			}
		})
	});

	$(document).on("click",'.delete-item', function () {
		$('.pets_breadcrumbs').find('.active').remove();
		$('.pets_breadcrumbs').children().last().addClass('active')
		$(this).parent('.item').prev().show();
		$(this).parent('.item').remove();
	});
	
	$('.closewindow').on("click", function () {
		$(this).parent().parent().hide();
	});
	$('.addpet').on("click", function () {
		$('.petpopup').css("display","flex");
	});
	$('.addpetbtn').on("click", function () {
		let btn = $(this)
		let petname = $('.ent-petname').val();
		let petage = $('.ent-petage').val();
		let birthday = $('.ent-birthday').val();
		let breed = $('#breed').val();
		let gender = $('#gender').val();

		if (petname != "") {
			$('.ent-petname').css("border-color", "#ddd");
			if (petage != "") {
				$('.ent-petage').css("border-color", "#ddd");
				if (birthday != "") {
					$('.ent-birthday').css("border-color", "#ddd");
					if (breed != "") {
						$('#breed').css("border-color", "#ddd");
						if (gender != "") {
							$('#gender').css("border-color", "#ddd");

							let data = {petname,petage,birthday,breed,gender}
							// Rest of the code
							// ================
							$.ajax({
								type: "post",
								url: submitform_ajaxurl.ajaxurl,
								data: {
									action: "user_myaccount_add_pets",
									nonce: submitform_ajaxurl.nonce,
									data: data
								},
								beforeSend: () => {
									btn.text("ADDING...")
									$('.loading2').css('visibility','visible')
								},
								dataType: "json",
								success: function (response) {
									btn.text("ADD")
									if (response.success) {
										var url = window.location.href;
                    					$('body').load(url);
									}
									if (response.error) {
										alert("Try again!");
									}
								}
							});
							
						} else {
							$('#gender').css("border-color", "red");
						}
					} else {
						$('#breed').css("border-color", "red");
					}
				} else {
					$('.ent-birthday').css("border-color", "red");
				}
			} else {
				$('.ent-petage').css("border-color", "red");
			}
		} else {
			$('.ent-petname').css("border-color", "red");
		}
	});
});