--------------------
AjaxFormitLogin
--------------------
Author: Shevchenko Artur <shev.art.v@yandex.ru>
--------------------

Simple component for MODX Revolution, that allows you to send any form through ajax.

!!!ВАЖНО!!! При установке компонент так же будут установлены pdoTools и FormIt. При этом нужно самостоятельно включить Fenom на страницах. Для этого в системных настройках нужно найти ключ pdotools_fenom_parser и установить значение ДА.

Отличия от AjaxForm:
1. Нет jQuery.
2. Для показа уведомлений используется библиотека IziToast.
3. Принимает параметр clearFieldsOnSuccess, тем самым позволяя управлять очисткой полей при успешной оправке формы.
4. Принимает параметр transmittedParams (значение должно быть валидным JSON), который позволяете передавать в JS кастомные параметры отдельно при успешной, отдельно при неудачной отправке.
5. Позволяет отображать процесс загрузки файлов на сервер, для этого нужно указать параметр showUploadProgress со значением 1.
6. Событие af_complete заменено на afl_complete.
<code>
document.addEventListener('afl_complete', e => {
    console.log(e.detail.response); // ответ сервера
    console.log(e.detail.form); // текущая форма
});
</code>
7. Изменен формат ответа сервера.
8. Работают редиректы. Для этого необходимо указать параметр redirectTo (абсолютная ссылка или ID ресурса) и, при необходимости изменить стандартное значение в 2с, redirectTimeout (в милисекундах) для задания задержки перед переходом на другую страницу.
9. Добавлен метод помогающий валидировать чекбоксы. Для его работы необходимо проверяемому чекбоксу добавить атрибут data-afl-required, где значением будет ключ указанный в параметре validate, а также нужно добавить скрытое поле с этим именем в форму. Самому чекбоксу имя можно не указывать.
10. Нет поддержки капчи от гугла, но встроена собственная защита от спама по методу Алексея Смирнова. Для активации нужно в вызове указать параметр spamProtection со значением 1.
11. Есть возможность регистрации, авторизации, сброса пароля и редактирования личных данных, при условии установки компонента FormIt. Подробнее о поддерживаемых параметрах можно прочитать <a href="https://modx.pro/solutions/22936">в этой заметке</a>
12. При обновлении данных пользователя добавлено системное событие aiOnUserUpdate, которое получает следующие данные $user - объект обновленного пользователя, $profile - его профиль, $data - переданные данные.
13. Есть автоматическая отправка целей в Яндекс.Метрику. Чтобы это работало нужно установить системную настройку afl_metrics в значение ДА. Указать в системной настройке afl_counter_id идентификатор используемого на сайте счётчика метрики. Вставить код самого счётчика на сайт. Добавить в вызов сниппет параметр ym_goal, в котором нужно указать имя JS цели из Яндекс.Метрики.

Возможные сценарии использования (в скобках указан путь к файлу с примером, который будет загружен вместе с компонентом):
1. Отправка формы еа указанный email (core/components/ajaxformitlogin/elements/templates/index.tpl);
2. Регистрация пользователя на сайте (core/components/ajaxformitlogin/elements/templates/register.tpl);
3. Авторизация пользователя на сайте (core/components/ajaxformitlogin/elements/templates/auth.tpl);
4. Сброс пароля (core/components/ajaxformitlogin/elements/templates/forgot.tpl);
5. Редактирование данных пользователя (core/components/ajaxformitlogin/elements/templates/personal_data.tpl);
6. Выход из аккаунта пользователя (core/components/ajaxformitlogin/elements/templates/personal_data.tpl);
7. Смена пароля (core/components/ajaxformitlogin/elements/templates/personal_data.tpl);
8. Активация пользователя (core/components/ajaxformitlogin/elements/templates/index.tpl);
9. Вызов любого сниппета через Ajax.
--------------------
Feel free to suggest ideas/improvements/bugs on GitHub:
https://github.com/ShevArtV/ajaxformitlogin/issues