import "./bootstrap";
import { createApp } from "vue";

import TextInput from '../components/TextInput.vue';
import EmailInput from '../components/EmailInput.vue';
import MessageInput from '../components/MessageInput.vue';
import PhoneInput from "../components/PhoneInput.vue";

const app = createApp({
    data() {
        return {
            // Form data
            name: '',
            email: '',
            phone: '',
            fullPhoneNumber: '',
            isValidPhone: false,
            message: '',
            checkbox: false,
            imageUploaded: null,
            errorMessage: '',
            tryingToSubmit: false,
            successMessage: '',
        };
    },
    methods: {
        // Handle country/phone data from PhoneInput component
        handleCountryChange(data) {
            this.fullPhoneNumber = data.fullNumber;
            this.isValidPhone = data.validNumber;
        },
        isValidEmail(email) {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
            return emailPattern.test(email);
        },
        handleFileUpload(event) {
            if (event.target.files && event.target.files[0]) {
                this.imageUploaded = event.target.files[0];
            } else {
                this.imageUploaded = null;
            }
        },
        submitForm() {
            if (!this.name || !this.email || !this.fullPhoneNumber) {
                this.successMessage = '';
                this.errorMessage = "Будь ласка, заповніть всі обов'язкові поля.";
                return;
            }
            if (!this.isValidPhone) {
                this.successMessage = '';
                this.errorMessage = "Будь ласка, введіть правильний номер телефону.";
                return;
            }
            if (this.checkbox) {
                if (!this.imageUploaded) {
                    this.successMessage = '';
                    this.errorMessage = "Будь ласка, завантажте зображення.";
                    return;
                }
            }
            if (this.message.length > 500) {
                this.successMessage = '';
                this.errorMessage = "Повідомлення не може перевищувати 500 символів.";
                return;
            }
            if (!this.isValidEmail(this.email)) {
                this.successMessage = '';
                this.errorMessage = "Будь ласка, введіть дійсну адресу електронної пошти.";
                return;
            }
            this.tryingToSubmit = true;
            this.errorMessage = ''; 

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('phone', this.fullPhoneNumber);
            formData.append('message', this.message);

            // Append the image file if it exists
            if (this.imageUploaded && this.checkbox) {
                formData.append('imageUploaded', this.imageUploaded);
            }
            
            // Send the data using the fetch API
            fetch('/submit-form', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: formData
            }).then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        this.errorMessage = errorData.message;
                    });
                }
                this.successMessage = 'Форма успішно надіслана';
                return response.json();
            }).then(data => {
                console.log(data);
                this.tryingToSubmit = false;
            }).catch((error) => {
                this.errorMessage = error.message;
            });
        }
    }
});


app.component('TextInput', TextInput);
app.component('EmailInput', EmailInput);
app.component('MessageInput', MessageInput);
app.component('PhoneInput', PhoneInput);
app.mount('#app');