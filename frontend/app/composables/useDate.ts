export function useDate() {
  const config = useRuntimeConfig()
  const tz = config.public.serverTimezone as string

  function relative(date: string): string {
    if (!date) return 'Just now'
    const d = new Date(date)
    if (isNaN(d.getTime())) return 'Just now'
    const diff = Date.now() - d.getTime()
    if (diff < 60000) return 'Just now'
    if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`
    if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`
    if (diff < 604800000) return `${Math.floor(diff / 86400000)}d ago`
    return d.toLocaleDateString('en', { month: 'short', day: 'numeric' })
  }

  function time(date: string): string {
    return new Date(date).toLocaleTimeString('en', { hour: '2-digit', minute: '2-digit' })
  }

  function datetime(date: string): string {
    return new Date(date).toLocaleString('en', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })
  }

  function full(date: string): string {
    return new Date(date).toLocaleDateString('en', { year: 'numeric', month: 'short', day: 'numeric' })
  }

  function serverNow(): { hour: number; day: number } {
    const fmt = new Intl.DateTimeFormat('en-US', {
      timeZone: tz,
      hour: 'numeric',
      hour12: false,
      weekday: 'short',
    })
    const parts = fmt.formatToParts(new Date())
    const hour = Number(parts.find(p => p.type === 'hour')?.value ?? 0)
    const weekday = parts.find(p => p.type === 'weekday')?.value ?? 'Mon'
    const dayMap: Record<string, number> = { Mon: 0, Tue: 1, Wed: 2, Thu: 3, Fri: 4, Sat: 5, Sun: 6 }
    return { hour, day: dayMap[weekday] ?? 0 }
  }

  function serverDay(): number {
    return serverNow().day
  }

  function serverHour(): number {
    return serverNow().hour
  }

  return { relative, time, datetime, full, serverNow, serverDay, serverHour }
}
