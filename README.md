# ManagerButtons

Компонент для MODX Revolution 3: наборы кнопок и ссылок на панели управления.

Похож по задаче на Quickstart Buttons, сделан для MODX 3 и оформлен через **VueTools** (тема PrimeVue берётся из `vuetools.theme`, своих стилей нет).

## Требования

- MODX 3.0+
- PHP 8.1+
- [VueTools](https://modx.pro/components/25759) 1.2.0+

## Установка

1. Установите VueTools.
2. Скачайте `ManagerButtons-1.0.0-pl.transport.zip` из [`_packages/`](_packages/).
3. В менеджере: **Приложения → Установщик → Загрузить пакет** и установите zip.

После установки:

- пункт меню **ManagerButtons**;
- виджет **ManagerButtons** (ставится на дашборд Default).

## Сборка пакета новой версии

```bash
cd vueManager && npm install && npm run build && cd ..
php _build/pack.php
```

Zip появится в `_packages/`. Для следующей доработки увеличьте версию в `_build/config.inc.php` и `core/components/managerbuttons/src/Service.php`.

## Лицензия

MIT. См. [LICENSE](LICENSE).

Документация для [docs.modx.pro](https://docs.modx.pro/): каталог [`docs/modx.pro/`](docs/modx.pro/).
