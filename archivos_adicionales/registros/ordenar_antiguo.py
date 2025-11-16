#!/usr/bin/env python3
import re
from datetime import datetime

# Leer archivo antiguo
with open('registro_actividades_antiguo.txt', 'r', encoding='utf-8') as f:
    content = f.read()

# Encontrar todas las versiones (VERSIÓN vX.Y.Z hasta el siguiente VERSIÓN o final)
pattern = r'(VERSIÓN v[\d.]+.*?)(?=VERSIÓN v[\d.]|$)'
entries = re.findall(pattern, content, re.DOTALL)

print(f"📊 Encontradas {len(entries)} versiones en el archivo antiguo")

# Función para extraer fecha de cada versión
def extract_date(entry):
    # Buscar "Fecha: DD de MES de YYYY"
    patterns = [
        r'Fecha:\s*(\d{1,2})\s+de\s+(\w+)\s+de\s+(\d{4})',
        r'Fecha:\s*(\d{1,2})/(\d{1,2})/(\d{4})'
    ]
    
    meses = {
        'enero': 1, 'febrero': 2, 'marzo': 3, 'abril': 4,
        'mayo': 5, 'junio': 6, 'julio': 7, 'agosto': 8,
        'septiembre': 9, 'octubre': 10, 'noviembre': 11, 'diciembre': 12
    }
    
    for pattern in patterns:
        match = re.search(pattern, entry, re.IGNORECASE)
        if match:
            if '/' in pattern:
                day, month, year = match.groups()
                return datetime(int(year), int(month), int(day))
            else:
                day, month_name, year = match.groups()
                month = meses.get(month_name.lower(), 1)
                # Extraer hora si existe (HH:MM AM/PM)
                time_match = re.search(r'(\d{1,2}):(\d{2})\s*(AM|PM)', entry, re.IGNORECASE)
                if time_match:
                    hour, minute, ampm = time_match.groups()
                    hour = int(hour)
                    if ampm.upper() == 'PM' and hour != 12:
                        hour += 12
                    elif ampm.upper() == 'AM' and hour == 12:
                        hour = 0
                    return datetime(int(year), month, int(day), hour, int(minute))
                else:
                    return datetime(int(year), month, int(day))
    
    return datetime.min

# Ordenar entradas por fecha
sorted_entries = sorted(entries, key=extract_date)

# Crear archivo nuevo
with open('registro2.txt', 'w', encoding='utf-8') as f:
    f.write("REGISTRO DE ACTIVIDADES ANTIGUAS - CRONOLÓGICO\n")
    f.write("==============================================\n")
    f.write("\n")
    
    for i, entry in enumerate(sorted_entries, 1):
        f.write("=" * 80 + "\n")
        f.write(entry.strip() + "\n\n")
    
    f.write("=" * 80 + "\n")

print(f"✅ Archivo registro2.txt creado con {len(sorted_entries)} versiones")
if sorted_entries:
    print(f"📊 Primera versión: {extract_date(sorted_entries[0])}")
    print(f"📊 Última versión: {extract_date(sorted_entries[-1])}")
