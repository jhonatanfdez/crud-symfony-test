#!/usr/bin/env python3
import re
from datetime import datetime

# Leer archivo original
with open('registro_actividades.txt', 'r', encoding='utf-8') as f:
    content = f.read()

# Encontrar todas las entradas (desde [fecha] hasta ---)
pattern = r'(\[[\d/]+ [\d:]+ [ap]\.m\.\].*?)(?=\n\[[\d/]+ [\d:]+ [ap]\.m\.\]|$)'
entries = re.findall(pattern, content, re.DOTALL)

# Función para extraer fecha y convertirla
def extract_date(entry):
    match = re.search(r'\[(\d{2})/(\d{2})/(\d{4}) (\d{2}):(\d{2}):(\d{2}) ([ap])\.m\.\]', entry)
    if match:
        day, month, year, hour, minute, second, ampm = match.groups()
        hour = int(hour)
        if ampm == 'p' and hour != 12:
            hour += 12
        elif ampm == 'a' and hour == 12:
            hour = 0
        return datetime(int(year), int(month), int(day), hour, int(minute), int(second))
    return datetime.min

# Ordenar entradas por fecha
sorted_entries = sorted(entries, key=extract_date)

# Crear archivo nuevo
with open('registro.txt', 'w', encoding='utf-8') as f:
    f.write("REGISTRO DE ACTIVIDADES - CRONOLÓGICO\n")
    f.write("======================================\n")
    f.write("\n")
    
    for entry in sorted_entries:
        f.write("---\n\n")
        f.write(entry.strip() + "\n\n")
    
    f.write("---\n")

print(f"✅ Archivo creado con {len(sorted_entries)} entradas")
print(f"📊 Primera entrada: {extract_date(sorted_entries[0])}")
print(f"📊 Última entrada: {extract_date(sorted_entries[-1])}")
