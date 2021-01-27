jQuery(function ($) {
    const attributeChoice = $('#search_configuration_attribute');
    const optionChoice = $('#search_configuration_option');
    const filterableCheckbox = $('#search_configuration_filterable');
    const facetTypeChoice = $('#search_configuration_facetType');

    attributeChoice.change(function () {
        const value = $(this).val();

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

    filterableCheckbox.change(function () {
        const value = $(this).is(':checked');

        if (value) {
            facetTypeChoice.parent().show();
        } else {
            facetTypeChoice.parent().hide();
            facetTypeChoice.val('');
        }
    });

    attributeChoice.change();
    optionChoice.change();
    filterableCheckbox.change();
});
