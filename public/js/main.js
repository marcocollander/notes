
const hamburger = document.querySelector('.hamburger');
const menu = document.querySelector('.menu');
const hamburgerItems = document.querySelectorAll('.hamburger__item');

hamburger.addEventListener('click', ()=> {
    hamburgerItems[0].classList.toggle('hamburger__item--rotate');
    hamburgerItems[1].classList.toggle('hamburger__item--reverse');
    hamburgerItems[2].classList.toggle('hamburger__item--non_display');
    menu.classList.toggle('menu--active');
});
