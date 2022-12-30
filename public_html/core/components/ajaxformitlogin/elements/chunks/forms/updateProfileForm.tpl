{set $extended = $_modx->user.extended}
<form>
    <h4>Персональная информация</h4>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@mail.ru" value="{$_modx->user.email}">
        <small class="text-danger d-block error_email"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">ФИО</label>
        <input type="text" name="fullname" class="form-control" placeholder="Иванов Иван Иванович" value="{$_modx->user.fullname}">
        <small class="text-danger d-block error_email"></small>
    </div>
    <h4>Платёжная информация</h4>
    <div class="mb-3">
        <label class="form-label">Расчётный счёт</label>
        <input type="text" name="extended_rs" class="form-control" placeholder="1234567890" value="{$extended.rs}">
        <small class="text-danger d-block error_extended_rs"></small>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>