#!/usr/bin/env bash
docker-compose -p msa down
sudo rm -rf databases/
mkdir -p databases
cp -n .env.example .env
docker-compose -p msa up -d

