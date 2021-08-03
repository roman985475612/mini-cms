class AddModal {
    constructor(params) {
        this.modalId = params.btnId + 'Modal'
        this.btn = document.getElementById(params.btnId)
        this.btn.addEventListener('click', e => {
            this.modal = document.getElementById(this.modalId)
            if (this.modal == null) {
                this.createModal(params)
                this.modal = document.getElementById(this.modalId)
            }
            
            this.showModal()
        })
    }

    createModal(params) {
        let modalHtml =`
        <div class="modal fade" id="${this.modalId}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ${params.titleClass}">
                        <h5 class="modal-title">${params.title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">${params.body.form}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-${params.btnClass}" data-bs-dismiss="modal">Save changes</button>
                    </div>
                </div>
            </div>
        </div>`

        document.body.insertAdjacentHTML('beforeend', modalHtml)
    }

    showModal() {
        const myModal = new bootstrap.Modal(this.modal, {
            keyboard: true
        })
        myModal.show()
        
        let textarea = document.querySelector( 'textarea' )
        if (textarea) {
            ClassicEditor
                .create(textarea)
                .catch( error => {
                    console.error( error );
                })
        }
    }
}

class Form {
    constructor(url, fields) {
        this.form = `<form method="POST" action="${url}" novalidate>`
        fields.forEach(field => {
            this.form += this[field.name + 'Field'](field.params)  
        });
        this.form += '<button type="submit" class="btn btn-primary">Submit</button>'
        this.form += '</form>'
    }

    inputField(params) {
        return `
        <div class="mb-3">
            <label for="${params.id}" class="form-label">${params.title} <sup>*</sup></label>
            <input 
                name="${params.name}" 
                type="${params.type}" 
                class="form-control" 
                id="${params.id}"
            >
        </div>`
    }

    textField(params) {
        return `
        <div class="mb-3">
            <label for="${params.id}" class="form-label">${params.title}</label>
            <textarea name="${params.name}" class="form-control" id="${params.id}" rows="3"></textarea>
        </div>`
    }

    selectField(params) {
        let output = `
            <div class="mb-3">
                <label for="${params.id}" class="form-label">${params.title}</label>
                <select name="${params.name}" class="form-select">
                    <option selected>Open this select menu</option>`
  
        params.options.forEach(opt => {
            output += `<option value="${opt.value}">${opt.option}</option>`
        })
  
        output += '</select></div>'
        return output
    }
}

new AddModal({
    btnId: 'addPost',
    title: 'Add Post',
    titleClass: 'bg-primary text-white',
    btnClass: 'primary',
    body: new Form('/article-admin/create', [
        {
            name: 'input',
            params: {
                id:'postTitle', 
                type:'text', 
                name:'name', 
                title:'Name'
            }
        },
        {
            'name': 'select',
            'params': {
                id:'postCat', 
                name:'category', 
                title:'Category',
                options: [
                    {value: 0, option: 'Web Development'},
                    {value: 1, option: 'Tech Gadgets'},
                    {value: 2, option: 'Business'},
                    {value: 3, option: 'Health & Wellness'},
                ]
            }
        },
        {
            'name': 'input',
            'params': {
                id:'postImage', 
                type:'file', 
                name:'image', 
                title:'Upload image'
            }
        },
        {
            'name': 'text',
            'params': {
                id:'postBody', 
                name:'body', 
                title:'Body'
            }
        },
   ])
})

new AddModal({
    btnId: 'addCategory', 
    title: 'Add Category',
    titleClass: 'bg-success text-white',
    btnClass: 'success',
    body: new Form('/category/create', [
        {
            'name': 'input',
            'params': {
                id:'postTitle', 
                type:'text', 
                name:'name', 
                title:'Name'
            }
        }
    ])
})

new AddModal({
    btnId: 'addUser', 
    title: 'Add User',
    titleClass: 'bg-warning text-black',
    btnClass: 'warning',
    body: new Form('/user/register', [
        {
            'name': 'input',
            'params': {
                id:'userName', 
                type:'text', 
                name:'user[name]', 
                title:'Name'
            }
        },
        {
            'name': 'input',
            'params': {
                id:'userEmail', 
                type:'email', 
                name:'user[email]', 
                title:'Email'
            }
        },
        {
            'name': 'input',
            'params': {
                id:'userPassword', 
                type:'password', 
                name:'user[password]', 
                title:'Password'
            }
        },
        {
            'name': 'input',
            'params': {
                id:'userConfirmPassword', 
                type:'password', 
                name:'user[password_confirm]', 
                title:'Confirm password'
            }
        },
    ])
})
