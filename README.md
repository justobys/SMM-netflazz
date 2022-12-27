
Folder dan file yang diubah untuk pengInstallan :

(Setting koneksi)
* config.php
* lib/setting.php

(Setting Email)
* auth/forgot-password.php
* auth/register.php
* auth/verification-account.php

(Setting Payment Gateway TriPay)
* ajax/pembayaran-top-up-balance.php
* deposit-balance/index.php

Settingan Cronsjob, Ubah "netswitch" dengan user hosting kalian dan 
ubah "public_html" dengan directory root kalian atau penyimpanan file script kalian

php -q /home/netswitch/public_html/cronsjob/callback_tripay.php
php -q /home/netswitch/public_html/cronsjob/refund-pulsa.php
php -q /home/netswitch/public_html/cronsjob/refund-sosmed.php
php -q /home/netswitch/public_html/cronsjob/refund-top-up.php
php -q /home/netswitch/public_html/cronsjob/status-deposit.php
php -q /home/netswitch/public_html/cronsjob/get-status-sosmed.php
php -q /home/netswitch/public_html/cronsjob/get-status-top-up.php

Login Dashboard Admin Default :
* Username : admin
* Password : netflazz
* Pin      : 123456

Demo (until 25/12/2023) : http://sosmed.me
