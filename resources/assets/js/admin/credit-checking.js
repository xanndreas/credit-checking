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



})();
