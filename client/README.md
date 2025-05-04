# install nvm
Download and install nvm:

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
Activate nvm in your shell:
After installation, either restart your terminal, or run:

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
Verify nvm is installed:

command -v nvm

Conectare en CP por el ssh default de node 16

fix:
ls -l node_modules/.bin/nuxt
-rw-r--r-- 1 user user ... node_modules/.bin/nuxt
chmod +x node_modules/.bin/nuxt

npm run build


# pm2  usage
npm install pm2@latest -g
pm2 start npm --name $app-name -- run start
pm2 save
pm2 ls  
pm2 delete [id]