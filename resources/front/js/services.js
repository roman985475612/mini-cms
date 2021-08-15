class Accord {
    constructor(selector) {
        const accordion = document.querySelector(selector)
        if (accordion === null) {
            return false
        }

        accordion.addEventListener('click', e => {
            if (!e.target.classList.contains('accord__header')) {
                return false
            }
    
            let accordionItem = e.target.parentNode
    
            let isOpen = accordionItem.classList.contains('accord__item--open')
    
            if (isOpen) {
                this.close(accordionItem)
            } else {
                let openItem = accordion.querySelector('.accord__item--open')
                if (openItem) {
                    this.close(openItem)
                }
                this.open(accordionItem)
            }
        })    
    }

    open(item) {
        item.classList.add('accord__item--open')
    
        let i = item.querySelector('.fas')
        i.classList.remove('fa-angle-down')
        i.classList.add('fa-angle-up')
    }
    
    close(item) {
        item.classList.remove('accord__item--open')
    
        let i = item.querySelector('.fas')
        i.classList.add('fa-angle-down')
        i.classList.remove('fa-angle-up')
    }
}
