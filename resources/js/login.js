document.addEventListener('DOMContentLoaded', function () {
    const mobileForm = document.querySelector('body.login #mobile-form');

    if (mobileForm) {
        let mobileInput = mobileForm.querySelector('input[name=mobile]');
        let sendOtpBtn = mobileForm.querySelector('button');
        let mobileErrorMessage = mobileForm.querySelector('.error-message');
        let verifyForm = document.getElementById('verify-form');
        let otpErrorMessage = verifyForm.querySelector('.error-message');
        let resendOtp = document.getElementById('resend-otp');
        let otpInput = verifyForm.querySelector('input[name=otp]');
        let verifyOtp = verifyForm.querySelector('button');
        let verifyMobile = verifyForm.querySelector('input[name=mobile]');
        let editMobile = document.getElementById('edit-mobile');
        let nameBox = verifyForm.querySelector('.name-box');
        let ageBox = verifyForm.querySelector('.age-box');
        let counter = false;
        let is_foreign = false;

        function showOtpTimer() {
            clearInterval(counter);
            let count = 60;
            let timer = document.getElementById('timer');
            timer.innerText = count;
            count--;
            timer.classList.remove('hidden');
            counter = setInterval(() => {
                timer.innerText = count;
                count--;
                if (count < 0) {
                    clearInterval(counter);
                    timer.classList.add('hidden');
                    resendOtp.classList.remove('opacity-50', 'cursor-not-allowed');
                    resendOtp.classList.add('cursor-pointer');
                }
            }, 1000);
        }

        mobileForm.addEventListener('submit', function (event) {
            event.preventDefault();

            sendOtpBtn.disabled = true;
            mobileInput.disabled = true;
            mobileErrorMessage.classList.add('hidden');
            otpErrorMessage.classList.add('hidden');
            axios
                .post('/login/otp', {
                    mobile: mobileInput.value,
                })
                .then((res) => {
                    verifyMobile.value = mobileInput.value;
                    mobileForm.classList.add('hidden');
                    verifyForm.classList.remove('hidden');
                    if (res.data.data.is_user) {
                        nameBox.classList.add('hidden');
                        ageBox.classList.add('hidden');
                    } else {
                        nameBox.classList.remove('hidden');
                        ageBox.classList.remove('hidden');
                    }
                    if(res.data.data.is_foreign){
                        otpInput.parentElement.remove();
                        resendOtp.parentElement.remove();
                        editMobile.remove();
                    }else {
                        showOtpTimer();
                    }

                })
                .catch((err) => {
                    mobileErrorMessage.innerText = err.status === 422 ? err.response.data.message : 'Connection error!';
                    mobileErrorMessage.classList.remove('hidden');
                    sendOtpBtn.disabled = false;
                    mobileInput.disabled = false;
                });
        });

        verifyForm.addEventListener('submit', function (event) {
            event.preventDefault();

            otpInput.disabled = true;
            verifyOtp.disabled = true;
            axios
                .post('/login/verity', {
                    mobile: mobileInput.value,
                    otp: otpInput.value,
                    name: nameBox.querySelector('input').value,
                    age: ageBox.querySelector('input').value,
                })
                .then((res) => {
                    window.location.href = res.data.data.redirect_url;
                })
                .catch((err) => {
                    let error_message = 'Connection error!';
                    if (err.status === 422) {
                        error_message = '';
                        for (let key in err.response.data.errors) {
                            error_message = error_message + err.response.data.errors[key][0] + ' ';
                        }
                    }
                    otpErrorMessage.innerText = error_message;
                    otpErrorMessage.classList.remove('hidden');
                    otpInput.disabled = false;
                    verifyOtp.disabled = false;
                });
        });

        resendOtp.addEventListener('click', function () {
            otpErrorMessage.innerText = '';
            otpErrorMessage.classList.add('hidden');


            otpInput.value = '';
            axios
                .post('/login/otp', {
                    mobile: mobileInput.value,
                })
                .then((res) => {
                    showOtpTimer();
                    resendOtp.classList.remove('cursor-pointer');
                    resendOtp.classList.add('opacity-50', 'cursor-not-allowed');
                })
                .catch((err) => {
                    let error_message = err.status === 422 ? err.response.data.message : 'Connection error!';
                    // mobileErrorMessage.innerText = error_message;
                    // mobileErrorMessage.classList.remove('hidden');
                    // sendOtpBtn.disabled = false;
                    // mobileInput.disabled = false;
                });
        });

        editMobile.addEventListener('click', function () {
            mobileForm.classList.remove('hidden');
            verifyForm.classList.add('hidden');
            sendOtpBtn.disabled = false;
            mobileInput.disabled = false;
        });
    }
});
