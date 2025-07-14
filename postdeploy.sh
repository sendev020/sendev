#!/bin/bash

echo "📁 Création du lien symbolique pour le dossier storage..."

php artisan storage:link

echo "✅ Lien symbolique storage/public créé avec succès."
