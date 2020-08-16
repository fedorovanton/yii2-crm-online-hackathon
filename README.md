CRM система для регистрации участников хакатона.
================================

Проект разделен на две части:
- Фронтэнд - вся публичная часть сайта в /frontend.
- Админ - вся административная часть для администратора /backend.

Подраздел: Роли, разрешения и права.
-------------------------
Стандарные миграции для генерации RBAC от Yii2 (@yii/rbac/migrations) обернуты в свои миграции для удобства.

1. Роли пользователей:
    - "administrator" - главный администратор.
    - ...
    - ...


Раздел: Подготовка и настройка VDS
================================

Требования к серверу и ПО:
--------------------------------

1. Операционная система: CentOS 7
2. Версия языка PHP: 7.3
3. СУБД: MySQL 3.4
4. Веб-сервер: Apache
5. Пакет: git
6. Пакет: composer

Установка:
================================

1. Скачать репозитарий
2. Установить зависимости `composer install`
3. Инициализировать проект `php init`
4. Выполнить миграции `php yii migrate`

Раздел: Разработчик 
================================

Антон, 8 (999) 700-70-03, fedorovau2012@gmail.com