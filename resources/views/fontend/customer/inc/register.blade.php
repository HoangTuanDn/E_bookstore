<div class="col-lg-6 col-12">
    <div class="my__account__wrapper">
        <h3 class="account__title">{{__('register')}}</h3>
        <form action="#">
            <div class="account__form">
                <div class="input__box">
                    <label>{{__('username')}} <span>*</span></label>
                    <input type="text" required>
                </div>
                <div class="input__box">
                    <label>{{__('email')}} <span>*</span></label>
                    <input type="email" required>
                </div>
                <div class="input__box">
                    <label>{{__('password')}}<span>*</span></label>
                    <input type="password" required>
                </div>

                <div class="input__box">
                    <label>{{__('re_password')}}<span>*</span></label>
                    <input type="password" required>
                </div>
                <div class="form__btn">
                    <button>{{__('register')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>