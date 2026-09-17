<?php
/** Contract/render tests against real Forumify templates and its real override loader.
 * The repository, security, routes and component data are fixtures, not integration tests.
 * php tests/render.php /path/to/forumify-platform [autoload.php] [preview-directory]
 */
declare(strict_types=1);

require $argv[2] ?? __DIR__ . '/vendor/autoload.php';
$platform = realpath($argv[1] ?? '') ?: throw new RuntimeException('Pass the Forumify source directory.');
spl_autoload_register(static function (string $class) use ($platform): void {
    if (str_starts_with($class, 'Forumify\\')) {
        $file = $platform . '/src/' . str_replace('\\', '/', substr($class, 9)) . '.php';
        if (is_file($file)) require_once $file;
    }
});

use Forumify\Core\Service\ThemeTemplateService;
use Forumify\Core\Twig\ForumifyTemplateLoader;
use Twig\Environment;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

function check(bool $value, string $message): void {
    if (!$value) throw new RuntimeException($message);
    echo "PASS $message\n";
}

// The upstream loader reads PHP_EOL. Normalize fixtures to the executing OS.
$temporary = sys_get_temp_dir() . '/command-net-' . bin2hex(random_bytes(6));
$themeTemplates = dirname(__DIR__) . '/templates';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($themeTemplates));
foreach ($files as $file) {
    if (!$file->isFile()) continue;
    $relative = substr($file->getPathname(), strlen($themeTemplates) + 1);
    $target = $temporary . '/theme/' . $relative;
    if (!is_dir(dirname($target))) mkdir(dirname($target), 0777, true);
    file_put_contents($target, str_replace("\n", PHP_EOL, str_replace("\r\n", "\n", file_get_contents($file->getPathname()))));
}
$serviceReflection = new ReflectionClass(ThemeTemplateService::class);
$service = $serviceReflection->newInstanceWithoutConstructor();
$serviceReflection->getProperty('locations')->setValue($service, [$temporary . '/theme']);
$nativeLoader = new FilesystemLoader();
$nativeLoader->addPath($platform . '/templates', 'Forumify');
$nativeLoader->addPath($platform . '/templates', '!Forumify');
$twig = new Environment(new ChainLoader([new ForumifyTemplateLoader($service, $temporary . '/cache'), $nativeLoader]), ['strict_variables' => true]);
$twig->addExtension(new Twig\Extra\String\StringExtension());

