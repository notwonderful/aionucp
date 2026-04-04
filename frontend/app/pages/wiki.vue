<template>
  <div class="text-white">

    <!-- Header -->
    <div class="relative overflow-hidden pt-28 pb-16">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.06]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <img src="/img/wing.png" alt="" class="pointer-events-none absolute -right-10 top-10 hidden h-[200px] rotate-[-10deg] object-contain opacity-[0.05] lg:block" />
      <div class="relative mx-auto max-w-[1280px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">{{ t('wiki.title') }}</h1>
        <p class="mt-3 max-w-md text-[15px] text-white/30">{{ t('wiki.desc') }}</p>
      </div>
    </div>

    <!-- Content: sidebar + main -->
    <div class="mx-auto flex max-w-[1280px] gap-10 px-6 pb-24 lg:gap-16">

      <!-- Sidebar nav -->
      <aside class="hidden w-[200px] shrink-0 lg:block">
        <div class="sticky top-24 space-y-1">
          <button v-for="cat in categories" :key="cat.key"
            :class="['flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-[13px] font-medium transition-all duration-300',
              activeCat === cat.key
                ? 'bg-red-600/10 text-red-400'
                : 'text-white/30 hover:bg-white/[0.03] hover:text-white/60']"
            @click="activeCat = cat.key">
            <span :class="['h-1.5 w-1.5 rounded-full transition-colors', activeCat === cat.key ? 'bg-red-500' : 'bg-white/10']" />
            {{ t(cat.labelKey) }}
          </button>
        </div>
      </aside>

      <!-- Mobile category selector -->
      <div class="flex flex-wrap gap-1.5 lg:hidden mb-6">
        <button v-for="cat in categories" :key="cat.key"
          :class="['rounded-lg px-3 py-2 text-[12px] font-medium transition-all',
            activeCat === cat.key ? 'bg-red-600/10 text-red-400' : 'text-white/30 hover:text-white/50']"
          @click="activeCat = cat.key">
          {{ t(cat.labelKey) }}
        </button>
      </div>

      <!-- Main content -->
      <main class="min-w-0 flex-1">
        <!-- Rates -->
        <div v-if="activeCat === 'rates'" class="space-y-8">
          <div class="text-[14px] leading-relaxed text-white/35">
            Server rates are designed to offer a comfortable mid-rate experience. You'll progress through the game faster than retail, but the journey still has meaning. All rates are applied server-wide with no VIP or donor boosts.
          </div>

          <WikiCallout type="tip">
            Group play is highly encouraged. While EXP rates are x3, instance drops are x2 — forming a static group for daily instances is the fastest way to gear up.
          </WikiCallout>

          <WikiSection title="Experience & Drop">
            <WikiTable :rows="[
              ['EXP rate', 'x3'],
              ['Quest EXP', 'x3'],
              ['Kinah rate', 'x3'],
              ['Drop rate', 'x2'],
              ['Abyss Points', 'x2'],
              ['Gathering', 'x2'],
              ['Crafting', 'x2'],
            ]" />
          </WikiSection>

          <WikiSection title="Group & Instance">
            <WikiTable :rows="[
              ['Group EXP bonus', 'Retail (x1)'],
              ['Instance drop', 'x2'],
              ['Instance cooldown', 'Retail'],
              ['Mentor EXP', 'x3'],
            ]" />
          </WikiSection>

          <WikiSpoiler title="How long does it take to reach max level?">
            <p class="text-[13px] leading-relaxed text-white/35">
              With x3 rates, an experienced player can reach level 55 in about 3-5 days of active play. New players should expect 7-10 days, depending on class and playstyle. Campaign quests give the most EXP — don't skip them.
            </p>
          </WikiSpoiler>

          <WikiSpoiler title="Does the rate change for high-level content?">
            <p class="text-[13px] leading-relaxed text-white/35">
              No. Rates are flat across all levels. There's no rate reduction after level 50. Instance cooldowns and drop tables are identical to retail 3.9 — the only difference is drop quantity (x2).
            </p>
          </WikiSpoiler>
        </div>

        <!-- General -->
        <div v-else-if="activeCat === 'general'" class="space-y-8">
          <div class="text-[14px] leading-relaxed text-white/35">
            AionUCP runs on a stable 3.9 build — the most beloved era of classic Aion. All game systems, quests, instances, and mechanics are faithful to the original Korean 3.9 patch. The server is hosted on dedicated hardware in Frankfurt, Germany.
          </div>

          <WikiCallout type="note">
            The server runs 24/7 with automatic restarts every Wednesday at 06:00 CET for maintenance. Typical downtime: under 10 minutes.
          </WikiCallout>

          <WikiSection title="Server">
            <WikiTable :rows="[
              ['Version', '3.9 Classic'],
              ['Location', 'Germany (Frankfurt)'],
              ['Max level', '55'],
              ['Startup gear', 'None — classic progression'],
              ['Flight time', 'Retail'],
              ['Stigma slots', '6 regular + 6 greater (lv. 55)'],
              ['Max character slots', '8 per account'],
              ['Dual box', 'Allowed (2 clients max)'],
            ]" />
          </WikiSection>

          <WikiSection title="Restrictions">
            <WikiTable :rows="[
              ['Bot protection', 'GameGuard + manual GM patrol'],
              ['Cheat detection', 'Active, instant ban'],
              ['Chat restrictions', 'Lv. 10 for LFG, Lv. 5 for whisper'],
              ['Trade restrictions', 'None after Lv. 10'],
            ]" />
          </WikiSection>

          <WikiCallout type="warning">
            Third-party tools, macros, and automation software result in a permanent ban. This includes auto-clickers, speed hacks, and fly hacks. First offense = permanent, no exceptions.
          </WikiCallout>

          <WikiSpoiler title="Can I transfer my character from another server?">
            <p class="text-[13px] leading-relaxed text-white/35">
              No. Character transfers from other private servers or retail are not supported. Everyone starts fresh — that's part of the experience.
            </p>
          </WikiSpoiler>

          <WikiSpoiler title="What client version do I need?">
            <p class="text-[13px] leading-relaxed text-white/35">
              Download the client from our website. The launcher will auto-patch to the correct version. If you have an existing Aion 3.x client, the launcher can patch it — but a clean install is recommended for stability.
            </p>
          </WikiSpoiler>
        </div>

        <!-- PvP -->
        <div v-else-if="activeCat === 'pvp'" class="space-y-8">
          <div class="text-[14px] leading-relaxed text-white/35">
            PvP is the heart of Aion. The Abyss, fortresses, Dredgion, and open-world rifts are all fully operational. AP rates are doubled — climbing the ranks is faster, but rank decay still applies weekly.
          </div>

          <WikiCallout type="tip">
            Fortress sieges happen daily. Check the <a href="/schedule" class="text-red-400 underline underline-offset-2">Schedule page</a> for exact times. Divine Fortress on Saturday/Sunday is the biggest fight of the week.
          </WikiCallout>

          <WikiSection title="Abyss">
            <WikiTable :rows="[
              ['AP rate', 'x2'],
              ['AP loss on death', 'Retail (percentage-based)'],
              ['Rank decay', 'Weekly, retail formula'],
              ['Siege schedule', 'Daily — see Schedule page'],
              ['Fortress rewards', 'Retail + bonus chest'],
              ['Dredgion', 'Daily, multiple time slots'],
            ]" />
          </WikiSection>

          <WikiSection title="Open World PvP">
            <WikiTable :rows="[
              ['Rifts', 'Every 2 hours, rotating direction'],
              ['PvP kill AP', 'x2 (no AP from grey kills)'],
              ['Arena cooldown', 'Retail'],
              ['Discipline/Chaos', '1 entry per day'],
            ]" />
          </WikiSection>

          <WikiSpoiler title="How does rank decay work?">
            <p class="text-[13px] leading-relaxed text-white/35">
              Rank points decay every Monday at 09:00 CET. The decay rate follows the original retail formula — higher ranks lose a larger percentage. To maintain Governor or Commander rank, you need to stay active in sieges and PvP throughout the week. Inactive players will drop ranks quickly.
            </p>
          </WikiSpoiler>

          <WikiSpoiler title="Are there any PvP restrictions?">
            <p class="text-[13px] leading-relaxed text-white/35">
              Grey kills (enemies 10+ levels below you) give zero AP. This prevents griefing low-level players. Guard kills in enemy territory give reduced AP. Everything else follows retail rules.
            </p>
          </WikiSpoiler>

          <WikiCallout type="warning">
            Kill trading (repeatedly killing the same player to farm AP) is detected and punished. Offenders receive an AP reset and a 7-day ban.
          </WikiCallout>
        </div>

        <!-- Craft -->
        <div v-else-if="activeCat === 'craft'" class="space-y-6">
          <WikiSection title="Crafting">
            <WikiTable :rows="[
              ['Craft rate', 'x2'],
              ['Proc rate', 'Retail'],
              ['Expert / Master', '2 expert, 1 master per character'],
              ['Work order EXP', 'x2'],
              ['Material drop', 'x2'],
              ['Godstone socket', 'Retail rate'],
              ['Enchantment rates', 'Retail (no custom modifications)'],
            ]" />
          </WikiSection>
          <WikiSection title="Economy">
            <WikiTable :rows="[
              ['Broker fee', 'Retail (10% sell, 20% cancel)'],
              ['Kinah cap', 'No cap'],
              ['Gold seller protection', 'Auto-ban system active'],
              ['Shop currency', 'Toll (cosmetics only)'],
            ]" />
          </WikiSection>
        </div>

        <!-- Instances -->
        <div v-else-if="activeCat === 'instances'" class="space-y-8">
          <div class="text-[14px] leading-relaxed text-white/35">
            All 3.9 instances are available and fully scripted. Boss mechanics, loot tables, and cooldowns match the original patch. Instance drop rate is x2.
          </div>

          <!-- Legend -->
          <div class="flex flex-wrap gap-4">
            <div v-for="leg in instanceLegend" :key="leg.label" class="flex items-center gap-2">
              <span :class="['h-2.5 w-2.5 rounded-full', leg.color]" />
              <span class="text-[11px] text-white/30">{{ leg.label }}</span>
            </div>
          </div>

          <WikiSection title="Endgame (Lv. 55)">
            <div class="grid gap-3 sm:grid-cols-2">
              <div v-for="inst in instances.filter(i => i.tier === 'endgame')" :key="inst.name"
                class="flex items-start gap-3 rounded-lg border border-white/[0.04] bg-white/[0.02] p-4">
                <span :class="['mt-0.5 h-2 w-2 shrink-0 rounded-full', inst.color]" />
                <div>
                  <div class="text-[13px] font-semibold">{{ inst.name }}</div>
                  <div class="mt-0.5 text-[11px] text-white/25">{{ inst.info }}</div>
                </div>
              </div>
            </div>
          </WikiSection>

          <WikiSpoiler title="Beshmundir Temple — loot details">
            <p class="text-[13px] leading-relaxed text-white/35">
              BT drops Staterunner / Abyssal sets from the final boss (Stormwing). Hard mode is available once per week and guarantees an eternal-grade weapon box. Accessory drops from mid-bosses are retail rate. The instance is fully scripted including the bridge event and hidden boss.
            </p>
          </WikiSpoiler>

          <WikiSection title="Leveling & Solo">
            <div class="grid gap-3 sm:grid-cols-2">
              <div v-for="inst in instances.filter(i => i.tier === 'leveling' || i.tier === 'solo')" :key="inst.name"
                class="flex items-start gap-3 rounded-lg border border-white/[0.04] bg-white/[0.02] p-4">
                <span :class="['mt-0.5 h-2 w-2 shrink-0 rounded-full', inst.color]" />
                <div>
                  <div class="text-[13px] font-semibold">{{ inst.name }}</div>
                  <div class="mt-0.5 text-[11px] text-white/25">{{ inst.info }}</div>
                </div>
              </div>
            </div>
          </WikiSection>

          <WikiSection title="PvP Instances">
            <div class="grid gap-3 sm:grid-cols-2">
              <div v-for="inst in instances.filter(i => i.tier === 'pvp')" :key="inst.name"
                class="flex items-start gap-3 rounded-lg border border-white/[0.04] bg-white/[0.02] p-4">
                <span :class="['mt-0.5 h-2 w-2 shrink-0 rounded-full', inst.color]" />
                <div>
                  <div class="text-[13px] font-semibold">{{ inst.name }}</div>
                  <div class="mt-0.5 text-[11px] text-white/25">{{ inst.info }}</div>
                </div>
              </div>
            </div>
          </WikiSection>

          <WikiCallout type="note">
            Instance timers reset daily at 09:00 CET. Alliance instances (Padmarashka, etc.) reset weekly on Monday.
          </WikiCallout>
        </div>

        <!-- Other -->
        <div v-else-if="activeCat === 'other'" class="space-y-6">
          <WikiSection title="Donation">
            <WikiTable :rows="[
              ['Donation currency', 'Toll'],
              ['Toll shop items', 'Cosmetics, mounts, pets, scrolls'],
              ['Pay-to-win items', 'None. No gear, stones, or enchants'],
              ['Toll gifting', 'Disabled'],
            ]" />
          </WikiSection>
          <WikiSection title="Events">
            <WikiTable :rows="[
              ['Schedule', 'Monthly themed events'],
              ['Double AP weekends', '1-2 per month'],
              ['Holiday events', 'Christmas, Halloween, Anniversary'],
              ['GM events', 'Weekly hide-and-seek, trivia'],
            ]" />
          </WikiSection>
          <WikiSection title="Support">
            <WikiTable :rows="[
              ['Discord', '24/7 community + ticket system'],
              ['GM online', 'Daily 14:00–02:00 CET'],
              ['Response time', 'Under 24 hours (usually < 4h)'],
              ['Bug reports', 'Discord #bug-reports channel'],
            ]" />
          </WikiSection>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { lang, t, setLang } = useLang()
