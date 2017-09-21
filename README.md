# BTC Monitor

## Why?
I'm tired of loosing good opportunities to buy or sell BTC on MercadoBitcoin so this script will be scanning the current prices on their API if it reaches my threshold it will send me an email so I can take manual action.

## How?
1) Copy .env.dist to .env and fill out info of your SMTP Server/Account.
2) Copy users.yaml.dist to users.yaml and set your emails/thresholds.
3) Execute ```composer install```
4) Run ```./btcmonitor```

## Help?
This software is licensed under a [WTFPL – Do What the Fuck You Want to Public License](https://en.wikipedia.org/wiki/WTFPL). You can help out by sending an awesome PR or do wtf you want with this code.
