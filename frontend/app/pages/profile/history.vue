<template>
  <div>
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div class="flex gap-2">
        <button
          v-for="f in filters" :key="f.value"
          @click="activeFilter = f.value"
          :class="['rounded-lg px-3.5 py-1.5 text-[12px] font-medium transition-all duration-300',
            activeFilter === f.value
              ? 'bg-red-600/15 text-red-400'
              : 'bg-white/[0.03] text-white/25 hover:bg-white/[0.05] hover:text-white/40']"
        >
          {{ f.label }}
        </button>
      </div>
      <span class="text-[12px] text-white/15">{{ filteredTransactions.length }} transactions</span>
    </div>

    <div v-if="filteredTransactions.length" class="rounded-xl border border-white/[0.04] bg-white/[0.02] overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-white/[0.04]">
              <th class="px-5 py-3 text-left text-[11px] font-medium uppercase tracking-wider text-white/20">Type</th>
              <th class="px-5 py-3 text-left text-[11px] font-medium uppercase tracking-wider text-white/20">Description</th>
              <th class="px-5 py-3 text-right text-[11px] font-medium uppercase tracking-wider text-white/20">Amount</th>
              <th class="px-5 py-3 text-right text-[11px] font-medium uppercase tracking-wider text-white/20">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="tx in filteredTransactions" :key="tx.id"
              class="border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
              <td class="px-5 py-3.5">
                <span :class="['inline-flex items-center gap-1.5 rounded px-2 py-0.5 text-[10px] font-medium uppercase tracking-wider', typeClasses[tx.type]]">
                  <span class="h-1 w-1 rounded-full" :class="typeDotClasses[tx.type]" />
                  {{ tx.type }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-[13px] text-white/50">{{ tx.description }}</td>
              <td class="px-5 py-3.5 text-right">
                <span :class="['font-display text-[13px] font-bold tabular-nums', tx.amount > 0 ? 'text-emerald-400' : 'text-red-400']">
                  {{ tx.amount > 0 ? '+' : '' }}{{ tx.amount }} Toll
                </span>
              </td>
              <td class="px-5 py-3.5 text-right text-[12px] text-white/20">{{ tx.date }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <EmptyState v-else title="No transactions yet" subtitle="Your purchase and donation history will appear here" />
  </div>
</template>

<script setup lang="ts">
interface Transaction {
  id: number
  type: 'purchase' | 'donate' | 'promo' | 'refund'
  description: string
  amount: number
  date: string
}

const filters = [
  { label: 'All', value: 'all' },
  { label: 'Purchases', value: 'purchase' },
  { label: 'Donations', value: 'donate' },
  { label: 'Promo Codes', value: 'promo' },
]

const activeFilter = ref('all')

const transactions = reactive<Transaction[]>([
  { id: 1, type: 'purchase', description: 'Stormwing Mount', amount: -500, date: 'Apr 3, 2026' },
  { id: 2, type: 'donate', description: 'Balance top-up via PayPal', amount: 1000, date: 'Apr 2, 2026' },
  { id: 3, type: 'promo', description: 'Promo code WELCOME2026', amount: 100, date: 'Apr 1, 2026' },
  { id: 4, type: 'purchase', description: 'Daevanion Skill Box x3', amount: -750, date: 'Mar 30, 2026' },
  { id: 5, type: 'donate', description: 'Balance top-up via SBP', amount: 500, date: 'Mar 28, 2026' },
  { id: 6, type: 'refund', description: 'Refund — duplicate purchase', amount: 500, date: 'Mar 27, 2026' },
  { id: 7, type: 'purchase', description: 'Appearance Change Ticket', amount: -200, date: 'Mar 25, 2026' },
])

const filteredTransactions = computed(() =>
  activeFilter.value === 'all'
    ? transactions
    : transactions.filter(t => t.type === activeFilter.value),
)

const typeClasses: Record<string, string> = {
  purchase: 'bg-red-500/10 text-red-400',
  donate: 'bg-emerald-500/10 text-emerald-400',
  promo: 'bg-gold-500/10 text-gold-400',
  refund: 'bg-sky-500/10 text-sky-400',
}

const typeDotClasses: Record<string, string> = {
  purchase: 'bg-red-400',
  donate: 'bg-emerald-400',
  promo: 'bg-gold-400',
  refund: 'bg-sky-400',
}
</script>
