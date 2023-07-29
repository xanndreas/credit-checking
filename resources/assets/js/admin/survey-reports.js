'use strict';

$(function () {

    $('.form-repeater-container').on('submit', function (e) {
        e.preventDefault();
    });

    let rowSurveyAddress = 2;
    let colSurveyAddress = 1;

    $('.survey_address-repeater').repeater({
        show: function () {
            let fromControl = $(this).find('.form-control, .form-select');
            let formLabel = $(this).find('.form-label');

            fromControl.each(function (i) {
                let id = 'form-repeater-' + rowSurveyAddress + '-' + colSurveyAddress;
                $(fromControl[i]).attr('id', id);
                $(formLabel[i]).attr('for', id);
                colSurveyAddress++;
            });

            rowSurveyAddress++;

            $(this).slideDown();
        },

        hide: function (e) {
            confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
        }
    });

    let rowDocumentAttachment = 2;
    let colDocumentAttachment = 1;


    $('.document_attachment-repeater').repeater({
        show: function () {
            let fromControl = $(this).find('.form-control, .form-select');
            let formLabel = $(this).find('.form-label');

            fromControl.each(function (i) {
                let id = 'form-repeater-' + rowDocumentAttachment + '-' + colDocumentAttachment;
                $(fromControl[i]).attr('id', id);
                $(formLabel[i]).attr('for', id);
                colDocumentAttachment++;
            });

            rowDocumentAttachment++;

            $(this).slideDown();
        },

        hide: function (e) {
            confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
        }
    });

    let rowEnvCheck = 2;
    let colEnvCheck = 1;

    $('.environmental_check-repeater').repeater({
        show: function () {
            let fromControl = $(this).find('.form-control, .form-select');
            let formLabel = $(this).find('.form-label');

            fromControl.each(function (i) {
                let id = 'form-repeater-' + rowEnvCheck + '-' + colEnvCheck;
                $(fromControl[i]).attr('id', id);
                $(formLabel[i]).attr('for', id);
                colEnvCheck++;
            });

            rowEnvCheck++;

            $(this).slideDown();
        },

        hide: function (e) {
            confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
        }
    });


    let rowNote = 2;
    let colNote = 1;

    $('.note-repeater').repeater({
        show: function () {
            let fromControl = $(this).find('.form-control, .form-select');
            let formLabel = $(this).find('.form-label');

            fromControl.each(function (i) {
                let id = 'form-repeater-' + rowNote + '-' + colNote;
                $(fromControl[i]).attr('id', id);
                $(formLabel[i]).attr('for', id);
                colNote++;
            });

            rowNote++;

            $(this).slideDown();
        },

        hide: function (e) {
            confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
        }
    });

    let rowIncompleteDocument = 2;
    let colIncompleteDocument = 1;

    $('.incomplete_document-repeater').repeater({
        show: function () {
            let fromControl = $(this).find('.form-control, .form-select');
            let formLabel = $(this).find('.form-label');

            fromControl.each(function (i) {
                let id = 'form-repeater-' + rowIncompleteDocument + '-' + colIncompleteDocument;
                $(fromControl[i]).attr('id', id);
                $(formLabel[i]).attr('for', id);
                colIncompleteDocument++;
            });

            rowIncompleteDocument++;

            $(this).slideDown();
        },

        hide: function (e) {
            confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
        }
    });
});
