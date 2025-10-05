// assets/controllers/login_controller.js

import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ['form', 'username', 'password']

    connect() {
        console.log('Login controller connected')
        this.initializeValidation()
    }

    initializeValidation() {
        // Add Bootstrap validation styles on form submission
        this.formTarget.addEventListener('submit', (event) => {
            if (!this.formTarget.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            this.formTarget.classList.add('was-validated')
        })

        // Real-time validation
        this.usernameTarget.addEventListener('input', this.validateField.bind(this))
        this.passwordTarget.addEventListener('input', this.validateField.bind(this))
    }

    validateField(event) {
        const field = event.target
        this.updateFieldValidation(field)
    }

    updateFieldValidation(field) {
        if (field.value === '') {
            field.classList.remove('is-valid', 'is-invalid')
        } else if (field.checkValidity()) {
            field.classList.remove('is-invalid')
            field.classList.add('is-valid')
        } else {
            field.classList.remove('is-valid')
            field.classList.add('is-invalid')
        }
    }

    // Demo credentials for development
    fillDemoCredentials() {
        if (process.env.NODE_ENV === 'development') {
            this.usernameTarget.value = 'admin@example.com'
            this.passwordTarget.value = 'password'
            this.updateFieldValidation(this.usernameTarget)
            this.updateFieldValidation(this.passwordTarget)
        }
    }
}