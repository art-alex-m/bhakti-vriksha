<?php
/**
 * app.php
 *
 * Файл переводов интерфейса на русский язык
 *
 * Created by PhpStorm.
 * @date 14.08.18
 * @time 13:23
 * @since 1.0.0
 */

return [
    'Login' => 'Войти',
    'System login' => 'Вход в систему',
    'Sign up' => 'Регистрация',
    'Logout ({name})' => 'Выйти ({name})',
    'BV' => 'БВ',
    'Password reset' => 'Восстановление пароля',
    /// app/models/LoginForm.php
    'Username' => 'Логин',
    'Password' => 'Пароль',
    'Remember me' => 'Запомнить меня',
    'Incorrect username or password' => 'Неправильный логин или пароль',
    /// app/models/RegistrationCode.php
    'Code' => 'Код',
    'Code is invalid' => 'Неверный код регистрации',
    /// app/models/Profile.php
    'Last name' => 'Фамилия',
    'First name' => 'Имя',
    'Parent name' => 'Отчество',
    'Phone number' => 'Контактный телефон',
    '{attribute} should be valid Russian phone number' =>
        '{attribute} номер должен быть российским номером телефона',
    'Please use russian phone mask 712345...' => 'Пожалуйста, используете маску 712345...',
    /// app/models/Residence.php
    'City' => 'Город',
    /// app/models/Japa.php
    'Number of circles' => 'Количество кругов',
    /// app/models/Token.php
    'Token expired time should be greater then now' =>
        'Срок действия токена должен быть больше, чем текущее время',
    /// app/models/SignupForm.php
    'This username address has already been taken' =>
        'Этот адрес электронной почты уже используется',
    'Confirmation and password should be the same' => 'Пароль и повтор пароля должны совпадать',
    'Password confirmation' => 'Повтор пароля',
    'Email (login)' => 'Email (логин в системе)',
    /// app/controllers/RegistrationController.php
    'Registration activation' => 'Активация регистрации',
    'Cannot create registration activation token for user #{id}' =>
        'Ошибка при создании токена активации регистрации для пользователя #{id}',
    'Cannot send registration activation email for user #{id}. Please contact with administrator' =>
        'Ошибка при отпраке письма с токеном активации для пользователя #{id}. Пожалуйста, свяжитесь с администратором',
    'Wrong activation token' => 'Неверный токен активации регистрации',
    'Your account has been successfully activated' =>
        'Ваша учетная запись была успешно активирована',
    /// app/models/PwdResetRequestForm.php
    'There is no user with such email' =>
        'Пользователя с таким адресом электронной почты не найдено',
    'Cannot send email with error: {error}' => 'Ошибка при отправке письма: {error}',
    'Cannot create password reset token with error: {error}' =>
        'Ошибка при создании токена сброса пароля: {error}',
    'Password reset for {app}' => 'Сброс пароля для {app}',
    /// app/controllers/SiteController.php
    'Please check your email' => 'Пожалуйста, проверьте вашу почту',
    'Your password was changed' => 'Ваш пароль был успешно изменен',
    // app/models/PwdResetForm.php
    'Password reset token cannot be blank' => 'Токен сброса пароля должен быть передан',
    'Wrong password reset token' => 'Ошибочный токен сброса пароля',
    /// app/controllers/JapaController.php
    'This month the data has already been entered' => 'В этом месяце данные о джапе уже были введены',
    'Add new japa entry' => 'Добавлена новая информация по чтению джапы',
    'Japa entry {d} was updated' => 'Запись джапы {d} была обновлена',
    'Model not found by id #{id}' => 'По идентификатору #{id} запись не найдена',
    /// app/views/japa/index.php
    'JAPA_DAYS_LEFT' => '{n, plural, =1{# день} one{# день} few{# дня} other{# дней}}',
    'JAPA_HOURS_LEFT' => '{n, plural, =1{# час} one{# час} few{# часа} other{# часов}}',
    'JAPA_MIN_LEFT' => '{n, plural, =1{# минута} one{# минута} few{# минуты} other{# минут}}',
    /// app/controllers/ProfileController.php
    'Profile was updated' => 'Профиль изменен',
];