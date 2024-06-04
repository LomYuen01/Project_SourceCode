const dropdown = document.querySelector(".dropdown");
const select = dropdown.querySelector(".select");
const caret = dropdown.querySelector(".caret");
const menu = dropdown.querySelector(".menu");
const options = dropdown.querySelectorAll(".menu li");
const selected = dropdown.querySelector(".selected");

document.querySelectorAll(".dropdown").forEach(dropdown => {
    const select = dropdown.querySelector(".select");
    const caret = dropdown.querySelector(".caret");
    const menu = dropdown.querySelector(".menu");

    select.addEventListener("click", () => {
        select.classList.toggle("select-clicked");
        caret.classList.toggle("caret-rotate");
        menu.classList.toggle("menu-open");

        // Add or remove the 'flex' display property
        if (menu.style.display !== 'flex') {
            menu.style.display = 'flex';
            // Scroll to the bottom of the dropdown
            menu.lastElementChild.scrollIntoView(true);
        } else {
            menu.style.display = '';
        }
    });
});

document.querySelectorAll('.checkbox-splash').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var inputBox = this.nextElementSibling.querySelector('input[type="number"]');
        if (this.checked) {
            inputBox.disabled = false;
            inputBox.style.backgroundColor = '#F7F7FF';
            inputBox.style.color = 'black';
            inputBox.style.cursor = 'text';
        } else if (!this.checked) {
            inputBox.disabled = true;
            inputBox.style.backgroundColor = '#F7F7EF';
            inputBox.style.color = '#B0B0B6';
            inputBox.style.cursor = 'not-allowed';
        }
    });
});