function modalHide(){
    document.getElementById('thanks-modal').remove()
}

function slidesPlugin(activeSlide = 0) {
    const slides = document.querySelectorAll(".slide");

    slides[activeSlide].classList.add("active");

    for (const slide of slides) {
        slide.addEventListener("click", () => {
            clearActiveClasses();

            slide.classList.add("active");
        });
    }

    function clearActiveClasses() {
        slides.forEach((slide) => {
            slide.classList.remove("active");
        });
    }
}
if(document.querySelector('#foto-galery')){
    slidesPlugin();
}

function helpFormSubmit(url, formId, error, name, phone){

    let inputName = document.getElementById(name)
    let inputPhone = document.getElementById(phone)

    let errorElement = document.getElementById(error)

    let validate = false
    if(inputName.value == "" || inputName.value.length < 3){
        inputName.classList.add("name-active");
        inputName.placeholder = "Вы не ввели имя";
        validate = true
    }
    if(inputPhone.value == "" || inputPhone.value.length < 5){
        inputPhone.classList.add("name-active");
        inputPhone.placeholder = "Вы не ввели телефон";
        validate = true
    }

    if(validate){
        return false;
    }

    errorElement.innerText = ""
    errorElement.style.display = "none"

    let formElem = document.getElementById(formId)

    let formData = new FormData(formElem)

    let xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.send(formData)

    xhr.onload = () => {
        let result = xhr.response
        result = JSON.parse(result)
        if(result.error){
            errorElement.innerText = result.error
            errorElement.style.display = "block"
            return false
        }

        if (result.success){
            let html = `<div id="thanks-modal"><div class="thanks"><p class="title center">Спасибо за Ваше обращение!</p><p class="modal-text">В течение дня мы с Вами свяжемся</p><button onclick="modalHide()" class="mobal__btn">Продолжить</button></div>
                            <div class="div-hide"></div></div>`
            document.querySelector('body').insertAdjacentHTML('beforeend', html)

            inputName.value = ""
            inputPhone.value = ""
            inputName.classList.remove('name-active')
            inputPhone.classList.remove('name-active')

            errorElement.innerText = ''
            errorElement.style.display = "none"
        }
    };

    xhr.onprogress = () => {
        console.log('Загрузка')
    }

    xhr.onerror = () => {
        load = false
        console.log('Ошибка', xhr.status)
    }
}

if(document.getElementById('foto-filtr')){
    let filtrPhotoBtn = document.getElementById('foto-filtr')
    let filtrPhotoNav = document.getElementById('photo-nav')
    document.addEventListener('click', function (e){
        if(e.target.classList.contains('foto-filtr')){
            filtrPhotoNav.classList.toggle('active')
        }else{
            filtrPhotoNav.classList.remove('active')
        }

    })
}



function getPhotoList(btn, url, id = ''){
    if(id){
        url = url + id
        console.log(id)
    }

    console.log(url)


    let gallery = document.getElementById('foto-galery')

    let xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.send()

    xhr.onload = () => {
        let result = xhr.response

        let content = new DOMParser();

        content = content.parseFromString(result, "text/html").getElementById('foto-galery').querySelectorAll('.foto-galery-wrap');

        gallery.innerHTML = ''

        content.forEach((html)=>{
            gallery.insertAdjacentHTML('beforeend', html.outerHTML)
        })

        let btnContent = new DOMParser();
        btnContent = btnContent.parseFromString(result, "text/html").getElementById('photoMore');

        document.querySelector('.foto-more').innerHTML = btnContent.outerHTML

        let page = btnContent.dataset.page
        let total = btnContent.dataset.total
        let limit = btnContent.dataset.limit

        if(page * limit >= total){
            document.getElementById('photoMore').style.display = 'none'
        }

        document.querySelectorAll('#photo-nav > li').forEach((elem)=>{
            if(elem.dataset.manufacturerId != id){
                elem.classList.remove('item_active')
            }else{
                elem.classList.add('item_active')
            }
        })

        slidesPlugin();

        document.getElementById('foto-filtr').querySelector('p').innerText = btn.querySelector('p').innerText

    }

    xhr.onprogress = () => {
        console.log('Загрузка')
    }

    xhr.onerror = () => {
        load = false
        console.log('Ошибка', xhr.status)
    }

}

