# Phalcon skeleton

## Create an empty repository and add submodule

```bash
git submodule add git@github.com:YerlenZhubangaliyev/skel.git _skel
git submodule init
git submodule update
git submodule foreach git pull origin master
```

## Run init script

```bash
_skel/bin/init.sh <ENV>
```

## Pass to php Env variables

```bash
ENVIRONMENT=<ENV>
APPLICATION=<APP>
```

## Fill database credentials and domain/host

```bash
nano src/App/Applications/<APP>/Config/<ENV>.php
```
