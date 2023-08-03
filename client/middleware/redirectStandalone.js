export default function ({ req, res, redirect }) {
  if (req && req.url && req.url.includes('?standalone=true')) {
    const urlWithoutStandalone = req.url.replace('?standalone=true', '');
    redirect(urlWithoutStandalone);
  }
}