$fixtureUser = (object)['id' => 1, 'username' => 'fixture-user', 'displayName' => 'Fixture User', 'avatar' => null, 'oAuthClient' => null, 'online' => true, 'emailVerified' => true];
$settings = ['forumify.title' => 'Spearhead Gaming', 'forumify.logo' => null, 'forumify.default_avatar' => null];
$display = (object)['showTopicAuthor' => true, 'showTopicStatistics' => true, 'showTopicPreview' => true, 'showTopicLastCommentBy' => true];
$forums = [];
foreach (['hq', 'reaper', 'misfit', 'gambler', 'viking'] as $i => $slug) {
    $forums[] = (object)['id' => $i + 1, 'slug' => $slug, 'title' => strtoupper($slug), 'displaySettings' => clone $display];
}
$denied = [];
$calls = [];
$emptyTopics = false;
$snippet = '';
$app = (object)['locale' => 'en', 'user' => null, 'flashes' => [], 'request' => (object)['requestUri' => '/', 'pathInfo' => '/']];
$twig->addGlobal('app', $app);
$attributes = new class implements Stringable {
    public function defaults(mixed $values): self { return $this; }
    public function __toString(): string { return 'data-fixture-component="true"'; }
};
$repository = new class($forums) {
    public array $forums;
    public function __construct(array $forums) { $this->forums = $forums; }
    public function findBy(array $criteria, array $order): array { return array_values(array_filter($this->forums, fn ($f) => (!isset($criteria['slug']) || in_array($f->slug, $criteria['slug'], true)))); }
    // commandNetPluginActive queries the Plugin entity this way; this suite never installs
    // that plugin, so it should behave exactly as it does when the package is really absent.
    public function findOneBy(array $criteria): ?object { return null; }
};
$functions = [
    'setting' => static fn ($name) => $settings[$name] ?? null,
    'repository' => static fn ($name) => $repository,
    'can' => static function ($permission, $forum) use (&$denied): bool { return !in_array($forum->id, $denied, true); },
    'snippet' => static function ($name) use (&$snippet): string { return $snippet; },
    'asset' => static fn ($path, $package = null) => '/' . $path,
    'absolute_url' => static fn ($path) => 'http://localhost' . $path,
    'path' => static function ($name, $args = []): string {
        return match ($name) {
            'forumify_core_index' => '/',
            'forumify_forum_forum' => '/forum' . (isset($args['slug']) ? '/' . $args['slug'] : ''),
            'forumify_forum_topic' => '/topic/' . $args['slug'],
            default => '/' . str_replace('_', '/', $name),
        };
    },
    'is_granted' => static fn (...$args) => false,
    'is_demo' => static fn () => false,
    'privacy_policy_path' => static fn () => '/privacy',
    'stimulus_controller' => static fn (...$args) => '',
    'stimulus_target' => static fn (...$args) => '',
    'forum_menu' => static fn () => '<a href="/events">Events</a><a href="/resources">Resources</a>',
    'encore_entry_link_tags' => static fn ($name) => '<link rel="stylesheet" href="/native.css">',
    'encore_entry_script_tags' => static fn ($name) => '<!-- native scripts retained -->',
    'theme_tags' => static fn () => '<link rel="stylesheet" href="/theme-vars.css"><link rel="stylesheet" href="/themes/majesticdev/command-net-theme/style.css">',
];
foreach ($functions as $name => $function) $twig->addFunction(new TwigFunction($name, $function, ['is_safe' => ['html']]));
foreach (['imagine_filter', 'short_number', 'rich'] as $filter) $twig->addFilter(new TwigFilter($filter, static fn ($v, ...$args) => $v));
$twig->addFilter(new TwigFilter('trans', static fn ($v, ...$args) => ['login' => 'Sign in', 'toggle_theme' => 'Toggle theme', 'privacy_policy.title' => 'Privacy policy', 'forum.topic.view_all' => 'View all'][$v] ?? $v));
$twig->addFilter(new TwigFilter('role_color', static fn ($v) => null));
// Mirrors Forumify\Core\Twig\Extension\CoreExtension::foregroundColor(), used by the
// theme's topic_list.html.twig override for tag-colored category labels.
$twig->addFilter(new TwigFilter('fg_color', static function (string $hex): string {
    $hex = substr($hex, 1);
    $r = hexdec(substr($hex, 0, 2)) / 255;
    $g = hexdec(substr($hex, 2, 2)) / 255;
    $b = hexdec(substr($hex, 4, 2)) / 255;
    $l = (max($r, $g, $b) + min($r, $g, $b)) / 2;
    return $l < 0.4 ? 'white' : 'black';
}));
$twig->addFilter(new TwigFilter('format_date', static fn ($v) => $v->format('M j, H:i')));
$twig->addFilter(new TwigFilter('last_comment', static fn ($v) => $v->firstComment));
$twig->addFunction(new TwigFunction('component', static function ($name, $props = []) use ($twig, $fixtureUser, $attributes, &$calls, &$emptyTopics): string {
    $calls[] = [$name, $props];
    if ($name === 'ReadMarker') return '<span data-native-read-marker></span>';
    if ($name === 'Notifications') return '<button aria-label="Notifications">Notifications</button>';
    if ($name === 'Forumify\\Admin\\OnlineUsers') {
        $component = (object)['title' => 'Online now', 'result' => (object)['rows' => [$fixtureUser], 'totalCount' => 1], 'limit' => 12];
        return $twig->render('@Forumify/admin/dashboard/components/users.html.twig', ['this' => $component, 'attributes' => $attributes]);
    }
    if ($name !== 'TopicList') return '';
    $forum = $props['forum'];
    $comment = (object)['createdBy' => $fixtureUser, 'createdAt' => new DateTimeImmutable('2026-09-14 10:00'), 'content' => '<p>Fixture preview &lt;script&gt; must stay text.</p>'];
    $topic = (object)['slug' => 'fixture-' . $forum->slug, 'title' => 'Fixture discussion for ' . $forum->title, 'pinned' => $forum->slug === 'hq', 'hidden' => false, 'locked' => true, 'tags' => [], 'views' => 42, 'createdBy' => $fixtureUser, 'createdAt' => $comment->createdAt, 'firstComment' => $comment];
    $component = new class {
        public bool $showControls = false;
        public bool $lastPageFirst = false;
        public bool $infiniteScroll = false;
        public bool $disablePagination = true;
        public object $result;
        public function getCommentCount($topic): int { return 8; }
    };
    $component->result = (object)['rows' => $emptyTopics ? [] : [$topic], 'totalCount' => $emptyTopics ? 0 : 1];
    return $twig->render('@Forumify/frontend/components/topic_list.html.twig', ['this' => $component, 'forum' => $forum, 'attributes' => $attributes]);
}, ['is_safe' => ['html']]));

