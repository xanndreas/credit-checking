'use strict';

$(function () {
    const select2 = $('.select2'),
        selectPicker = $('.selectpicker');

    if (selectPicker.length) {
        selectPicker.selectpicker();
    }

    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                placeholder: 'Select value',
                dropdownParent: $this.parent()
            });
        });
    }

    $('.brand_text-container').hide();
    $('.dealer_text-container').hide();
    $('.down_payment_text-container').hide();
});

(function () {
    const wizardIconsModern = document.querySelector('.wizard-modern-icons');

    if (typeof wizardIconsModern !== undefined && wizardIconsModern !== null) {
        const wizardIconsModernBtnNextList = [].slice.call(wizardIconsModern.querySelectorAll('.btn-next')),
            wizardIconsModernBtnPrevList = [].slice.call(wizardIconsModern.querySelectorAll('.btn-prev')),
            wizardIconsModernBtnSubmit = wizardIconsModern.querySelector('.btn-submit');

        const modernIconsStepper = new Stepper(wizardIconsModern, {
            linear: false
        });

        if (wizardIconsModernBtnNextList) {
            wizardIconsModernBtnNextList.forEach(wizardIconsModernBtnNext => {
                wizardIconsModernBtnNext.addEventListener('click', event => {
                    modernIconsStepper.next();
                });
            });
        }
        if (wizardIconsModernBtnPrevList) {
            wizardIconsModernBtnPrevList.forEach(wizardIconsModernBtnPrev => {
                wizardIconsModernBtnPrev.addEventListener('click', event => {
                    modernIconsStepper.previous();
                });
            });
        }
    }

    let dealers = $('#dealer_id'),
        brands = $('#brand_id'),
        downPayment = $('#down_payment'),
        dealerText = $('.dealer_text-container'),
        brandsText = $('.brand_text-container'),
        downPaymentText = $('.down_payment_text-container');

    downPayment.on("change", function (e) {
        if (downPayment.select2('data').pop().text === 'Other') {
            downPaymentText.show()
        } else {
            downPaymentText.hide()
        }
    });

    dealers.on("change", function (e) {
        if (dealers.select2('data').pop().text === 'Other') {
            dealerText.show()
        } else {
            dealerText.hide()
        }
    });

    brands.on("change", function (e) {
        if (brands.select2('data').pop().text === 'Other') {
            brandsText.show()
        } else {
            brandsText.hide()
        }
    });

})();
