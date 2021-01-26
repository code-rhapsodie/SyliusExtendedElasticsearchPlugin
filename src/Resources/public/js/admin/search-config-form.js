jQuery(function ($) {
    const attributeChoice = $('#search_configuration_attribute');
    const optionChoice = $('#search_configuration_option');

    attributeChoice.change(function () {
        const value = $(this).val();
        console.log(value);

        if (!value) {
            optionChoice.parent().show();
        } else {
            optionChoice.parent().hide();
            optionChoice.val('');
        }
    });

    optionChoice.change(function () {
        const value = $(this).val();

        if (!value) {
            attributeChoice.parent().show();
        } else {
            attributeChoice.parent().hide();
            attributeChoice.val('');
        }
    });

    attributeChoice.change();
    optionChoice.change();
});
