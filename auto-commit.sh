#!/bin/bash

# Automatische commit en push script
# Gebruik: ./auto-commit.sh

echo "🚀 Automatische commit en push gestart..."
echo "Watching voor bestandswijzigingen en nieuwe bestanden..."

# Oneindige loop om bestanden te monitoren
while true; do
    # Check voor wijzigingen (inclusief nieuwe bestanden)
    if ! git diff-index --quiet HEAD -- || [ -n "$(git ls-files --others --exclude-standard)" ]; then
        echo "📝 Wijzigingen of nieuwe bestanden gedetecteerd, committen..."
        
        # Voeg alle wijzigingen toe (inclusief nieuwe bestanden)
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