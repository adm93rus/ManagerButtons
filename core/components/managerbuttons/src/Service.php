<?php

namespace ManagerButtons;

use ManagerButtons\Model\Button;
use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Model\GroupUserGroup;
use MODX\Revolution\modManagerController;
use MODX\Revolution\modUserGroup;
use MODX\Revolution\modX;

class Service
{
    public const VERSION = '1.1.0-pl';
    public const PACKAGE = 'ManagerButtons';
    public const NAMESPACE = 'managerbuttons';
    public const ADMIN_GROUP = 'Administrator';
    public const EXPORT_FORMAT = 1;

    public modX $modx;
    public array $config = [];

    public function __construct(modX $modx, array $config = [])
    {
        $this->modx = $modx;
        $corePath = rtrim((string) $modx->getOption(
            'managerbuttons.core_path',
            $config,
            $modx->getOption('core_path') . 'components/managerbuttons/'
        ), '/') . '/';
        $assetsUrl = rtrim((string) $modx->getOption(
            'managerbuttons.assets_url',
            $config,
            $modx->getOption('assets_url') . 'components/managerbuttons/'
        ), '/') . '/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl . 'connector.php',
            'templatesPath' => $corePath . 'templates/',
            'version' => self::VERSION,
            'namespace' => self::NAMESPACE,
        ], $config);
    }

    public function versionedAsset(string $path): string
    {
        $path = ltrim($path, '/');
        $url = $this->config['assetsUrl'] . $path;
        $full = rtrim((string) $this->modx->getOption('assets_path'), '/')
            . '/components/managerbuttons/' . $path;
        $v = is_file($full) ? (string) filemtime($full) : self::VERSION;

        return $url . '?v=' . rawurlencode($v);
    }

    public function isAdministrator(?int $userId = null): bool
    {
        $user = $userId ? $this->modx->getObject(\MODX\Revolution\modUser::class, $userId) : $this->modx->user;
        if (!$user) {
            return false;
        }
        if ((int) $user->get('sudo') === 1) {
            return true;
        }

        return $user->isMember(self::ADMIN_GROUP);
    }

    /**
     * Settings page and connectors. Administrators always pass.
     * Other manager users pass when the managerbuttons permission is granted.
     */
    public function canManage(): bool
    {
        $user = $this->modx->user;
        if (!$user || !$user->hasSessionContext('mgr')) {
            return false;
        }
        if ($this->isAdministrator()) {
            return true;
        }

        return (bool) $this->modx->hasPermission('managerbuttons');
    }

    /**
     * @return list<int>
     */
    public function getUserGroupIds(?int $userId = null): array
    {
        $user = $userId ? $this->modx->getObject(\MODX\Revolution\modUser::class, $userId) : $this->modx->user;
        if (!$user) {
            return [];
        }
        $ids = [];
        foreach ($user->getUserGroups() as $id) {
            $ids[] = (int) $id;
        }

        return array_values(array_unique($ids));
    }

    public function canAccessGroup(int $groupId, ?int $userId = null): bool
    {
        if ($this->isAdministrator($userId)) {
            return true;
        }
        $assigned = $this->getAssignedUserGroupIds($groupId);
        if ($assigned === []) {
            return false;
        }
        $memberOf = $this->getUserGroupIds($userId);

        return (bool) array_intersect($assigned, $memberOf);
    }

    /**
     * @return list<int>
     */
    public function getAssignedUserGroupIds(int $groupId): array
    {
        $ids = [];
        $links = $this->modx->getCollection(GroupUserGroup::class, ['group_id' => $groupId]);
        foreach ($links as $link) {
            $ids[] = (int) $link->get('usergroup_id');
        }

        return array_values(array_unique($ids));
    }

    /**
     * @param list<int> $usergroupIds
     */
    public function syncGroupUserGroups(int $groupId, array $usergroupIds): void
    {
        $usergroupIds = array_values(array_unique(array_map('intval', $usergroupIds)));
        $this->modx->removeCollection(GroupUserGroup::class, ['group_id' => $groupId]);
        foreach ($usergroupIds as $ugId) {
            if ($ugId <= 0) {
                continue;
            }
            $link = $this->modx->newObject(GroupUserGroup::class);
            $link->fromArray([
                'group_id' => $groupId,
                'usergroup_id' => $ugId,
            ], '', true);
            $link->save();
        }
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    public function getGroupUserGroups(int $groupId): array
    {
        $out = [];
        $links = $this->modx->getCollection(GroupUserGroup::class, ['group_id' => $groupId]);
        foreach ($links as $link) {
            $ugId = (int) $link->get('usergroup_id');
            $ug = $this->modx->getObject(modUserGroup::class, $ugId);
            if (!$ug) {
                continue;
            }
            $out[] = [
                'id' => $ugId,
                'name' => (string) $ug->get('name'),
            ];
        }
        usort($out, static fn ($a, $b) => strcasecmp($a['name'], $b['name']));

        return $out;
    }

    /**
     * @param list<int> $ids
     */
    public function sortGroups(array $ids): void
    {
        foreach (array_values($ids) as $rank => $id) {
            $object = $this->modx->getObject(ButtonGroup::class, (int) $id);
            if ($object) {
                $object->set('rank', (int) $rank);
                $object->save();
            }
        }
    }

    /**
     * @param list<int> $ids
     */
    public function sortButtons(int $groupId, array $ids): void
    {
        foreach (array_values($ids) as $rank => $id) {
            $object = $this->modx->getObject(Button::class, [
                'id' => (int) $id,
                'group_id' => $groupId,
            ]);
            if ($object) {
                $object->set('rank', (int) $rank);
                $object->save();
            }
        }
    }

    public function nextGroupRank(): int
    {
        $c = $this->modx->newQuery(ButtonGroup::class);
        $c->select('MAX(rank)');
        $max = $this->modx->getValue($c->prepare());

        return ((int) $max) + 1;
    }

    public function nextButtonRank(int $groupId): int
    {
        $c = $this->modx->newQuery(Button::class);
        $c->where(['group_id' => $groupId]);
        $c->select('MAX(rank)');
        $max = $this->modx->getValue($c->prepare());

        return ((int) $max) + 1;
    }

    public function normalizeCols(mixed $cols): int
    {
        $cols = (int) $cols;
        if ($cols < 1) {
            $cols = 1;
        }
        if ($cols > 4) {
            $cols = 4;
        }

        return $cols;
    }

    public function resolveUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '#';
        }
        if (preg_match('#^(javascript|data|vbscript):#i', $url)) {
            return '#';
        }
        if (preg_match('#^(https?:)?//#i', $url) || preg_match('#^(mailto|tel):#i', $url)) {
            return $url;
        }
        $managerUrl = (string) $this->modx->getOption('manager_url', null, '/manager/');
        if (str_starts_with($url, '?') || str_starts_with($url, '#')) {
            return $managerUrl . $url;
        }
        if (str_starts_with($url, '/')) {
            return $url;
        }

        return $managerUrl . ltrim($url, '/');
    }

    /**
     * @return array<string, mixed>
     */
    public function exportGroup(ButtonGroup $group): array
    {
        $buttons = [];
        $c = $this->modx->newQuery(Button::class);
        $c->where(['group_id' => $group->get('id')]);
        $c->sortby('rank', 'ASC');
        $c->sortby('id', 'ASC');
        foreach ($this->modx->getIterator(Button::class, $c) as $button) {
            $buttons[] = [
                'name' => (string) $button->get('name'),
                'url' => (string) $button->get('url'),
                'icon' => Icons::normalizeName((string) $button->get('icon')),
                'cols' => $this->normalizeCols($button->get('cols')),
                'rank' => (int) $button->get('rank'),
            ];
        }

        $usergroups = [];
        foreach ($this->getGroupUserGroups((int) $group->get('id')) as $ug) {
            $usergroups[] = $ug['name'];
        }

        return [
            'package' => self::PACKAGE,
            'format' => self::EXPORT_FORMAT,
            'version' => self::VERSION,
            'exported_at' => date('c'),
            'group' => [
                'name' => (string) $group->get('name'),
                'usergroups' => $usergroups,
                'buttons' => $buttons,
            ],
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function importGroup(array $payload, bool $asCopy = false): ButtonGroup
    {
        $data = $payload['group'] ?? $payload;
        if (!is_array($data) || empty($data['name'])) {
            throw new \InvalidArgumentException($this->modx->lexicon('managerbuttons_err_import_format'));
        }
        $name = trim((string) $data['name']);
        if ($asCopy || $this->modx->getCount(ButtonGroup::class, ['name' => $name])) {
            $name = $this->uniqueGroupName($name);
        }

        /** @var ButtonGroup $group */
        $group = $this->modx->newObject(ButtonGroup::class);
        $group->fromArray([
            'name' => $name,
            'rank' => $this->nextGroupRank(),
            'createdon' => date('Y-m-d H:i:s'),
            'createdby' => (int) $this->modx->user->get('id'),
        ], '', true);
        if (!$group->save()) {
            throw new \RuntimeException($this->modx->lexicon('managerbuttons_err_save'));
        }

        $ugIds = [];
        foreach ((array) ($data['usergroups'] ?? []) as $ugName) {
            $ug = $this->modx->getObject(modUserGroup::class, ['name' => (string) $ugName]);
            if ($ug) {
                $ugIds[] = (int) $ug->get('id');
            }
        }
        $this->syncGroupUserGroups((int) $group->get('id'), $ugIds);

        $rank = 0;
        foreach ((array) ($data['buttons'] ?? []) as $item) {
            if (!is_array($item) || empty($item['name']) || empty($item['url'])) {
                continue;
            }
            /** @var Button $button */
            $button = $this->modx->newObject(Button::class);
            $button->fromArray([
                'group_id' => (int) $group->get('id'),
                'name' => (string) $item['name'],
                'url' => (string) $item['url'],
                'icon' => Icons::normalizeName((string) ($item['icon'] ?? '')),
                'cols' => $this->normalizeCols($item['cols'] ?? 1),
                'rank' => isset($item['rank']) ? (int) $item['rank'] : $rank,
            ], '', true);
            $button->save();
            $rank++;
        }

        return $group;
    }

    public function uniqueGroupName(string $base): string
    {
        $base = trim($base);
        $suffix = $this->modx->lexicon('managerbuttons_copy_suffix') ?: ' (copy)';
        $name = $base . $suffix;
        $i = 2;
        while ($this->modx->getCount(ButtonGroup::class, ['name' => $name])) {
            $name = $base . $suffix . ' ' . $i;
            $i++;
        }

        return $name;
    }

    public function duplicateGroup(ButtonGroup $group): ButtonGroup
    {
        return $this->importGroup($this->exportGroup($group), true);
    }

    public function removeGroup(ButtonGroup $group): bool
    {
        $id = (int) $group->get('id');
        $this->modx->removeCollection(Button::class, ['group_id' => $id]);
        $this->modx->removeCollection(GroupUserGroup::class, ['group_id' => $id]);

        return $group->remove();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getDashboardGroups(?int $onlyGroupId = null): array
    {
        $c = $this->modx->newQuery(ButtonGroup::class);
        if ($onlyGroupId) {
            $c->where(['id' => $onlyGroupId]);
        }
        $c->sortby('rank', 'ASC');
        $c->sortby('id', 'ASC');

        $out = [];
        foreach ($this->modx->getIterator(ButtonGroup::class, $c) as $group) {
            $id = (int) $group->get('id');
            if (!$this->canAccessGroup($id)) {
                continue;
            }
            $buttons = [];
            $bc = $this->modx->newQuery(Button::class);
            $bc->where(['group_id' => $id]);
            $bc->sortby('rank', 'ASC');
            $bc->sortby('id', 'ASC');
            foreach ($this->modx->getIterator(Button::class, $bc) as $button) {
                $buttons[] = [
                    'id' => (int) $button->get('id'),
                    'name' => (string) $button->get('name'),
                    'url' => $this->resolveUrl((string) $button->get('url')),
                    'raw_url' => (string) $button->get('url'),
                    'icon' => Icons::cssClass((string) $button->get('icon')),
                    'cols' => $this->normalizeCols($button->get('cols')),
                ];
            }
            $out[] = [
                'id' => $id,
                'name' => (string) $group->get('name'),
                'buttons' => $buttons,
            ];
        }

        return $out;
    }

    public function addVueModule(modManagerController $controller, string $src): void
    {
        static $checkRegistered = false;
        if (!$checkRegistered) {
            $this->registerVueCoreCheck($controller);
            $checkRegistered = true;
        }
        $controller->addHtml('<script type="module" data-vue-module src="' . htmlspecialchars($src, ENT_QUOTES) . '"></script>');
    }

    protected function registerVueCoreCheck(modManagerController $controller): void
    {
        $message = $this->modx->lexicon('managerbuttons_vuetools_required')
            ?: 'VueTools 1.2.0+ is required. Install it from Package Manager.';
        $title = $this->modx->lexicon('managerbuttons_error') ?: 'Error';
        $messageJs = json_encode($message, JSON_UNESCAPED_UNICODE);
        $titleJs = json_encode($title, JSON_UNESCAPED_UNICODE);
        $script = <<<JS
<script>
(function () {
    var map = document.querySelector('script[type="importmap"]');
    var ok = false;
    if (map) {
        try {
            var imports = JSON.parse(map.textContent).imports;
            ok = !!(imports && imports.vue && imports['vuetools/theme']);
        } catch (e) { ok = false; }
    }
    if (!ok) {
        document.querySelectorAll('script[type="module"][data-vue-module]').forEach(function (el) { el.remove(); });
        if (typeof MODx !== 'undefined' && MODx.msg) { MODx.msg.alert({$titleJs}, {$messageJs}); }
        window.MANAGERBUTTONS_VUE_CORE_MISSING = true;
    }
})();
</script>
JS;
        $controller->addHtml($script);
    }

    public function createTables(): bool
    {
        $manager = $this->modx->getManager();
        if (!$manager) {
            return false;
        }
        foreach ([ButtonGroup::class, Button::class, GroupUserGroup::class] as $class) {
            $table = $this->modx->getTableName($class);
            if (!$table) {
                continue;
            }
            $quoted = str_replace('`', '', $table);
            $exists = false;
            $stmt = $this->modx->query("SHOW TABLES LIKE " . $this->modx->quote($quoted));
            if ($stmt && $stmt->fetch(\PDO::FETCH_NUM)) {
                $exists = true;
            }
            if (!$exists) {
                $manager->createObjectContainer($class);
            }
        }

        return true;
    }
}
