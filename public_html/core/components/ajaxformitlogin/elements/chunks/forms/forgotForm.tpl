<form>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@mail.ru">
        <small class="text-danger d-block error_email"></small>
    </div>
    <button type="submit" class="btn btn-primary">Получить пароль</button>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{2 | url}" class="cabinet-link">Нет аккаунта? Зарегистрируйтесь.</a>
    </div>
</form>