import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
document.addEventListener('DOMContentLoaded', () => {
    const body = document.querySelector("body");
    const modal = document.querySelector(".auth-modal");
    const modalButton = document.querySelector(".auth-modal-button");
    const closeButton = document.querySelector(".close-button");
    const scrollDown = document.querySelector(".scroll-down");
    let isOpened = false;

    const openModal = () => {
        modal.classList.add("is-open");
        body.style.overflow = "hidden";
    };

    const closeModal = () => {
        modal.classList.remove("is-open");
        body.style.overflow = "initial";
    };

    window.addEventListener("scroll", () => {
        if (window.scrollY > window.innerHeight / 3 && !isOpened) {
            isOpened = true;
            if (scrollDown) scrollDown.style.display = "none";
            openModal();
        }
    });

    if (modalButton) modalButton.addEventListener("click", openModal);
    if (closeButton) closeButton.addEventListener("click", closeModal);

    document.onkeydown = evt => {
        evt = evt || window.event;
        evt.keyCode === 27 ? closeModal() : false;
    }

    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('auth-container');

    if (signUpButton && container) {
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });
    }

    if (signInButton && container) {
        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    }
});
Alpine.start();
