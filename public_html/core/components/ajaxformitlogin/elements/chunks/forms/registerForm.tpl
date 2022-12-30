<form>
    <div class="mb-3">
        <label class="form-label">Ваше имя</label>
        <input type="text" class="form-control" name="fullname" placeholder="Иван Иванович">
        <small class="text-danger d-block error_fullname"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@mail.ru">
        <small class="text-danger d-block error_email"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Пароль (если оставить пустым - сгенерируем сами и вышлем на почту)</label>
        <input type="password" name="password" class="form-control" placeholder="Пароль">
        <small class="text-danger d-block error_password"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Повторите пароль</label>
        <input type="password" name="password_confirm" class="form-control" placeholder="Подтверждение пароля">
        <small class="text-danger d-block error_password_confirm"></small>
    </div>
    <div class="mb-3 form-check">
        <input type="hidden" name="politics" value="0">
        <input type="checkbox" class="form-check-input" id="politics" data-afl-required="politics">
        <label class="form-check-label" for="politics">Я принимаю <a href="#" target="_blank">условия использования</a> сайта.</label>
        <small class="text-danger d-block error_politics"></small>
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <button type="reset" class="btn btn-secondary">Сбросить</button>
    <div class="d-flex justify-content-end align-items-center">
        <a href="{3 | url}" class="cabinet-link">Уже есть аккаунт? Войдите.</a>
    </div>
</form>