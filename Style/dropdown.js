$(document).ready(function() {
    // Get all dropdowns from the document
    const dropdowns = $('.dropdown');

    // Loop through all dropdown elements
    dropdowns.each(function() {
        // Get inner elements from each dropdown
        const select = $(this).find('.select');
        const caret = $(this).find('.caret');
        const menu = $(this).find('.menu');
        const options = $(this).find('.menu li');
        const selected = $(this).find('.selected');
        const table = $(this).next('.table'); // Get the table that follows this dropdown

        select.click(function() {
            // Add the clicked select styles to the select element
            select.toggleClass('select-clicked');

            // Add the rotate styles to the caret element
            caret.toggleClass('caret-rotate');

            // Add the open styles to the menu element
            menu.toggleClass('menu-open');

            // Toggle 'hide' class on the associated table
            table.toggleClass('hide');

            // Save table visibility state to localStorage
            localStorage.setItem('table', table.hasClass("hide") ? 'hide' : 'show');
        });

        // Loop through all options elements
        options.each(function() {
            // Add a click event to the option element
            $(this).click(function() {
                // Change selected inner text to clicked option inner text
                selected.text($(this).text());

                // Add the clicked select styles to the select element
                select.toggleClass('select-clicked');

                // Add the rotate styles to the caret element
                caret.toggleClass('caret-rotate');

                // Add the open styles to the menu element
                menu.toggleClass('menu-open');

                // Remove active class from all option elements
                options.removeClass('active');

                // Add active class to clicked option element
                $(this).addClass('active');
            });
        });
    });
});