const activeCat = ref('rates')

const categories = [
  { key: 'rates', labelKey: 'wiki.rates' },
  { key: 'general', labelKey: 'wiki.general' },
  { key: 'pvp', labelKey: 'wiki.pvp' },
  { key: 'craft', labelKey: 'wiki.craft' },
  { key: 'instances', labelKey: 'wiki.instances' },
  { key: 'other', labelKey: 'wiki.other' },
]

const instanceLegend = [
  { label: 'Endgame', color: 'bg-red-500' },
  { label: 'Solo', color: 'bg-amber-500' },
  { label: 'Leveling', color: 'bg-sky-500' },
  { label: 'PvP', color: 'bg-purple-500' },
]

const instances = [
  { name: 'Beshmundir Temple', info: 'Lv. 55 · 6-man · 22h CD', color: 'bg-red-500', tier: 'endgame' },
  { name: 'Udas Temple', info: 'Lv. 52+ · 6-man · 12h CD', color: 'bg-red-500', tier: 'endgame' },
  { name: 'Empyrean Crucible', info: 'Lv. 55 · 6-man · 22h CD', color: 'bg-red-500', tier: 'endgame' },
  { name: 'Padmarashka\'s Cave', info: 'Lv. 55 · Alliance · 6d CD', color: 'bg-red-500', tier: 'endgame' },
  { name: 'Esoterrace', info: 'Lv. 55 · 6-man · 22h CD', color: 'bg-red-500', tier: 'endgame' },
  { name: 'Draupnir Cave', info: 'Lv. 55 · 6-man · 22h CD', color: 'bg-red-500', tier: 'endgame' },
  { name: 'Kromede\'s Trial', info: 'Lv. 37+ · Solo · 22h CD', color: 'bg-amber-500', tier: 'solo' },
  { name: 'Taloc\'s Hollow', info: 'Lv. 51+ · Solo · 22h CD', color: 'bg-amber-500', tier: 'solo' },
  { name: 'Steel Rake', info: 'Lv. 40+ · 6-man · 12h CD', color: 'bg-sky-500', tier: 'leveling' },
  { name: 'Fire Temple', info: 'Lv. 30+ · 6-man · 6h CD', color: 'bg-sky-500', tier: 'leveling' },
  { name: 'Sulfur Tree Nest', info: 'Lv. 25+ · 6-man · 6h CD', color: 'bg-sky-500', tier: 'leveling' },
  { name: 'Dredgion', info: 'Lv. 46+ · 6v6 PvPvE · Daily', color: 'bg-purple-500', tier: 'pvp' },
  { name: 'Chantra Dredgion', info: 'Lv. 51+ · 6v6 PvPvE · Daily', color: 'bg-purple-500', tier: 'pvp' },
  { name: 'Terath Dredgion', info: 'Lv. 55 · 6v6 PvPvE · Weekend', color: 'bg-purple-500', tier: 'pvp' },
]
</script>
