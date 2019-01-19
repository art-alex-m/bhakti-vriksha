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
    'Sign up' => 'Регистрация',
    'Logout ({name})' => 'Выйти ({name})',
    'BV' => 'БВ.Мониторинг',
    'Password reset' => 'Восстановление пароля',
    'City of residence' => 'Город',
    'Label' => 'Название',
    'User #{0} profile' => 'Профиль пользователя #{0}',
    'Model "{0}" was created' => 'Запись "{0}" была создана',
    'Model "{0}" was deleted' => 'Запись "{0}" была успешно удалена',
    'Model "{0}" was updated' => 'Запись "{0}" была обновлена',
    'Model "{0}" could not be deleted' => 'Запись "{0}" не может быть удалена',
    'Model "{0}" was archived' => 'Запись "{0}" была переведа в архив',
    /// app/models/User.php
    'Status' => 'Статус',
    /// app/models/UsersSearch.php
    'New' => 'Новый',
    'Active' => 'Активный',
    'Blocked' => 'Заблокирован',
    'Blocked by user' => 'Заблокирован пользователем',
    /// app/models/City.php
    'Archive' => 'В архиве',
    'Title' => 'Заголовок',
    /// app/components/StatTypes.php
    'System login' => 'Вход в систему',
    'User logout' => 'Выход из системы',
    'Circles input' => 'Ввод кругов',
    'Account block' => 'Блокировка учетной записи',
    'New user' => 'Регистрация в системе',
    /// app/models/LoginForm.php
    'Username' => 'Email (логин в системе)',
    'Password' => 'Пароль',
    'Remember me' => 'Запомнить меня',
    'Incorrect username or password' => 'Неправильный логин или пароль',
    'Created at' => 'Дата создания',
    'Updated at' => 'Дата обновления',
    'User ID' => 'Идентификатор пользователя',
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
    'FIO' => 'ФИО',
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
    'Cannot send registration email with activation information for user #{id}. '
    . 'Please, use correct email address or contact with administrator. '
    . 'Your registration was aborted' => 'Ошибка при отправке письма с информацией по активации для пользователя #{id}. '
        . 'Пожалуйста, используейте существующий адрес электронной почты, либо свяжитесь с администратором. '
        . 'Ваша регистрация отменена',
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
    /// app/models/ContactForm.php
    '{app} contact message from {username}' => '{app}. Сообщение с сайта от {username}',
    'Message' => 'Сообщение',
    'Holly name market' => 'Рынок Святого Имени',
    /// app/controllers/ContactController.php
    'Your request has been sent' => 'Ваше обращение было отправлено',
    /// app/controllers/RegcodeController.php
    'Registration code #{0} was created' => 'Был создан код регистрации #{0}',
    /// app/controllers/C3ChartController.php
    'Total participants' => 'Всего участников',
    'Total circles' => 'Всего кругов',
    'In previous period' => 'За прошлый',
    'In current period' => 'В текущем',
    /// app/rbac/Roles.php
    'Super administrator' => 'Администратор',
    'BV participant' => 'Участник БВ',
    'The leader of the group' => 'Слуга-лидер группы',
    'The coordinator of the sector' => 'Слуга-лидер сектора',
    'The coordinator of the district' => 'Слуга-лидер округа',
    'The coordinator of the area' => 'Слуга-лидер маха-округа',
    'The coordinator of the city' => 'Слуга-лидер города',
    'The coordinator of the region' => 'Слуга-лидер региона',
    'Coordinator of Russian BV' => 'Слуга-лидер русскоязычной БВ',
    /// app/controllers/UserController.php
    'User #{0} roles were updated' => 'Роли пользователя #{0} были обновлены',
    'User #{0} status was updated' => 'Статус пользователя #{0} был обновлен',
    'Your account {0} was blocked' => 'Ваша учетная запись {0} была заблокирована',
    /// app/models/RoleChangeForm.php
    'The role "{role}" is not available for assignment with your permissions' =>
        'Роль "{role} " недоступна для назначения с вашими разрешениями',
    'Roles' => 'Роль',
];