function getPhotoPage(btn){
    let photoMore = btn
    let photoPage = document.querySelector('#foto-galery')
    let page = photoMore.dataset.page
    let total = photoMore.dataset.total
    let limit = photoMore.dataset.limit

    let manufacturerId = photoMore.dataset.manufacturerId

    let nextPage = Number(page) + 1

    let url = photoMore.dataset.href + manufacturerId + '&page=' + nextPage

    let load = false

    if(page * limit < total && load == false){
        load = true

        let xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.send()

        xhr.onload = () => {

            photoMore.dataset.page = nextPage
            page = nextPage

            let result = xhr.response
            let content = new DOMParser();

            content = content.parseFromString(result, "text/html").getElementById('foto-galery').querySelectorAll('.foto-galery-wrap');

            content.forEach((html)=>{
                photoPage.insertAdjacentHTML('beforeend', html.outerHTML)
            })

            console.log('Статьи загружены')
            if(page * limit >= total){
                photoMore.style.display = 'none'
            }

            load = false

            slidesPlugin();
        };

        xhr.onprogress = () => {
            console.log('Загрузка')
        }

        xhr.onerror = () => {
            load = false
            console.log('Ошибка', xhr.status)
        }
    }else{
        photoMore.style.display = 'none'
    }
}

document.addEventListener('DOMContentLoaded', function(){


    if(document.getElementById('more-news')){
        let load = false

        let moreNews = document.getElementById('more-news')

        moreNews.addEventListener('click', function (){
            let catalogPage = document.querySelector('#news_page')
            let page = moreNews.dataset.page
            let total = moreNews.dataset.total
            let limit = moreNews.dataset.limit

            let nextPage = Number(page) + 1
            let url = moreNews.dataset.href + nextPage

            if(page * limit < total && load == false){

                let load = true

                let xhr = new XMLHttpRequest();
                xhr.open('POST', url);
                xhr.send()

                xhr.onload = () => {
                    moreNews.dataset.page = nextPage
                    page = nextPage

                    let result = xhr.response
                    let content = new DOMParser();

                    content = content.parseFromString(result, "text/html").getElementById('news_page').querySelectorAll('.news-block__item');

                    content.forEach((html)=>{
                        catalogPage.insertAdjacentHTML('beforeend', html.outerHTML)
                    })

                    console.log('Статьи загружены')
                    if(page * limit >= total){
                        moreNews.style.display = 'none'
                    }

                    load = false
                };

                xhr.onprogress = () => {
                    console.log('Загрузка')
                }

                xhr.onerror = () => {
                    load = false
                    console.log('Ошибка', xhr.status)
                }
            }
        })
    }

    if(document.getElementById('more-btn-category')){
        let load = false

        let productsMore = document.getElementById('more-btn-category')

        productsMore.addEventListener('click', function (){
            let catalogPage = document.querySelector('#catalog-list')
            let page = productsMore.dataset.page
            let total = productsMore.dataset.total
            let limit = productsMore.dataset.limit

            let nextPage = Number(page) + 1
            let url = productsMore.dataset.href + nextPage

            console.log(page, limit, total, load)

            if(page * limit < total && load == false){
                console.log(url)
                let load = true

                let xhr = new XMLHttpRequest();
                xhr.open('POST', url);
                xhr.send()

                xhr.onload = () => {
                    productsMore.dataset.page = nextPage
                    page = nextPage

                    let result = xhr.response
                    let content = new DOMParser();

                    content = content.parseFromString(result, "text/html").getElementById('catalog-list').querySelectorAll('.product');

                    content.forEach((html)=>{
                        catalogPage.insertAdjacentHTML('beforeend', html.outerHTML)
                    })

                    console.log('Статьи загружены')
                    if(page * limit >= total){
                        productsMore.style.display = 'none'
                    }

                    load = false
                };

                xhr.onprogress = () => {
                    console.log('Загрузка')
                }

                xhr.onerror = () => {
                    load = false
                    console.log('Ошибка', xhr.status)
                }
            }
        })
    }

}, false);

