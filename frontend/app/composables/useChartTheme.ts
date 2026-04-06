export function useChartTheme() {
  const base = {
    chart: { background: 'transparent', toolbar: { show: false }, zoom: { enabled: false } },
    theme: { mode: 'dark' as const },
    grid: { borderColor: 'rgba(255,255,255,0.04)', strokeDashArray: 3 },
    tooltip: { theme: 'dark', style: { fontSize: '12px' } },
    xaxis: { labels: { style: { colors: 'rgba(255,255,255,0.25)', fontSize: '11px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { labels: { style: { colors: 'rgba(255,255,255,0.25)', fontSize: '11px' } } },
  }

  return { chartTheme: base }
}
