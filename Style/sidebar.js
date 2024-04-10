$(document).ready(function() {
    const modeSwitch = $('.toggle-switch');
    const body = $("body");
    const modeText = $(".mode-text");

    // Load mode from localStorage
    const savedMode = localStorage.getItem('mode');
    if (savedMode) {
        body.addClass(savedMode);
        modeText.text(savedMode === 'dark' ? 'Light Mode' : 'Dark Mode');
    }

    // When the mode switch button is clicked
    modeSwitch.click(function() {
        // If the current mode is light
        if (body.hasClass('light')) {
            // Switch to dark mode with a transition
            body.switchClass('light', 'dark', 200000); // 200000 is the duration in milliseconds

            // Save the user's choice
            localStorage.setItem('mode', 'dark');
            modeText.text('Light Mode');
        } else {
            // Otherwise, switch to light mode with a transition
            body.switchClass('dark', 'light', 200000); // 200000 is the duration in milliseconds

            // Save the user's choice
            localStorage.setItem('mode', 'light');
            modeText.text('Dark Mode');
        }
    });

    const sidebar = body.find(".sidebar");
    const toggle = body.find(".toggle");

    toggle.click(function() {
        sidebar.toggleClass("close");
        // Save sidebar state to localStorage
        localStorage.setItem('sidebar', sidebar.hasClass("close") ? 'close' : 'open');
    });

    modeSwitch.click(function() {
        body.toggleClass("dark");
        // Save mode to localStorage
        localStorage.setItem('mode', body.hasClass("dark") ? 'dark' : 'light');
    });

    // Get all menu items
    var menuItems = $('.menu-links li');

    // Add click event listener to each menu item
    menuItems.click(function() {
        // Remove active class from all menu items
        menuItems.removeClass('active');

        // Add active class to clicked menu item
        $(this).addClass('active');
    });
});