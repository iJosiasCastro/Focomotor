# Instructions 
- Use Node 14
- To change API connection: change the urls from .env and nuxt.config.js:93, nuxt.config.js:93:103

# npm
npm install
npm run dev
npm run build

# pm2  usage
npm install pm2@latest -g
pm2 start npm --name $app-name -- run start
pm2 save
pm2 ls  
pm2 delete [id]
