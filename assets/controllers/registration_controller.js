// assets/controllers/registration_controller.js

import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ['form', 'password', 'passwordStrength', 'passwordFeedback']

    connect() {
        console.log('Registration controller connected')
        this.initializeValidation()
        this.setupPasswordStrength()
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

        // Real-time validation for all form fields
        this.formTarget.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', this.validateField.bind(this))
        })
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

    setupPasswordStrength() {
        if (this.hasPasswordTarget) {
            this.passwordTarget.addEventListener('input', this.updatePasswordStrength.bind(this))
        }
    }

    updatePasswordStrength() {
        const password = this.passwordTarget.value
        const strength = this.calculatePasswordStrength(password)
        
        this.passwordStrengthTarget.className = 'password-strength'
        this.passwordStrengthTarget.classList.add(strength.level)
        
        this.passwordFeedbackTarget.textContent = strength.message
        this.passwordFeedbackTarget.className = `password-feedback text-${strength.color}`
    }

    calculatePasswordStrength(password) {
        let score = 0
        
        if (password.length >= 8) score++
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) score++
        if (password.match(/\d/)) score++
        if (password.match(/[^a-zA-Z\d]/)) score++

        switch (score) {
            case 0:
            case 1:
                return { level: 'weak', color: 'danger', message: 'Weak password' }
            case 2:
                return { level: 'fair', color: 'warning', message: 'Fair password' }
            case 3:
                return { level: 'strong', color: 'success', message: 'Strong password' }
            case 4:
                return { level: 'strong', color: 'success', message: 'Very strong password' }
            default:
                return { level: 'weak', color: 'danger', message: 'Weak password' }
        }
    }

    // Demo data for development
    fillDemoData() {
        if (process.env.NODE_ENV === 'development') {
            const usernameField = this.formTarget.querySelector('#registration_form_username')
            const passwordField = this.formTarget.querySelector('#registration_form_plainPassword')
            const termsField = this.formTarget.querySelector('#registration_form_agreeTerms')
            
            if (usernameField) usernameField.value = 'demo_user'
            if (passwordField) {
                passwordField.value = 'demopass123'
                this.updatePasswordStrength()
            }
            if (termsField) termsField.checked = true
            
            // Update validation states
            this.formTarget.querySelectorAll('input').forEach(input => {
                this.updateFieldValidation(input)
            })
        }
    }
}