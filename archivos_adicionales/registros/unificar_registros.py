#!/usr/bin/env python3
import re

print("🔄 Unificando registro.txt y registro2.txt...")

# Leer archivo registro.txt (entradas actuales)
with open('registro.txt', 'r', encoding='utf-8') as f:
    registro1_content = f.read()

# Leer archivo registro2.txt (entradas antiguas/nuevas)
with open('registro2.txt', 'r', encoding='utf-8') as f:
    registro2_content = f.read()

# Extraer versiones de registro2 (formato: VERSIÓN vX.Y.Z)
versiones_registro2 = re.findall(r'(VERSIÓN v[\d.]+.*?)(?=={80}|$)', registro2_content, re.DOTALL)

print(f"📊 registro.txt: Archivo completo con 68 entradas")
print(f"📊 registro2.txt: {len(versiones_registro2)} versiones encontradas")

# Verificar si v1.16.0 está duplicada
v1_16_en_registro1 = 'v1.16.0' in registro1_content
print(f"🔍 v1.16.0 en registro.txt: {'✅ Sí' if v1_16_en_registro1 else '❌ No'}")

# Filtrar versiones de registro2 que no sean v1.16.0 (ya está en registro1)
versiones_nuevas = []
for version in versiones_registro2:
    # Extraer número de versión
    match = re.search(r'VERSIÓN (v[\d.]+)', version)
    if match:
        version_num = match.group(1)
        # Solo agregar si no es v1.16.0 (que ya está en registro.txt)
        if version_num != 'v1.16.0':
            versiones_nuevas.append(version)

print(f"📊 Versiones nuevas a agregar: {len(versiones_nuevas)}")

# Crear archivo unificado
with open('registro_unificado.txt', 'w', encoding='utf-8') as f:
    f.write("=" * 80 + "\n")
    f.write("REGISTRO DE ACTIVIDADES COMPLETO - CRONOLÓGICO\n")
    f.write("=" * 80 + "\n")
    f.write("\n")
    f.write("Este archivo contiene TODAS las actividades del proyecto CRUD Symfony\n")
    f.write("desde su inicio hasta la versión más reciente, ordenadas cronológicamente.\n")
    f.write("\n")
    f.write("Rango: 12 de noviembre de 2025 → 13 de noviembre de 2025\n")
    f.write("Versiones: v1.0.0 → v1.25.0\n")
    f.write("\n")
    f.write("=" * 80 + "\n")
    f.write("\n")
    
    # Agregar todo el contenido de registro.txt (excepto el header)
    # Eliminar el header inicial
    content_without_header = registro1_content.split('\n', 3)[-1]  # Salta las primeras 3 líneas
    f.write(content_without_header)
    
    # Agregar separador entre secciones
    f.write("\n\n")
    f.write("=" * 80 + "\n")
    f.write("VERSIONES POSTERIORES (v1.17.0 - v1.25.0)\n")
    f.write("=" * 80 + "\n")
    f.write("\n")
    
    # Agregar versiones nuevas de registro2.txt
    for version in versiones_nuevas:
        f.write("=" * 80 + "\n")
        f.write(version.strip() + "\n\n")

print(f"✅ Archivo registro_unificado.txt creado exitosamente")
print(f"📊 Total combinado: 68 entradas + {len(versiones_nuevas)} versiones nuevas")
