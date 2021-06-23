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
		if ($('.ent-password').val().length < 6) {
			$('.ent-password').css('border-color', 'red');
			access = false;
		}
		let inputs = $('#'+id).children().find('input,select');
		inputs.each(function () {
			if ($(this).val() == "" || $(this).val() == '-1') {
				$(this).css('border-color', 'red');
				access = false;
			} else {
				$(this).css('border-color', '#ddd');
				access = true;
			}
		});
	}

	function loading(time) {
		$('.loading').css('visibility','visible')
		setTimeout(() => {
			$('.loading').css('visibility','hidden')
		}, time);
	}

	$('.tbbtn').each(function () {
		$(this).on("click", function () {
			loading(500);
			// Process data
			validate_data($(this).prev().attr('data-name'));

			if (access == true) {
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

		if (access == true) {
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
		let data = $(this).parent('.item').attr('data-it');
		$('.pets_breadcrumbs').find('.active').remove();
		$('.pets_breadcrumbs').children().last().addClass('active')
		$(this).parent('.item').prev().show();
		$(this).parent('.item').remove();
	});
});