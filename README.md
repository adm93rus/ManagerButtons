# ManagerButtons

Группы кнопок и ссылок на панели управления MODX 3.

Набор выглядит как сетка из четырёх колонок. Кнопка ведёт в раздел менеджера или на внешний адрес. Кто видит набор, задаётся группами пользователей: администраторы видят все наборы.

Интерфейс собран на [VueTools](https://modx.pro/components/25759). Тема берётся из настройки `vuetools.theme`.

## Требования

- MODX 3.0+
- PHP 8.1+
- VueTools 1.2.0+

## Установка

1. Установите VueTools.
2. Возьмите `ManagerButtons-1.2.1-pl.transport.zip` из [`_packages/`](_packages/).
3. В менеджере откройте **Приложения → Установщик**, загрузите архив и установите пакет.

В меню **Приложения** появится пункт **ManagerButtons**. На дашборд Default ставится виджет с тем же именем. Если пункта меню нет, выйдите из панели и войдите снова.

Инструкция: [docs.modx.pro/components/managerbuttons](https://docs.modx.pro/components/managerbuttons). Текст для магазина и превью лежат в [`docs/modstore/`](docs/modstore/).

## Сборка

```bash
cd vueManager && npm install && npm run build && cd ..
php _build/pack.php
```

Версия задаётся в `_build/config.inc.php` и `core/components/managerbuttons/src/Service.php`.

## Лицензия

MIT. Текст лицензии: [LICENSE](LICENSE).
