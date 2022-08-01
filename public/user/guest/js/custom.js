/** @format */

// tabs
const tabsBtn = document.querySelectorAll('[data-btn]');
const tabs = document.querySelectorAll('[data-tab]');

tabsBtn.forEach((tabBtn) => {
  tabBtn.addEventListener('click', (e) => {
    if (tabBtn.dataset.btn === '1') {
      tabsBtn[0].classList.add('active');
      tabsBtn[1].classList.remove('active');
      tabsBtn[2].classList.remove('active');
      tabs[0].classList.remove('hide');
      tabs[1].classList.add('hide');
      tabs[2].classList.add('hide');
    } else if (tabBtn.dataset.btn === '2') {
      tabsBtn[0].classList.remove('active');
      tabsBtn[1].classList.add('active');
      tabsBtn[2].classList.remove('active');
      tabs[0].classList.add('hide');
      tabs[1].classList.remove('hide');
      tabs[2].classList.add('hide');
    } else if (tabBtn.dataset.btn === '3') {
      tabsBtn[0].classList.remove('active');
      tabsBtn[1].classList.remove('active');
      tabsBtn[2].classList.add('active');
      tabs[0].classList.add('hide');
      tabs[1].classList.add('hide');
      tabs[2].classList.remove('hide');
    }
  });
});

const fill1 = document.querySelector('ul.steps #fil1');
const fill2 = document.querySelector('ul.steps #fil2');
const fill3 = document.querySelector('ul.steps #fil3');
const changeBtn1 = document.querySelector('#one');
const changeBtn2 = document.querySelector('#two');
const changeBtn3 = document.querySelector('#three');
const formStep1 = document.querySelector('.form-step1');
const formStep2 = document.querySelector('.form-step2');
const formStep3 = document.querySelector('.form-step3');
changeBtn1.addEventListener('click', (e) => {
  e.preventDefault;
  formStep1.classList.add('hide');
  fill1.classList.add('fill');
  fill2.classList.add('done');
  formStep2.classList.remove('hide');
  formStep3.classList.add('hide');
});
changeBtn2.addEventListener('click', (e) => {
  e.preventDefault;
  formStep1.classList.add('hide');
  fill2.classList.add('fill');
  fill3.classList.add('done');
  formStep2.classList.add('hide');
  formStep3.classList.remove('hide');
});
