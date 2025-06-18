#!/bin/bash

# Automatische commit en push script
# Gebruik: ./auto-commit.sh

echo "🚀 Automatische commit en push gestart..."
echo "Watching voor bestandswijzigingen..."

# Oneindige loop om bestanden te monitoren
while true; do
    # Check voor wijzigingen
    if ! git diff-index --quiet HEAD --; then
        echo "📝 Wijzigingen gedetecteerd, committen..."
        
        # Voeg alle wijzigingen toe
        git add .
        
        # Commit met timestamp
        timestamp=$(date "+%Y-%m-%d %H:%M:%S")
        git commit -m "Auto-commit: $timestamp"
        
        # Push naar remote
        echo "🔄 Pushen naar remote..."
        git push origin main
        
        echo "✅ Automatisch gecommit en gepusht om $timestamp"
        echo "----------------------------------------"
    fi
    
    # Wacht 2 seconden voor de volgende check
    sleep 2
done 