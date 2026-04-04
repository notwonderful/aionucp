export interface NewsArticle {
  id: number
  slug: string
  title: string
  tag: string
  date: string
  image: string | null
  excerpt: string
  body: string
}

const articles: NewsArticle[] = [
  {
    id: 1,
    slug: 'season-2-rise-of-tiamat',
    title: 'Season 2: The rise of Tiamat',
    tag: 'Update',
    date: '2026-04-01',
    image: '/img/bg_39_armor.jpg',
    excerpt: 'Tiamat stronghold, reforged armor, rebalanced Abyss rewards, Kromede\'s Trial returns.',
    body: `## What's new in Season 2

The wait is over. Season 2 brings the most anticipated content update since launch.

### Tiamat Stronghold
The Dragon Lord's fortress is now accessible. This 12-man alliance instance features three wings, each with unique boss mechanics and loot tables. Expect coordination-heavy fights — PUGs will struggle.

**Loot highlights:**
- Tiamat's Wrath weapon set (eternal grade)
- Dragon Lord's armor pieces (randomized stats)
- Tiamat's Eye accessory (unique proc effect)

### Reforged armor sets
All Abyss armor sets have been rebalanced. The gap between 40e and 50e sets has been narrowed — skill matters more than gear now.

### Abyss reward changes
- Fortress capture AP bonus increased by 25%
- Artifact rewards now scale with participation
- New weekly quest chain for consistent AP income

### Kromede's Trial returns
The fan-favorite solo instance is back with updated loot tables. Now drops crafting materials for the new Balic weapon recipes.

### Known issues
- Tiamat phase 3 hitbox is slightly larger than intended — fix incoming next week
- Dragon Lord's Boots have incorrect model for Asmodian females — cosmetic fix in v3.9.8`,
  },
  {
    id: 2,
    slug: 'double-ap-weekend',
    title: 'Double AP weekend',
    tag: 'Event',
    date: '2026-03-28',
    image: '/img/news/abyss.jpg',
    excerpt: 'Earn double Abyss Points this weekend. Push your rank before season end.',
    body: `## Double AP Weekend — March 28-30

All Abyss Point gains are doubled from **Friday 18:00 CET** to **Sunday 23:59 CET**.

### What's affected
- PvP kills (x2 on top of the server x2 rate = effectively x4)
- Fortress siege rewards
- Dredgion AP rewards
- Artifact captures

### What's NOT affected
- AP loss on death (remains retail rate)
- Arena rewards (unchanged)
- Quest AP (unchanged)

### Tips for maximizing AP
1. Focus on fortress sieges — the bonus stacks with capture rewards
2. Run all 3 Dredgion entries per day
3. Avoid dying in the Abyss — AP loss is still painful
4. Group PvP in Reshanta is the fastest AP/hour if you have a coordinated group

This is the last double AP event before Season 2 rank reset. Use it wisely.`,
  },
  {
    id: 3,
    slug: 'hotfix-v397',
    title: 'Hotfix v3.9.7 deployed',
    tag: 'Patch',
    date: '2026-03-20',
    image: '/img/news/s2pt2.jpg',
    excerpt: 'Dredgion timers, Cleric coefficients, fortress windows corrected.',
    body: `## Patch notes — v3.9.7

Deployed: March 20, 2026 at 06:00 CET. Downtime: 8 minutes.

### Bug fixes
- **Dredgion:** Queue timer was resetting when a player disconnected during loading. Fixed — timer now persists through disconnects.
- **Cleric:** Healing Light coefficient was 5% lower than retail. Corrected to match 3.9 KR values.
- **Fortress:** Vulnerability window for Sulfur Fortress was opening 15 minutes late on Wednesdays. Synced with schedule.
- **UI:** Character selection screen showed incorrect online status for characters in instances.
- **Trade:** Broker search was not filtering by level range correctly for accessories.

### Balance changes
- None. This is a bugfix-only patch.

### Server
- Database optimization for player position updates — should reduce micro-stuttering during large sieges.
- Cache layer updated for ranking queries — leaderboard page loads 40% faster.`,
  },
  {
    id: 4,
    slug: 'asmodian-leveling-guide',
    title: 'Asmodian leveling route 1-55',
    tag: 'Guide',
    date: '2026-03-15',
    image: '/img/bg_waterfall.jpg',
    excerpt: 'Optimal leveling path for Asmodian characters, updated for current rates.',
    body: `## Asmodian leveling guide — 1 to 55

Updated for AionUCP x3 rates. Expected time: 3-5 days for experienced players.

### 1-10: Ishalgen
Complete all campaign quests. Don't skip the Aldelle Village chain — it gives a free weapon upgrade. You'll ascend at level 9-10.

### 10-20: Altgard
Campaign quests + Basfelt Village area quests. At level 17, do the Black Claw Village repeatable for fast EXP. Skip gathering quests — they're slow at x3 rates.

### 20-30: Morheim
Focus on the Ice Claw Village and Salintus Desert quest chains. At 25, start running Sulfur Tree Nest for gear upgrades. Fire Temple becomes available at 30 — run it daily.

### 30-40: Brusthonin
The longest stretch. Mix campaign quests with Steel Rake runs (available at 40). The Twilight Battlefield daily is excellent EXP. Consider Kromede's Trial at 37 for weapon upgrades.

### 40-50: Beluslan + Abyss
At 40 you can enter the Abyss. Mix Beluslan campaign quests with Abyss daily quests for AP + EXP. Dredgion becomes available at 46 — queue for it whenever possible.

### 50-55: Gelkmaros + Instances
Campaign quests in Gelkmaros carry you to 52-53. Then grind Udas Temple and Beshmundir Temple groups for the final stretch. Taloc's Hollow at 51 is great solo EXP.

### Tips
- Always log out in a rest zone for bonus EXP on next login
- Join a legion early for the EXP bonus
- Use mentor system if available — mentoring gives x3 on top of server rates`,
  },
  {
    id: 5,
    slug: 'march-siege-results',
    title: 'March siege recap: Asmodians dominate',
    tag: 'News',
    date: '2026-03-10',
    image: '/img/news/gift_new.jpg',
    excerpt: 'Asmodians held Divine Fortress for 3 consecutive weeks. Elyos counter-offensive planned.',
    body: `## March siege recap

### Divine Fortress
Asmodians have held Divine Fortress for 3 consecutive weeks, led by the legion **Shadowfang**. Their wall defense strategy proved nearly impenetrable — Elyos attempts on March 2, 9, and 16 all failed within the first 10 minutes.

### Turning point?
Elyos leadership announced a coordinated push for March 23. Multiple legions are combining forces: **Celestial Guard**, **Dawn Brigade**, and **Radiant Order** have formed a temporary alliance. Over 120 players are expected.

### Lower Abyss
Krotan and Miren remain contested. Kysis has been firmly in Elyos control since February.

### Fun stats from March
- Most AP earned: **Shadowbane** (Asmodian, Assassin) — 847,230 AP
- Most kills in a single siege: **Lumiel** (Elyos, Sorcerer) — 43 kills
- Longest fortress defense: Divine Fortress, 21 days (ongoing)
- Most deaths in a single siege: **xXDarkSlayerXx** (Asmodian, Gladiator) — 17 deaths`,
  },
]

export function useNews() {
  function getAll(): NewsArticle[] {
    return articles
  }

  function getBySlug(slug: string): NewsArticle | undefined {
    return articles.find(a => a.slug === slug)
  }

  function getById(id: number): NewsArticle | undefined {
    return articles.find(a => a.id === id)
  }

  return { getAll, getBySlug, getById }
}
