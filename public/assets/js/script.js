let burger = document.querySelector('.burger');

let burgerDivDeroulant = document.querySelector('.burgerDivDeroulant');
let burgerA = document.querySelector('.burgerA');
burger.addEventListener('click', function(){
    burgerDivDeroulant.classList.toggle('translate0')
});

let popUp = document.querySelector('.panier');
popUp.addEventListener('click', function(){
    popUp = window.alert('La page à venir est en construction!');
})
