<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\WikiCategory;
use App\Models\WikiEntry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

final class WikiSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        WikiEntry::truncate();
        WikiCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $cats = [
            ['name' => 'Rates', 'slug' => 'rates', 'sort_order' => 0],
            ['name' => 'General', 'slug' => 'general', 'sort_order' => 1],
            ['name' => 'PvP & Abyss', 'slug' => 'pvp', 'sort_order' => 2],
            ['name' => 'Craft & Economy', 'slug' => 'craft', 'sort_order' => 3],
            ['name' => 'Instances', 'slug' => 'instances', 'sort_order' => 4],
            ['name' => 'Other', 'slug' => 'other', 'sort_order' => 5],
        ];

        $catMap = [];
        foreach ($cats as $cat) {
            $catMap[$cat['slug']] = WikiCategory::create($cat)->id;
        }

        $now = now();
        $sort = 0;
        $rows = [];

        $add = function (string $catSlug, string $type, array $content) use (&$rows, &$sort, $now, $catMap) {
            $rows[] = [
                'wiki_category_id' => $catMap[$catSlug],
                'type' => $type,
                'content' => json_encode($content),
                'sort_order' => $sort++,
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        };

        // ── Rates ──
        $add('rates', 'text', ['body' => 'Server rates are designed to offer a comfortable mid-rate experience. You\'ll progress through the game faster than retail, but the journey still has meaning. All rates are applied server-wide with no VIP or donor boosts.']);
        $add('rates', 'callout', ['callout_type' => 'tip', 'body' => 'Group play is highly encouraged. While EXP rates are x3, instance drops are x2 — forming a static group for daily instances is the fastest way to gear up.']);
        $add('rates', 'table', ['title' => 'Experience & Drop', 'rows' => [['EXP rate', 'x3'], ['Quest EXP', 'x3'], ['Kinah rate', 'x3'], ['Drop rate', 'x2'], ['Abyss Points', 'x2'], ['Gathering', 'x2'], ['Crafting', 'x2']]]);
        $add('rates', 'table', ['title' => 'Group & Instance', 'rows' => [['Group EXP bonus', 'Retail (x1)'], ['Instance drop', 'x2'], ['Instance cooldown', 'Retail'], ['Mentor EXP', 'x3']]]);
        $add('rates', 'spoiler', ['title' => 'How long does it take to reach max level?', 'body' => 'With x3 rates, an experienced player can reach level 55 in about 3-5 days of active play. New players should expect 7-10 days, depending on class and playstyle. Campaign quests give the most EXP — don\'t skip them.']);
        $add('rates', 'spoiler', ['title' => 'Does the rate change for high-level content?', 'body' => 'No. Rates are flat across all levels. There\'s no rate reduction after level 50. Instance cooldowns and drop tables are identical to retail 3.9 — the only difference is drop quantity (x2).']);

        // ── General ──
        $add('general', 'text', ['body' => 'AionUCP runs on a stable 3.9 build — the most beloved era of classic Aion. All game systems, quests, instances, and mechanics are faithful to the original Korean 3.9 patch. The server is hosted on dedicated hardware in Frankfurt, Germany.']);
        $add('general', 'callout', ['callout_type' => 'note', 'body' => 'The server runs 24/7 with automatic restarts every Wednesday at 06:00 CET for maintenance. Typical downtime: under 10 minutes.']);
        $add('general', 'table', ['title' => 'Server', 'rows' => [['Version', '3.9 Classic'], ['Location', 'Germany (Frankfurt)'], ['Max level', '55'], ['Startup gear', 'None — classic progression'], ['Flight time', 'Retail'], ['Stigma slots', '6 regular + 6 greater (lv. 55)'], ['Max character slots', '8 per account'], ['Dual box', 'Allowed (2 clients max)']]]);
        $add('general', 'table', ['title' => 'Restrictions', 'rows' => [['Bot protection', 'GameGuard + manual GM patrol'], ['Cheat detection', 'Active, instant ban'], ['Chat restrictions', 'Lv. 10 for LFG, Lv. 5 for whisper'], ['Trade restrictions', 'None after Lv. 10']]]);
        $add('general', 'callout', ['callout_type' => 'warning', 'body' => 'Third-party tools, macros, and automation software result in a permanent ban. This includes auto-clickers, speed hacks, and fly hacks. First offense = permanent, no exceptions.']);
        $add('general', 'spoiler', ['title' => 'Can I transfer my character from another server?', 'body' => 'No. Character transfers from other private servers or retail are not supported. Everyone starts fresh — that\'s part of the experience.']);
        $add('general', 'spoiler', ['title' => 'What client version do I need?', 'body' => 'Download the client from our website. The launcher will auto-patch to the correct version. If you have an existing Aion 3.x client, the launcher can patch it — but a clean install is recommended for stability.']);

        // ── PvP ──
        $add('pvp', 'text', ['body' => 'PvP is the heart of Aion. The Abyss, fortresses, Dredgion, and open-world rifts are all fully operational. AP rates are doubled — climbing the ranks is faster, but rank decay still applies weekly.']);
        $add('pvp', 'callout', ['callout_type' => 'tip', 'body' => 'Fortress sieges happen daily. Check the Schedule page for exact times. Divine Fortress on Saturday/Sunday is the biggest fight of the week.']);
        $add('pvp', 'table', ['title' => 'Abyss', 'rows' => [['AP rate', 'x2'], ['AP loss on death', 'Retail (percentage-based)'], ['Rank decay', 'Weekly, retail formula'], ['Siege schedule', 'Daily — see Schedule page'], ['Fortress rewards', 'Retail + bonus chest'], ['Dredgion', 'Daily, multiple time slots']]]);
        $add('pvp', 'table', ['title' => 'Open World PvP', 'rows' => [['Rifts', 'Every 2 hours, rotating direction'], ['PvP kill AP', 'x2 (no AP from grey kills)'], ['Arena cooldown', 'Retail'], ['Discipline/Chaos', '1 entry per day']]]);
        $add('pvp', 'spoiler', ['title' => 'How does rank decay work?', 'body' => 'Rank points decay every Monday at 09:00 CET. The decay rate follows the original retail formula — higher ranks lose a larger percentage. To maintain Governor or Commander rank, you need to stay active in sieges and PvP throughout the week. Inactive players will drop ranks quickly.']);
        $add('pvp', 'spoiler', ['title' => 'Are there any PvP restrictions?', 'body' => 'Grey kills (enemies 10+ levels below you) give zero AP. This prevents griefing low-level players. Guard kills in enemy territory give reduced AP. Everything else follows retail rules.']);
        $add('pvp', 'callout', ['callout_type' => 'warning', 'body' => 'Kill trading (repeatedly killing the same player to farm AP) is detected and punished. Offenders receive an AP reset and a 7-day ban.']);

        // ── Craft ──
        $add('craft', 'table', ['title' => 'Crafting', 'rows' => [['Craft rate', 'x2'], ['Proc rate', 'Retail'], ['Expert / Master', '2 expert, 1 master per character'], ['Work order EXP', 'x2'], ['Material drop', 'x2'], ['Godstone socket', 'Retail rate'], ['Enchantment rates', 'Retail (no custom modifications)']]]);
        $add('craft', 'table', ['title' => 'Economy', 'rows' => [['Broker fee', 'Retail (10% sell, 20% cancel)'], ['Kinah cap', 'No cap'], ['Gold seller protection', 'Auto-ban system active'], ['Shop currency', 'Toll (cosmetics only)']]]);

        // ── Instances ──
        $add('instances', 'text', ['body' => 'All 3.9 instances are available and fully scripted. Boss mechanics, loot tables, and cooldowns match the original patch. Instance drop rate is x2.']);
        $add('instances', 'table', ['title' => 'Endgame (Lv. 55)', 'rows' => [['Beshmundir Temple', '6-man · 22h CD'], ['Udas Temple', '6-man · 12h CD'], ['Empyrean Crucible', '6-man · 22h CD'], ['Padmarashka\'s Cave', 'Alliance · 6d CD'], ['Esoterrace', '6-man · 22h CD'], ['Draupnir Cave', '6-man · 22h CD']]]);
        $add('instances', 'spoiler', ['title' => 'Beshmundir Temple — loot details', 'body' => 'BT drops Staterunner / Abyssal sets from the final boss (Stormwing). Hard mode is available once per week and guarantees an eternal-grade weapon box. Accessory drops from mid-bosses are retail rate. The instance is fully scripted including the bridge event and hidden boss.']);
        $add('instances', 'table', ['title' => 'Leveling & Solo', 'rows' => [['Kromede\'s Trial', 'Solo · 22h CD'], ['Taloc\'s Hollow', 'Solo · 22h CD'], ['Steel Rake', '6-man · 12h CD'], ['Fire Temple', '6-man · 6h CD'], ['Sulfur Tree Nest', '6-man · 6h CD']]]);
        $add('instances', 'table', ['title' => 'PvP Instances', 'rows' => [['Dredgion', '6v6 PvPvE · Daily'], ['Chantra Dredgion', '6v6 PvPvE · Daily'], ['Terath Dredgion', '6v6 PvPvE · Weekend']]]);
        $add('instances', 'callout', ['callout_type' => 'note', 'body' => 'Instance timers reset daily at 09:00 CET. Alliance instances (Padmarashka, etc.) reset weekly on Monday.']);

        // ── Other ──
        $add('other', 'table', ['title' => 'Donation', 'rows' => [['Donation currency', 'Toll'], ['Toll shop items', 'Cosmetics, mounts, pets, scrolls'], ['Pay-to-win items', 'None. No gear, stones, or enchants'], ['Toll gifting', 'Disabled']]]);
        $add('other', 'table', ['title' => 'Events', 'rows' => [['Schedule', 'Monthly themed events'], ['Double AP weekends', '1-2 per month'], ['Holiday events', 'Christmas, Halloween, Anniversary'], ['GM events', 'Weekly hide-and-seek, trivia']]]);
        $add('other', 'table', ['title' => 'Support', 'rows' => [['Discord', '24/7 community + ticket system'], ['GM online', 'Daily 14:00–02:00 CET'], ['Response time', 'Under 24 hours (usually < 4h)'], ['Bug reports', 'Discord #bug-reports channel']]]);

        WikiEntry::insert($rows);
        Cache::forget('wiki:public');
    }
}
