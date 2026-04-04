export default defineEventHandler(async (event) => {
  const target = 'http://aionucp.local' + event.path
  return proxyRequest(event, target)
})
