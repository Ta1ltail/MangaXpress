const menu_btn = document.getElementById('menu-btn');
const popup_menu = document.getElementById('popup-navbar');

const user_btn = document.getElementById('user-btn');
const popup_user = document.getElementById('popup-user'); // select the single user-box

menu_btn.addEventListener('click', function() {
    popup_menu.classList.toggle('active');

    // Hide user popup if open
    if (popup_user && popup_user.classList.contains('active')) {
        popup_user.classList.remove('active');
    }
});

user_btn.addEventListener('click', function() {
    if (popup_user) {
        popup_user.classList.toggle('active');
    }

    // Hide menu if open
    if (popup_menu.classList.contains('active')) {
        popup_menu.classList.remove('active');
    }
});

// Optional: click outside to close
document.addEventListener('click', function(e) {
    if (!user_btn.contains(e.target) && !popup_user.contains(e.target)) {
        popup_user.classList.remove('active');
    }
    if (!menu_btn.contains(e.target) && !popup_menu.contains(e.target)) {
        popup_menu.classList.remove('active');
    }
});
