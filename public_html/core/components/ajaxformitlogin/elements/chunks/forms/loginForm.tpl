<form>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@mail.ru">
        <small class="text-danger d-block error_email"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" placeholder="Пароль">
        <small class="text-danger d-block error_password"></small>
    </div>


    <button type="submit" class="btn btn-primary">Войти</button>
    <button type="reset" class="btn btn-secondary">Сбросить</button>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{4 | url}" class="cabinet-link">Забыли пароль?</a>
        <a href="{2 | url}" class="cabinet-link">Зарегистрироваться.</a>
    </div>
</form>