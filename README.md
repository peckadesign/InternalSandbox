# InternalSandbox

Sandbox pro interní projekty s přihlašováním přes GitHub a Nextras/ORM.


## Příprava nového projektu

1. `$ git clone git@github.com:peckadesign/InternalSandbox.git PeckaProject`
1. `$ cd PeckaProject`
1. `$ rm -rf .git`
1. `$ vim README.md`
1. `$ find app/ -type f -exec sed -i 's/InternalSandbox/PeckaProject/g' {} +`
1. `$ find app/ -type f -exec sed -i 's/internalSandbox/peckaProject/g' {} +`
1. `$ find app/ -type f -exec sed -i 's/internalsandbox/peckaproject/g' {} +`
1. `sed -i 's/InternalSandbox/PeckaProject/' composer.json`
1. `$ cp app/config/config.local.example.neon app/config/config.local.neon` a nastavit nevyplněné údaje
1. `$ vagrant up`
1. `$ vagrant ssh` a `$ php www/index.php migrations:reset`
1. Napojit se na git a GitHub podle návodu na úvodní stránce repozitáře projektu.
