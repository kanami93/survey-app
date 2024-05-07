const form = document.querySelector('form');
const button = document.querySelector('.submit-btn');
form.addEventListener('submit', ()=>{
    button.disabled = true;
});
