export function useDate() {
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

  return { relative, time, datetime, full }
}
