<form id="aflExampleForm">
    <div class="mb-3">
        <label class="form-label">Ваше имя</label>
        <input type="text" class="form-control" name="name" placeholder="Иван Иванович">
    </div>
    <div class="mb-3">
        <label class="form-label">Телефон</label>
        <input type="tel" name="phone" class="form-control" placeholder="+7(999)123-45-67">
        <small class="text-danger d-block error_phone"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@mail.ru">
        <small class="text-danger d-block error_email"></small>
    </div>
    <div class="mb-3">
        <label class="form-label">Файл</label>
        <input type="file" name="file" class="form-control" placeholder="">
        <small class="text-danger d-block error_file"></small>
    </div>
    <div class="mb-3 form-check">
        <input type="hidden" name="politics" value="0">
        <input type="checkbox" class="form-check-input" id="politics" data-afl-required="politics">
        <label class="form-check-label" for="politics">Я принимаю <a href="#" target="_blank">условия использования</a> сайта.</label>
        <small class="text-danger d-block error_politics"></small>
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <button type="reset" class="btn btn-secondary">Сбросить</button>
</form>