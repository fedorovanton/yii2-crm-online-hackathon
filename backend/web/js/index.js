$(document).ready(function() {

    if ($('.select').length) {
        $('.select').chosen({
            "placeholder_text_single": "Выберите значение...",
            "disable_search": true,
            "no_results_text": 'Не найдено совпадений'
        });
    }  else if ($('select').length) {
        $('select').chosen({
            "placeholder_text_single": "Выберите значение...",
            "disable_search": true,
            "no_results_text": 'Не найдено совпадений'
        });
    }

    const ps = new PerfectScrollbar('.sidebar');
    // let selects = document.querySelectorAll('.chosen-results');
    //
    // for (let i = 0; i < selects.length; i++) {
    //     let psval = new PerfectScrollbar(selects[i]);
    // }

    if ($('.date, .date-to-bottom').length) {
        $('.date').datepicker({
            dateFormat: 'dd.mm.yyyy',
            position: "top right"
        });

        $('.date-to-bottom').datepicker({
            dateFormat: 'dd.mm.yyyy',
            position: "bottom right"
        })

        $('.date, .date-to-bottom').mask('AB.CD.0000', { //это лайфхак что бы юзеры не вводили в дату подобное 23.54.2019
            translation: {
                A: {pattern: /[0-3]/},
                B: {pattern: /[0-9]/},
                C: {pattern: /[0-1]/},
                D: {pattern: /[0-9]/}
            },
            onKeyPress: function (a, b, c, d) {
                if (!a) return;
                let m = a.match(/(\d{1})/g);
                if (!m) return;
                if (parseInt(m[0]) === 3) {
                    d.translation.B.pattern = /[0-1]/;
                } else {
                    d.translation.B.pattern = /[0-9]/;
                }
                if (parseInt(m[2]) == 1) {
                    d.translation.D.pattern = /[0-2]/;
                } else {
                    d.translation.D.pattern = /[0-9]/;
                }
                let temp_value = c.val();
                c.val('');
                c.unmask().mask('AB.CD.0000', d);
                c.val(temp_value);
            }
        }).keyup();
    }

    if($('.phone').length || $('.code-unit').length || $('.phone-double').length || $('.time').length) {
        $('.phone').mask('+0(000)000-00-00');
        $('.code-unit').mask('000-000');
        $('.phone-double').mask('+0(000)000-00-00, +0(000)000-00-00');
        $('.time').mask('00:00');
        $('.time').on('keyup', function () {
            let newTime = $(this).val().split(':').join('');
            if (newTime > 5959) {
                $(this).val('59:59');
            }
        });
    }

    $('.member-add-photo').on('click', function() {
        $('#member-add-photo').click();
    })

    function uploadFile(selector) {
        $(selector).on('change', function(e) {
            let currentInput = e.target;

            let fileKitClass = $(currentInput).data('class');
            if (fileKitClass) {
                let fileKit = $('.' + fileKitClass + ' input[type="file"]')[0];
                fileKit.files = currentInput.files;
                $(fileKit).change();
                $(currentInput).parent().find('.upload-button span').hide();
                $(currentInput).parent().find('.upload-button span.load').show();
                $('.' + fileKitClass + ' ul.files').bind("DOMSubtreeModified",function(){
                    let fileName = currentInput.files[0].name;
                    let currentRow = $(selector).nextAll('.upload-scan__row');
                    currentRow.fadeIn().find('.filename').html(fileName);
                    $(selector).next('.upload-button').hide();

                    $(currentInput).parent().find('.upload-button span').show();
                    $(currentInput).parent().find('.upload-button span.load').hide();

                    $('.' + fileKitClass + ' ul.files').unbind( "DOMSubtreeModified" );
                });
            } else {
                let fileName = currentInput.files[0].name;
                let currentRow = $(this).nextAll('.upload-scan__row');
                currentRow.fadeIn().find('.filename').html(fileName);
                $(this).next('.upload-button').hide();
            }
        })
    }

    $('.upload-button').on('click', function() {
        let currentInput = $(this).prev('.upload-scan-input');
        currentInput.trigger('click');
        uploadFile(currentInput);
    });

    $('.removefile').on('click', function() {
        $(this).parent().hide();

        let fileKitClass = $(this).parent().parent().find('input[type="file"]').data('class');
        if (fileKitClass) {
            let fileKit = $('.' + fileKitClass + ' span.remove')[0];
            $(fileKit).click();
        }

        $(this).parent().prevAll('.upload-scan-input').val('');
        $(this).parent().prev('.upload-button').show();
    });

    $('.languages__info').on('click', function() {
        $('.languages__popup').fadeToggle();
    });

    $('.notification__icon').on('click', function() {
        $('.notification__dropdown').fadeToggle();
    });

    $('.languages__popup a').on('click', function() {
        $('.languages__popup a').removeClass('selected-language');
        $(this).addClass('selected-language');
    });

    $('.members-checkbox').on('change', function() {
        var favorite = [];
        $.each($(".members-checkbox:checked"), function(){            
            favorite.push($(this).val());
        });

        if ($(this).hasClass('first-checkbox')) {
            let checkboxLength = favorite.length - 1;
            $('.members__table-options').css('display', 'flex');
            $('.table__options-item span').html(checkboxLength);

        } else if (favorite.length > 0) {
            $('.members__table-options').css('display', 'flex');
            $('.table__options-item span').html(favorite.length);
        } else  {
            $('.members__table-options').hide();
        }
    });

    $('.add-input').on('click', function(e) {
        e.preventDefault();
        let newInput = '<div class="input"><input type="text"></div>';
        $(this).closest('div.input').prepend(newInput);
    })

    $('.add-input-textarea').on('click', function(e) {
        e.preventDefault();
        let newInput = '<div class="input"><textarea></textarea></div>';
        $(this).closest('div.input').prepend(newInput);
    })

    $('.fa-ellipsis-h').on('click', function() {
        var currentPositionTop = $(this).offset().top;
        var id = $(this).data('id');
        $('.dark').css('background', 'none');
        $('#burger_'+id+', .dark').fadeIn();
        $('#burger_'+id).css({
            'right': '75px',
            'top': `${currentPositionTop + 20}px`
        })
    })

    $('.dark').on('click', function() {
        $('.table-burger__popup, .anketa-link').fadeOut();
        $('.dark').fadeOut(400, function() {
            $('.dark').css('background', '');
        })
    })

    $('.table__item-wrapper').on('click', function() {
        $(this).next('.numbers-rf__item').toggleClass('hide');
        $(this).find('.fas').toggleClass('rotate');
    })

    $('.members__button-wrapper .with-dropdown').on('click', function(event) {
        event.preventDefault();
        $(this).find('.fa-chevron-down').toggleClass('fa-chevron-up');
        $(this).next('.members__control-button-dropdown').fadeToggle();
    })

    $('.table thead .members-checkbox').on('click', function() {
        if (this.checked) {
            $('.table .members-checkbox').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.table .members-checkbox').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    })

    if ($('.agreements-table').length) {
        $('.progress-bar-column').each(function(index) {
            let currentValue = $(this).data('progress');
            $(this).find('.progress-value').html(currentValue);
            $(this).find('.agreement-progress-bar').css('width', `${currentValue}%`);
        })
    }

      $(document).mouseup(function (e){
        var div = $(".notification__dropdown");
        if (!div.is(e.target)
          && div.has(e.target).length === 0) {
          div.fadeOut();
        }
      });

    // function animatedCounter(className) {
    //         $(className).each(function() {
    //             $(this).prop('Counter', 0).animate({
    //                 Counter:$(this).text()
    //             }, {
    //                 duration: 1000,
    //                 easing: 'swing',
    //                 step: function(now) {
    //                     $(this).text(Math.ceil(now));
    //                 }
    //             });
    //         })
    // }

    if ($('.statistics-page').length) {
        AOS.init();
    }

    $('.upload-photo-input').on('change', function() {
        $(this).addClass('downloaded');
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById('member-add-photo').files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
            if ($(window).width() < 600) {
                $uploadCrop = $('#uploadPreview').croppie({
                    enableExif: true,
                    viewport: {
                        width: 198,
                        height: 236,
                        type: 'square'
                    },
                    enableOrientation: true,
                    boundary: { width: 300, height: 300 },
                    showZoomer: false,
                });
            } else {
                $uploadCrop = $('#uploadPreview').croppie({
                    enableExif: true,
                    viewport: {
                        width: 300,
                        height: 400,
                        type: 'square'
                    },
                    enableOrientation: true,
                    boundary: { width: 500, height: 500 },
                    showZoomer: false,
                });
            }
        };

        $('.member-add-photo').css('border', 'none');
        $('.member-add-photo-text, .big-plus-icon').hide();
        $('.input-file__popup-wrapper, .photo-buttons__wrapper, .dark').fadeIn();
    });

    $('.load-another-button').on('click', function(e){
        e.preventDefault();
        $uploadCrop.croppie('destroy');
        $('.input-file__popup-wrapper, .dark').hide();
        $('.upload-photo-input').removeClass('downloaded').trigger('click');
    })

    $('.input-file-dark').on('click', function() {
        $('.input-file__popup-wrapper').hide();
        $('.remove-image-button').click();
    })

    $('.crop-image-button').on('click', function(e) {
        e.preventDefault();
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $('#uploadPreviewReady').attr('src', resp);
            $('.input-file__popup-wrapper, .dark').hide();
            $('#uploadPreviewReady, .remove-image-button').show();
            $("input[name='Members[photo_base64]']").val(resp);
        });

        $uploadCrop.croppie('destroy');
    })

    $(document).on('click', '.remove-image-button', function(e) {
        $('.downloaded').removeClass('downloaded');
        e.preventDefault();
        $('#uploadPreviewReady').attr('src', '');
        $uploadCrop.croppie('destroy');
        $('.member-add-photo').css('border', '2px dashed #c3c3c3');
        $('.member-add-photo-text, .big-plus-icon').show();
        $('.remove-image-button, #uploadPreviewReady').hide();
    });

    $(document).on('click', '.downloaded', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });


    $('.members__control--form').on('click', function() {
        $('.dark').css('background', 'none');
        $('.anketa-link, .dark').fadeIn();
    })

    $('.anketa-link__wrapper button').on('click', function() {
        var copyTextarea = $('.anketa-link__input');
        copyTextarea.focus();
        copyTextarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            $('.anketa-link').fadeOut();
        } catch (err) {
            console.log('Oops, unable to copy');
        }
    })

    $('.open-export-popup').on('click', function() {
        $('.export-popup').css({
            'z-index': '5',
            'opacity': '1'
        });
    })

    $('.export-cancel').on('click', function() {
        $('.export-popup').css({
            'z-index': '-1',
            'opacity': '0'
        })
    })

    $('.change-field').change(function() {
        if (this.checked) {
            $('#'+$(this).data('id')).prop( "disabled", true );
        } else {
            $('#'+$(this).data('id')).prop( "disabled", false );
        }
    });

    $('.copy-address').change(function() {
        if (this.checked) {
            let val = $('#members-registration_address').val();
            $('#members-actual_address').append($("<option></option>")
                .attr("value", val)
                .attr("selected", true)
                .text(val));
        } else {
            $('#members-actual_address').val('');
        }
    });

    $('#kazan-live').on('input', (e) => {
        let val = $(e.currentTarget).val();
        if(val === 'yes') {
            $('#address-kazan').parent().removeClass('input--hide');
        } else if(val === 'no') {
          $('#address-kazan').parent().addClass('input--hide');
        }
    });

    $('#no-patronymic-cb').on('input', (e) => {
        let $cT = $(e.currentTarget);
        if($cT.prop('checked')) {
          $cT.parents('.input').find('#no-patronymic-it').attr('disabled', true).val('')
        } else if(!$cT.prop('checked')) {
          $cT.parents('.input').find('#no-patronymic-it').attr('disabled', false)
        }
    })
});
