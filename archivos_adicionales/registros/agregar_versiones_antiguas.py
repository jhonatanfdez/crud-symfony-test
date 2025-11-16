#!/usr/bin/env python3
import re

def add_old_versions_to_markdown(input_file='registro.txt', output_file='REGISTRO.md'):
    """
    Agrega las versiones del registro antiguo (v1.17.0 - v1.25.0) al REGISTRO.md
    """
    
    with open(input_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Buscar la sección de versiones posteriores
    match = re.search(r'VERSIONES POSTERIORES.*?(?=^VERSIÓN v|$)', content, re.DOTALL | re.MULTILINE)
    
    if not match:
        print("❌ No se encontró la sección de versiones posteriores")
        return
    
    # Extraer todas las versiones (formato: VERSIÓN vX.Y.Z)
    versions_section = content.split('VERSIONES POSTERIORES')[-1]
    
    # Encontrar todas las versiones individuales
    version_pattern = r'(VERSIÓN v[\d.]+.*?)(?=VERSIÓN v[\d.]|$)'
    versions = re.findall(version_pattern, versions_section, re.DOTALL)
    
    print(f"📊 Versiones antiguas encontradas: {len(versions)}")
    
    # Agregar al archivo Markdown existente
    with open(output_file, 'a', encoding='utf-8') as f:
        f.write("\n\n")
        f.write("=" * 80 + "\n\n")
        f.write("# 📦 VERSIONES POSTERIORES (v1.17.0 - v1.25.0)\n\n")
        f.write("Estas versiones provienen del registro de actividades antiguo.\n\n")
        f.write("---\n\n")
        
        for idx, version in enumerate(versions, 1):
            # Extraer número de versión y título
            title_match = re.search(r'VERSIÓN (v[\d.]+)\s*-\s*(.+?)(?:\n|$)', version)
            if title_match:
                version_num = title_match.group(1)
                title = title_match.group(2).strip()
                
                # Extraer fecha
                date_match = re.search(r'Fecha:\s*(\d{1,2})\s+de\s+(\w+)\s+de\s+(\d{4})(?:,\s*(\d{1,2}:\d{2}\s*[AP]M))?', version, re.IGNORECASE)
                
                fecha = "N/A"
                if date_match:
                    day = date_match.group(1)
                    month = date_match.group(2)
                    year = date_match.group(3)
                    time = date_match.group(4) if date_match.group(4) else ""
                    fecha = f"{day} de {month} de {year}" + (f", {time}" if time else "")
                
                # Escribir header de la versión
                entry_num = 68 + idx  # Continuar numeración desde la 68
                f.write(f"## {entry_num}. {version_num} - {title}\n\n")
                f.write(f"**📅 Fecha:** {fecha}\n\n")
                
                # Procesar contenido de la versión
                lines = version.split('\n')[1:]  # Saltar primera línea (título)
                
                in_code_block = False
                code_buffer = []
                current_lang = 'bash'
                
                for line in lines:
                    line_stripped = line.strip()
                    
                    # Detectar inicio/fin de bloques de código existentes
                    if line_stripped.startswith('```'):
                        if not in_code_block:
                            in_code_block = True
                            lang_match = re.search(r'```(\w+)', line)
                            current_lang = lang_match.group(1) if lang_match else 'bash'
                            code_buffer = []
                            f.write(f"```{current_lang}\n")
                        else:
                            in_code_block = False
                            f.write("```\n\n")
                    elif in_code_block:
                        f.write(f"{line}\n")
                    else:
                        # Detectar secciones importantes
                        if line_stripped.startswith(('OBJETIVO:', 'PROBLEMA:', 'CAMBIOS:', 'IMPLEMENTACIÓN:', 'RESULTADO:', 'ARCHIVOS:')):
                            f.write(f"### {line_stripped}\n\n")
                        # Detectar listas numeradas o con viñetas
                        elif re.match(r'^\d+\.|\-\s', line_stripped):
                            f.write(f"{line}\n")
                        # Detectar rutas de archivos
                        elif '`' in line or any(path in line for path in ['src/', 'templates/', 'config/', '.php', '.twig', '.yaml']):
                            f.write(f"{line}\n")
                        # Texto normal
                        elif line_stripped:
                            f.write(f"{line}\n")
                        else:
                            f.write("\n")
                
                f.write("\n---\n\n")
                
                print(f"  ✅ Agregada: {version_num} - {title}")
    
    print(f"\n✅ Versiones agregadas al archivo: {output_file}")
    
    # Mostrar estadísticas finales
    with open(output_file, 'r', encoding='utf-8') as f:
        lines = f.readlines()
        print(f"📄 Total de líneas final: {len(lines)}")

if __name__ == "__main__":
    add_old_versions_to_markdown()
