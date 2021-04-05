<div class="col-lg-6 col-12">
    <div class="my__account__wrapper">
        <h3 class="account__title">{{__('login')}}</h3>
        <form action="{{route('account.login')}}">
            <div class="account__form">
                <div class="input__box">
                    <label>{{__('Username_email')}} <span>*</span></label>
                    <input name="username_or_email" autofocus type="text">
                </div>
                <div class="input__box">
                    <label>{{__('password')}}<span>*</span></label>
                    <input name="password" type="text">
                </div>
                <div class="form__btn">
                    <button type="submit">{{__('login')}}</button>
                    <label class="label-for-checkbox">
                        <input id="rememberme" class="input-checkbox" name="rememberme" value="forever" type="checkbox">
                        <span>{{__('remember_me')}}</span>
                    </label>
                </div>
                <a class="forget_pass" href="#">{{__('lost_your_password')}}</a>
            </div>
        </form>
    </div>
</div>