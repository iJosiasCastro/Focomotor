# pm2  usage
npm install pm2@latest -g
pm2 start npm --name $app-name -- run start
pm2 save
pm2 ls  
pm2 delete