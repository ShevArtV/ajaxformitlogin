<form>
    <h4>Изменение пароля</h4>
    <div class="mb-3">
        <label class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" placeholder="Пароль">
        <small class="text-danger d-block error_password"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Повторите пароль</label>
        <input type="password" name="password_confirm" class="form-control" placeholder="Подтверждение пароля">
        <small class="text-danger d-block error_password_confirm"></small>
    </div>
    <button type="submit" class="btn btn-primary">Изменить</button>
</form>