$html = $twig->render('@Forumify/frontend/index.html.twig');
check(str_contains($html, 'cn-shell') && str_contains($html, 'Latest discussions'), 'real override loader resolves shell and dashboard');
check(substr_count($html, 'data-cn-unit=') === 5, 'all five authorized units render');
check(str_contains($html, 'Powered by') && str_contains($html, '/privacy') && str_contains($html, 'native scripts retained'), 'native footer, privacy link and scripts retained');
check(str_contains($html, 'cn-topic-pinned') && str_contains($html, 'data-native-read-marker'), 'pinned topics and read markers render');
check(!str_contains($html, '<script> must'), 'preview HTML stays escaped');
check(str_contains($html, '/core/login') && !str_contains($html, 'Account menu'), 'guest login state');
if (isset($argv[3])) {
    if (!is_dir($argv[3])) mkdir($argv[3], 0777, true);
    file_put_contents($argv[3] . '/index.html', $html);
}
$repository->forums = [(object)['id' => 9, 'slug' => 'general', 'title' => 'General', 'displaySettings' => clone $display]];
$htmlFallback = $twig->render('@Forumify/frontend/index.html.twig');
check(str_contains($htmlFallback, 'Fixture discussion for General'), 'non-unit forum fallback renders real accessible forums');
check(substr_count($htmlFallback, 'aria-disabled="true"') === 5, 'unmapped units have disabled navigation instead of broken links');
$repository->forums = $forums;
$denied = [2, 3, 4, 5];
$calls = [];
$html = $twig->render('@Forumify/frontend/index.html.twig');
check(substr_count($html, 'data-cn-unit=') === 1 && !str_contains($html, '/forum/reaper'), 'restricted units omitted before component invocation');
check(count(array_filter($calls, fn ($call) => $call[0] === 'TopicList')) === 1, 'only authorized forum reaches TopicList');
$denied = [1, 2, 3, 4, 5];
$html = $twig->render('@Forumify/frontend/index.html.twig');
check(str_contains($html, 'No unit discussions are available') && !str_contains($html, 'cn-filters'), 'all-restricted state is useful and has no fake filters');
$denied = [];
$emptyTopics = true;
check(str_contains($twig->render('@Forumify/frontend/index.html.twig'), 'No discussions to display.'), 'empty topic lists have explicit states');
$emptyTopics = false;
$app->user = $fixtureUser;
$html = $twig->render('@Forumify/frontend/index.html.twig');
check(str_contains($html, 'Account menu') && str_contains($html, 'Notifications') && str_contains($html, 'Messages'), 'member account and notification controls retained');
$snippet = '<h2>Fixture operation briefing</h2>';
check(str_contains($twig->render('@Forumify/frontend/index.html.twig'), $snippet), 'CMS operation snippet rendered');
$repository->forums = [];
check(str_contains($twig->render('@Forumify/frontend/index.html.twig'), 'No unit discussions'), 'missing configured forums handled');
$html = $twig->render('@Forumify/frontend/forum/list.html.twig', ['forum' => null, 'groups' => [], 'ungroupedForums' => [], 'groupedForums' => []]);
check(str_contains($html, 'cn-shell') && !str_contains($html, 'Latest discussions'), 'forum index keeps native body inside shell');
$html = $twig->createTemplate("{% extends '@Forumify/frontend/base.html.twig' %}{% block body %}<h1>Existing CMS page</h1>{% endblock %}")->render();
check(str_contains($html, '<h1>Existing CMS page</h1>') && !str_contains($html, 'Latest discussions'), 'custom CMS content is not replaced by dashboard');
echo "Template contract checks complete. Live Symfony/Doctrine/Stimulus behavior requires an installed instance.\n";
